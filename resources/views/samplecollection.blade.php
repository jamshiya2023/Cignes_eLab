@extends('layout.mainregister')
@section('content')
<style>
    .modal-lg, .modal-xl {
      max-width: 90%!important;
    }
    .collecteddate{ z-index:99999 !important; }
    button.status-toggle{
        border:0;
        background: unset;
    }
</style>

<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
            <div class="container-fluid">

                <div class="row g-2 row-deck">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h6 class="card-title m-0">Sample Collection</h6>
                                
                            </div>
                            <div class="card-body">
                                <div class="row bg-light pt-3 mb-3" style="border-radius:5px;">
                                    <h6 class="card-title mb-2">Filter By </h6>
                                    <form class="row g-3 m-0"  id="searchform" name="searchform" method="post"  action="{{ route('samplecollection.search') }}" >  
                                        @csrf
                                        <div class="row g-4 mb-3 mt-0">

                                            <div class="col-sm-2 mt-1">
                                            <label class="form-label">From Date</label>
                                                <input type="text" class="form-control form-control-lg searchdate" name="searchfrmdate" value="{{$frmdate}}">
                                            </div>

                                            <div class="col-sm-2 mt-1">
                                            <label class="form-label">To Date</label>
                                                <input type="text" class="form-control form-control-lg searchdate" name="searchtodate" value="{{$todate}}">
                                            </div>

                                            <div class="col-sm-2 mt-1">
                                            <label class="form-label">Customer Name</label>
                                                <input type="text" class="form-control form-control-lg" name="searchcustomer" value="{{$customer}}">
                                            </div>

                                            <div class="col-sm-2 mt-1">
                                            <label class="form-label">Register No</label>
                                                <input type="text" class="form-control form-control-lg" name="searchregister" value="{{$registerno}}">
                                            </div>
                                              <div class="col-sm-2 mt-1">
                                            <label class="form-label">Phone No</label>
                                                <input type="number" class="form-control form-control-lg" name="searchphone" value="{{$phone}}">
                                            </div>


                                            <div class="col-sm-2 mt-1">
                                                <a style="cursor:pointer;" class="btn btn-primary mt-5" onclick="formSearch();">Search</a>
                                                <a href="{{ url('/sample') }}" class="btn btn-dark mt-5 text-white">Clear</a>
                                            </div>

                                            <div class="col-sm-10 m-0">
                                                <div class="alert-danger pt-1 pb-1 px-1 py-1" id="searchalert" style="display:none;">Please enter any one of the above fields</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <table id="samplecollection1" class="table card-table table-hover align-middle mb-0 test" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Reg Id</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Register By</th>
                                            <th class="text-center">Date & Time</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        
                     
                          
                                      

                                   @foreach($sampledata as $key => $data)
                                  
                                    @php
                                   
                                    if($data->rejected != 0 || $data->notcollected != 0 || $data->pending != 0 || $data->collected != 0) {
                                        $total = ($data->rejected + $data->notcollected + $data->pending + $data->collected + $data->accepted);
                                        $remaining = ($data->rejected + $data->notcollected + $data->pending);
                                        if($total > 1) { $samplestatus = 'Samples'; } else { $samplestatus = 'Sample'; }
                                        
                                        $date = $data->regdate;
                                        $receptdate = explode('-', $date);
                                        $day   = $receptdate[2];
                                        $month = $receptdate[1]; 
                                        $year  = $receptdate[0];  
                                        $monthname = date("M", mktime(0, 0, 0, $month, 10)); 
                                        $time = $data->regtime;
                                        $recepttime = explode(':', $time);
                                        $timeformat = explode(' ', $recepttime[2]);

                                    @endphp
                                    
                                        <tr>
                                            <td>{{$data->regid}} </td>
                                            <td>{{$data->customername}}</td>
                                            <td>{{$data->customerphone}}</td>
                                               <td> @if(isset($data->stafffirstname) && isset($data->stafflastname))
                                                    {{$data->stafffirstname}} {{$data->stafflastname}}
                                                  @else
                                                   Admin
                                                  @endif</td>
                                            <td class="text-center">{{ $monthname}} {{ $day }}, {{ $year }} {{$recepttime[0]}}:{{$recepttime[1]}} {{strtolower($timeformat[1])}}</td>
                                            <td class="text-center"><span class="btn btn-sm bg-dark text-white" id="statuscount{{$data->regid}}" style="padding: .10rem .5rem; width:200px;"> Pending {{$remaining}} of {{$total}} {{$samplestatus}}</span></td>
                                            <td style="text-align:center;">
                                                <a class="btn btn-sm bg-success text-white" onclick = "collectiondetails({{$data->regid}})">Update</a>
                                            <a class="btn btn-sm bg-success text-white" onclick = "barcodedetails({{$data->regid}})">Barcode</a>
                                            <!--<a class="btn btn-sm bg-dark text-white" onclick="viewdetails({{$data->regid}});">View</a>--></td>
                                        </tr>   
                                    @php    
                                    }
                                    @endphp
                                        <!-- COLLECTION STATUS UPDATES STARTS HERE -->

<!-- COLLECTION STATUS UPDATED ENDS HERE -->
                                        @endforeach
        
                                       
                                    
                                    </tbody>
                                </table>
                            </div>



                       <div class="modal fade" id="collection" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title">Sample Collection # <span id="headid"></span></h5>
                                        <button type="button" class="btn-close" id="modal-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div id="samplealert">      
                                        
                                    </div>    

                                    <div class="modal-body custom_scroll">
                                      
                                      
                                     <div class="col-md-12">
                                        <label for="collected_status" class="form-label">Please Update the Status</label>
                                        <select id="collected_status_val" name="collected_status" class="form-select select2">

                                            <!--<select id="collected_status" name="collected_status" class="form-select">-->
                                                <option value="">-----Select Status-----</option>
                                                <option value="notcollected">Not Collected</option>
                                                <option value="collected">Collected</option>
                                                <option value="pending">Partially Collected</option>
                                                
                                            </select>
                                    </div>
                                    <div class="col-md-12 text-center mt-3">
                                        <label for="collected_status" class="form-label">
                                            <h5 style="color: #00ac9a;"><strong>Sample Collection List</strong></h5>
                                        </label>
                                        
                                    </div>

                                        <table id="sampleupdate" class="table card-table table-hover align-middle mb-0" style="width: 100%;">
                                  
                                      
                                    <thead>
                                        
                                        
                                        <tr>
                                            <!--<th>#</th>-->
                                            <th>
                                                <label>
                                                   <input type="checkbox" id="select-all" name="selectedAll" ng-model="selectedAll" onclick="checkAll(this)"> #

                                                 </label>
                                            </th>

                                            <th>Test Name</th>
                                            <!--<th class="text-center">Collected Status</th>-->
                                            <th class="text-center">Collected Date & Time</th>
                                            <th class="text-center">Received Date & Time</th>                                            
                                            <th class="text-center">Collection Note</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                            <!--<th class="text-center">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="tblcollectionpopup">
   
                                    </tbody>
                                    </table>


                                           
                                    </div>
                                    <!-- <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>


                       

<style>
    .modal .__newPOP{
        width: 600px;
        margin: 10% auto;
        border: 3px solid #4dca88;
    }
    .modal .__newbPOP{
        /*border: 3px solid #4dca88;*/

    }
</style>


                         <!-- VIEW REJECT RESON MODAL START HERE -->
                             <form method="POST" action="{{ route('rejectreasonnew.add') }}">
    @csrf
    
    <div id="myModalReject" class="modal __newMPop">
        <div class="modal-content __newPOP">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Reject Reason </h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label=""></button>
            </div>
            <div class="modal-body __newbPOP">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <input type="hidden" name="itemId" id="itemId">
                        <select class="form-select select2" name="rejectReasonPopup" id="rejectReasonPopup">
                            <option value="0">- Please Select -</option>
                            @foreach ($rejectreason as $contain) 
                           
                                <option value="{{$contain->id}}">{{$contain->rejectreason}}</option>
                            @endforeach   
                        </select>
                        <div class="form-group mt-2">
                            <label for="rejectionnote">Rejection Note:</label>
                            
                           
                            <textarea class="form-control" name="rejectioNote" id="rejectioNote"></textarea>
                        
                        </div>
                
                        <!--<div class="alert-danger mt-2" id="rejectreasonalert" style="display:none;">Please select reason</div>
                        <!--<button type="submit" class="btn btn-success mt-2">Submit</button>-->
                    </div>
                    
                    
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success mt-2">Submit</button>
            </div>
        </div>
    </div>
    
</form>
                              <!-- VIEW REJECT RESON MODAL END HERE -->


                            <!-- Modal -->

                            <div class="modal fade" id="viewdetails" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modaltitle">View Details  # </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="
                                        "></button>
                                    </div>
                                    <div class="modal-body custom_scroll">
                                    <div class="row g-4">
                                    <div class="col-sm-12">
                                        <label class="form-label">Confirmation Note</label>
                                        <p id = "note"></p>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="form-label">Date</label>
                                                <p id="notedate"></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Time</label>
                                                <p id="notetime"></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Status</label>
                                                <p id="notestatus"></p>
                                            </div>
                                        </div>
                                    </div>


                                    
                                </div>
                                
                                    </div>
                                    <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- VIEW INVOICE MODAL STARTS HERE -->
                        <div class="modal fade" id="invoice_detail" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Invoice #RA0011</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body custom_scroll">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Invoice <strong>01/April/2022</strong>
                                                    </th>
                                                    <td class="text-end">
                                                        <span class="text-success"> <strong>Status:</strong> Paid</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>From:</div>
                                                        <div class="fs-6 fw-bold mb-1">Cignes </div>
                                                        <div>Madalinskiego 8</div>
                                                        <div>71-101 Szczecin, Poland</div>
                                                        <div>Email: info@cignes.com.pl</div>
                                                        <div>Phone: +48 444 666 3333</div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div>To:</div>
                                                        <div class="fs-6 fw-bold mb-1">Bob Mart</div>
                                                        <div>Attn: Daniel Marek</div>
                                                        <div>43-190 Mikolow, Poland</div>
                                                        <div>Email: marek@daniel.com</div>
                                                        <div>Phone: +48 123 456 789</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <table class="table table-borderless table-striped mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th>Test</th>
                                                                    <th class="text-end" colspan="2">Rate</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">1</td>
                                                                    <td>LDL</td>
                                                                    <td class="text-end" colspan="2">$999,00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">2</td>
                                                                    <td>HDL</td>
                                                                    <td class="text-end" colspan="2">$150,00</td>

                                                                </tr>
                                                                <tr></tr>
                                                                    <td colspan="3">
                                                                        <h6>Terms &amp; Condition</h6>
                                                                        <p class="text-muted">You know, being a test pilot isn't always the healthiest business in the world. We predict too much for the next year and yet far too little for the next 10.</p>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <table class="table table-borderless mb-0">         
                                                                            <tbody>
                                                                                <tr>     
                                                                                    <td ><strong>Subtotal</strong></td>
                                                                                    <td class="text-end">$8.497,00</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td ><strong>VAT (10%)</strong></td>
                                                                                    <td class="text-end">$679,76</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td ><strong>Total</strong></td>
                                                                                    <td class="text-end"><strong>$7.477,36</strong></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"><i class="fa fa-print me-2"></i>Print</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- VIEW INVOICE MODAL ENDS HERE -->                            
                         <!-- VIEW BARCODE MODAL STARTS HERE -->
 <!--           <div class="modal fade" id="barcodemodel" tabindex="-1">-->
 <!--                    <div class="modal-dialog">-->
 <!--                       <div class="modal-content">-->
 <!--                          <div class="modal-header">-->
						    
 <!--                             <h5 class="modal-title">Barcode </h5>-->
							   
 <!--                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closesinglenormalrange"></button>-->
 <!--                          </div>-->
 <!--                          <div class="modal-body">-->
 <!--                             <div class="row g-4">-->
                                 
 <!--                                <div class="col-sm-8">-->
                                    
 <!--                                   <div class="pt-1 pb-1 px-1 py-1" id="paymentmethodalert">-->
	<!--								 <div id="printable">-->
	<!--							<img class="barcode" data-value="labapp"></img>-->
	<!--						  </div>-->
							  
	<!--						  </div>-->
									 
 <!--                                </div>-->
                                 
                                 
 <!--                                <div class="col-sm-12"> -->
	<!--		<button class="btn btn-primary" type="button" onclick="printBarcode()">-->
 <!--   Print barcode-->
 <!--</button>					 -->
								 
 <!--                                   </div>-->
 <!--                             </div>-->
 <!--                          </div>-->
 <!--                       </div>-->
 <!--                    </div>-->
 <!--                 </div>-->
                            
                            
                            
                                           <!-- VIEW BARCODE MODAL STARTS HERE -->
           <div class="modal fade" id="barcodemodel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closesinglenormalrange"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-sm-8">
                        <div class="pt-1 pb-1 px-1 py-1" id="paymentmethodalert">
                            <div id="printable">
                                <img class="barcode" data-value="labapp"></img>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12"> 
                        <button class="btn btn-primary" type="button" onclick="printBarcode()">
                            Print barcode
                        </button>                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
     
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/barcodes/JsBarcode.code128.min.js"></script>
<script>
 
 function barcodedetails(id){
    
    var ids = id;
    var reg = "REG NO:"
	 
    // document.getElementsByName("total").value =  ids;  
    //  alert(ss);  
   $('#hiddenid').val(ids);
   
     JsBarcode(".barcode",reg+ids, {
    width: 1,
    height: 30,
    textAlign: "left",
    fontOptions: "bold",
    margin: 10,
    fontSize: 20
  })

  let barcodeSVGs = document.getElementsByClassName("barcode")

   $('#barcodemodel').modal('show');
}

 
  // for (let el of barcodeSVGs) {
  //   el.setAttribute("width", "100%")
  //   el.setAttribute("height", "100%")
  // }

   function printBarcode() {
     // printJS('printable', 'html')

     let printFrame = document.createElement("iframe")
     let printableElement = document.getElementById("printable")
     //
     // // printframe.setattribute("style", "visibility: hidden; height: 0; width: 0; position: absolute;")
     printFrame.setAttribute("id", "printjs")
     printFrame.srcdoc = "<html><head><title>document</title></head><body style='margin: 0;'>" +
       printableElement.outerHTML + "<style>@page { size: A4; } #printable { margin-left: 2.85cm; width: 1.6cm; height: 0.1cm; } #printable .barcode { width: 100%; }</style> </body></html>"

     document.body.appendChild(printFrame)

     let iframeElement = document.getElementById("printjs")
     iframeElement.focus()
     iframeElement.contentWindow.print()
     //
     // printframe.contentwindow.print()
     //
     // my_window = window.open('', 'mywindow', 'status=1,width=350,height=150');
     // my_window.document.write('<html><head><title>Print Me</title></head>');
     // my_window.document.write('<body onafterprint="self.close()">');
     // my_window.document.write(printablEelement.innerHTML);
     // my_window.document.write('</body></html>');
     // my_window.print();
   }
  </script>
				  
				  

 
     
<!-- VIEW BARCODE MODAL ENDS HERE -->    
                        </div>
                    </div>
                </div> <!-- .row end -->

            </div>
        </div>
                            <div class="modal fade" id="ViewRecentTestsModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Invoice-12345 Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="form-check form-check-inline">                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <strong>LDL</strong>
                                                    </label>
                                                </div>                                                
                                            </div> 
                                            
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="form-check form-check-inline">                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <strong>Triglycerides </strong>
                                                    </label>
                                                </div>                                                
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="form-check form-check-inline">                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <strong>HDL</strong>   
                                                    </label>
                                                </div>                                                
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="form-check form-check-inline">                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <strong>Profile Test Two</strong>
                                                    </label>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
<script src="{!! asset('assets/plugin/jquery/3.3.1/jquery.min.js') !!}"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script type="text/javascript">
    function formSearch(){   
        document.getElementById('searchalert').style.display = 'none';

        if(document.searchform.searchfrmdate.value !='' || document.searchform.searchtodate.value !='' || document.searchform.searchcustomer.value !='' || document.searchform.searchregister.value !=''|| document.searchform.searchphone.value !='')
        {
            document.searchform.submit();
        } else {
            document.getElementById('searchalert').style.display = 'block';
            return false;
        }
    }  

    $(document).ready(function () {
        $('#collection').modal({
            backdrop: 'static',
            keyboard: false
        })
   });   
</script>
<script type='text/javascript' src="{!! asset('assets/bundles/jquery.inputmask.bundle.js') !!}"></script>
<script>
var $j = jQuery.noConflict();
$j(document).ready(function(){
        $j('#docexpirydate').inputmask('99/99/9999',{placeholder:"dd/mm/yyyy"});
});




function collectionupdate(id){
    var collectionstatusval = $('#collectionstatus'+id).val();
    var collectiondateval = $('#collecteddate'+id).val();
    var receiveddateval = $('#receiveddate'+id).val();
    var cnoteval = $('#collectionnote'+id).val(); 
    var regid = $('#hidregid'+id).val();

    var rejectreasonval = $('#rejectreason'+id).val();
    var rejectionnoteval = $('#rejectionnote'+id).val();

    //alert(regid); return false;
    document.getElementById('collectionstatusalert'+id).style.display = 'none';
    document.getElementById('collecteddatealert'+id).style.display = 'none';
    document.getElementById('receiveddatealert'+id).style.display = 'none';

    if(collectionstatusval == ''){
        document.getElementById('collectionstatusalert'+id).style.display = 'block'; 
        return false;
    }
    if(collectionstatusval == 'collected'){
    
        if(collectiondateval == ''){
            document.getElementById('collecteddatealert'+id).style.display = 'block'; 
            return false;
        }

        if(receiveddateval == ''){
            document.getElementById('receiveddatealert'+id).style.display = 'block'; 
            return false;
        }

    //alert('working'); 
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); 
            $.ajax({
                    url:"{{ 'sample-add' }}",
                    type: 'POST',
                    data: { 
                        id:id,
                        reg:regid,
                        status:collectionstatusval,
                        cdate:collectiondateval,
                        cnote:cnoteval,
                        rdate:receiveddateval,
                        rejreason:rejectreasonval,
                        rejnote:rejectionnoteval,                     
                        _token:token
                    },
                    success: function(datas){
                        // alert(datas.rejected); return false;
                        //var countnum = (Number(datas.rejected) + Number(datas.notcollected) + Number(datas.pending));
                        // alert(countnum); return false;
                       var countnum;
                        var totalnum;
                        var testlist = "";
                        var num = 0;
                        var teststatus;
                        var statushtml="";
                        var rejectreason;
                        var rejection; 
                        var samples = '';   
                        var rid; 
                        var statusmsg ="";
                        var collectionnote;
                        var reasonhtml = "";
                        reasonhtml = '<option value="">--Please Select--</option>';
                        $.each(datas.reasons, function( index, reason ) {
                        reasonhtml += '<option value="'+reason.reasonid+'">'+reason.reasonname+'</option>';
                        });
                        
                        $.each(datas.sampledatacounts, function( index, datacounts ) {
                            
                            countnum = (Number(datacounts.rejected) + Number(datacounts.notcollected) + Number(datacounts.pending));
                            totalnum = (Number(datacounts.rejected) + Number(datacounts.notcollected) + Number(datacounts.pending) + Number(datacounts.collected) + Number(datacounts.accepted));
                            //alert('Pending '+countnum+' of '+totalnum); return false;
                            if(totalnum > '1') { samples = 'Samples';} else { samples = 'Sample';}
                            rid = datacounts.regid;
                        });

                        
                        $.each(datas.tests, function( index, test ) {
                                num = num+1;                                
                                teststatus = test.status;
                                rejection = test.rejectionreason;
                                if(test.rejectionreason == null || test.rejectionreason == undefined){
                                rejectreason = '-NA-';
                                } else {
                                    rejectreason = rejection;
                                }
                                if(test.samplecollectionnote == null || test.samplecollectionnote==undefined){
                                    collectionnote = '';
                                } else {
                                    collectionnote = test.samplecollectionnote;
                                } 
                                
                                if(teststatus == 'collected'){ statushtml = '<span class="btn btn-sm bg-success text-white" style="padding: .10rem .5rem; width:120px;">Collected</span>';} 
                
                
                                if(teststatus == 'pending'){ statushtml = '<span class="btn btn-sm bg-warning text-dark" style="padding: .10rem .5rem; width:120px;" >Pending</span>';} 
                                if(teststatus == 'notcollected') {statushtml = '<span class="btn btn-sm bg-info text-white" style="padding: .10rem .5rem; width:120px;">Not Collected c</span>';}
                                if(teststatus == 'rejected') {statushtml = '<span class="btn btn-sm bg-danger text-white" style="padding: .10rem .5rem; width:120px;">Rejected</span>';}
                                // testlist += '<tr><td><input type="checkbox" name="testcheck" value="'+num+'">'+num+'</td><td>'+test.testname+'</td><td><select class="form-select form-select-lg" name="collectionstatus" id="collectionstatus'+test.id+'" onchange="collectionnoteupdate('+test.id+',this)"><option value="pending">Pending</option><option value="collected">Collected</option><option value="rejected">Rejected</option></select><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collectionstatusalert'+test.id+'" style="display:none ;">Please select status</div></td><td><input type="text" class="form-control form-control-lg flatpickr collecteddate flatpickr-input" name="collecteddate" id="collecteddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collecteddatealert'+test.id+'" style="display:none ;">Please enter collected date</div></td><td><input type="text" class="form-control form-control-lg flatpickr receiveddate flatpickr-inputname="receiveddate" id="receiveddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="receiveddatealert'+test.id+'" style="display:none ;">Please enter received date</div></td><td><textarea class="form-control form-control-lg" name="collectionnote" id="collectionnote'+test.id+'"  style="resize:none;">'+collectionnote+'</textarea></td><td class="text-center" id="statusid'+test.id+'">'+statushtml+'</td><td><span id="rejectreasonview'+test.id+'">'+rejectreason+'</span> <select class="form-select form-select-lg" name="rejectreason" id="rejectreason'+test.id+'" style="resize:none; display:none;">'+reasonhtml+'</select><textarea class="form-control form-control-lg mt-1" name="rejectionnote" id="rejectionnote'+test.id+'" style="resize:none; display:none;" placeholder="Enter rejection reason"></textarea><div class="alert-danger pt-1 pb-1 px-1 py-1" id="rejectreasonalert'+test.id+'" style="display:none ;">Please select reason</div></td><td><input type="hidden" id="hidregid'+test.id+'" value="'+test.rid+'"><a class="btn btn-sm bg-success text-white" id="'+test.id+'" onclick="collectionupdate(this.id)">Save</a></td></tr>';

                                //  testlist += '<tr><td>'+num+'</td><td>'+test.testname+'</td><td><select class="form-select form-select-lg" name="collectionstatus" id="collectionstatus'+test.id+'" onchange="collectionnoteupdate('+test.id+',this)"><option value="pending">Pending</option><option value="collected">Collected</option><option value="rejected">Rejected</option></select><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collectionstatusalert'+test.id+'" style="display:none ;">Please select status</div></td><td><input type="text" class="form-control form-control-lg flatpickr collecteddate flatpickr-input" name="collecteddate" id="collecteddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collecteddatealert'+test.id+'" style="display:none ;">Please enter collected date</div></td><td><input type="text" class="form-control form-control-lg flatpickr receiveddate flatpickr-inputname="receiveddate" id="receiveddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="receiveddatealert'+test.id+'" style="display:none ;">Please enter received date</div></td><td><textarea class="form-control form-control-lg" name="collectionnote" id="collectionnote'+test.id+'"  style="resize:none;">'+collectionnote+'</textarea></td><td class="text-center" id="statusid'+test.id+'">'+statushtml+'</td><td><span id="rejectreasonview'+test.id+'">'+rejectreason+'</span> <select class="form-select form-select-lg" name="rejectreason" id="rejectreason'+test.id+'" style="resize:none; display:none;">'+reasonhtml+'</select><textarea class="form-control form-control-lg mt-1" name="rejectionnote" id="rejectionnote'+test.id+'" style="resize:none; display:none;" placeholder="Enter rejection reason"></textarea><div class="alert-danger pt-1 pb-1 px-1 py-1" id="rejectreasonalert'+test.id+'" style="display:none ;">Please select reason</div></td><td><input type="hidden" id="hidregid'+test.id+'" value="'+test.rid+'"><a class="btn btn-sm bg-success text-white" id="'+test.id+'" onclick="collectionupdate(this.id)">Save</a></td></tr>';
                            });
                                if(datas.upstatus == 'pending') { 
                                    statusmsg = '<div class="alert-warning  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample status updated to pending</div>';
                                } else if (datas.upstatus == 'rejected') {
                                    statusmsg = '<div class="alert-danger  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample has been rejected</div>';
                                } else { 
                                    statusmsg = '<div class="alert-success  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample collected successfully</div>';
                                }
                             alerthtml = statusmsg;
                            //  var alerthtml = '<div class="alert-success  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">'+statusmsg+'</div>';
                            
                                $('#samplealert').html(alerthtml);
                                $('#tblcollectionpopup').html(testlist);
                            
                            if(countnum == 0){
                                $('#samplealert').html('');
                                $('#collection').modal('hide');
                                window.location.reload();                                
                            } 
                            $('#statuscount'+rid).html('Pending '+countnum+' of '+totalnum+' '+samples);
                        //alert('#statuscount'+datacounts.regid); return false;
                            //$('#statuscount').html(countnum+' pending of '+totalnum);
                            
                            
                        }
            });




} else if(collectionstatusval == 'rejected'){ 
        
        if(rejectreasonval == ''){  
            document.getElementById('rejectreasonalert'+id).style.display = 'block'; 
            return false;
        }

        var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); 

        $.ajax({
                    url:"{{ 'sample-add' }}",
                    type: 'POST',
                    data: { 
                        id:id,
                        reg:regid,
                        status:collectionstatusval,
                        cdate:collectiondateval,
                        cnote:cnoteval,
                        rdate:receiveddateval,
                        rejreason:rejectreasonval,
                        rejnote:rejectionnoteval, 
                        _token:token
                    },
                    success: function(datas){
                        var testlist = "";
                        var num = 0;
                        var teststatus;
                        var statushtml;
                        var rejectreason;
                        var rejection; 
                        var statusmsg ="";
                        var alerthtml ="";
                        var collectionnote;
                        var reasonhtml = "";
                        reasonhtml = '<option value="">--Please Select--</option>';
                        $.each(datas.reasons, function( index, reason ) {
                        reasonhtml += '<option value="'+reason.reasonid+'">'+reason.reasonname+'</option>';
                        });
                        $.each(datas.tests, function( index, test ) {
                                //num = num+index;
                                num = num+1;
                                rejection = test.rejectionreason;
                                teststatus = test.status;
                               // alert(teststatus);
                                if(test.rejectionreason == null || test.rejectionreason == undefined){
                                rejectreason = '-NA-';
                                } else {
                                    rejectreason = rejection;
                                }
                                if(test.samplecollectionnote == null || test.samplecollectionnote == undefined) {
                                    collectionnote = '';
                                } else {
                                    collectionnote = test.samplecollectionnote;
                                }
                                if(teststatus == 'collected'){ statushtml = '<span class="btn btn-sm bg-success text-white" style="padding: .10rem .5rem; width:120px;">Collected</span>';} 
                
                
                                if(teststatus == 'pending'){ statushtml = '<span class="btn btn-sm bg-warning text-dark" style="padding: .10rem .5rem; width:120px;">Pending</span>'; }
                                if(teststatus == 'notcollected') {statushtml = '<span class="btn btn-sm bg-info text-white" style="padding: .10rem .5rem; width:120px;">Not Collected d</span>';}
                                if(teststatus == 'rejected') {statushtml = '<span class="btn btn-sm bg-danger text-white" style="padding: .10rem .5rem; width:120px;">Rejected</span>';}
                                 testlist += '<tr><td>'+num+'</td><td>'+test.testname+'</td><td><select class="form-select form-select-lg" name="collectionstatus" id="collectionstatus'+test.id+'" onchange="collectionnoteupdate('+test.id+',this)"><option value="pending">Pending</option><option value="collected">Collected</option><option value="rejected">Rejected</option></select><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collectionstatusalert'+test.id+'" style="display:none ;">Please select status</div></td><td><input type="text" class="form-control form-control-lg flatpickr collecteddate flatpickr-input" name="collecteddate" id="collecteddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collecteddatealert'+test.id+'" style="display:none ;">Please enter collected date</div></td><td><input type="text" class="form-control form-control-lg flatpickr receiveddate flatpickr-inputname="receiveddate" id="receiveddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="receiveddatealert'+test.id+'" style="display:none ;">Please enter received date</div></td><td><textarea class="form-control form-control-lg" name="collectionnote" id="collectionnote'+test.id+'"  style="resize:none;">'+collectionnote+'</textarea></td><td class="text-center" id="statusid'+test.id+'">'+statushtml+'</td><td><span id="rejectreasonview'+test.id+'">'+rejectreason+'</span> <select class="form-select form-select-lg" name="rejectreason" id="rejectreason'+test.id+'" style="resize:none; display:none;">'+reasonhtml+'</select><textarea class="form-control form-control-lg mt-1" name="rejectionnote" id="rejectionnote'+test.id+'" style="resize:none; display:none;" placeholder="Enter rejection reason"></textarea><div class="alert-danger pt-1 pb-1 px-1 py-1" id="rejectreasonalert'+test.id+'" style="display:none ;">Please select reason</div></td><td><input type="hidden" id="hidregid'+test.id+'" value="'+test.rid+'"><a class="btn btn-sm bg-success text-white" id="'+test.id+'" onclick="collectionupdate(this.id)">Save</a></td></tr>';
                            });
                            //alert(datas.upstatus);
                            if(datas.upstatus == 'pending') { 
                                    statusmsg = '<div class="alert-warning  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample status updated to pending</div>';
                                } else if (datas.upstatus == 'rejected') {
                                    statusmsg = '<div class="alert-danger  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample has been rejected</div>';
                                } else { 
                                    statusmsg = '<div class="alert-success  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample collected successfully</div>';
                                }
                             alerthtml = statusmsg;

                             
                            
                                $('#samplealert').html(alerthtml);
                                $('#tblcollectionpopup').html(testlist);
                            
                        
                        
                        }
            });

    } else {
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); 
        $.ajax({
                    url:"{{ 'sample-add' }}",
                    type: 'POST',
                    data: { 
                        id:id,
                        reg:regid,
                        status:collectionstatusval,
                        cdate:collectiondateval,
                        cnote:cnoteval,
                        rdate:receiveddateval,
                        rejreason:rejectreasonval,
                        rejnote:rejectionnoteval, 
                        _token:token
                    },
                    success: function(datas){
                        var testlist = "";
                        var num = 0;
                        var teststatus;
                        var statushtml;
                        var rejectreason;
                        var rejection; 
                        var statusmsg ="";
                        var alerthtml ="";
                        var collectionnote;
                        var reasonhtml = "";
                        reasonhtml = '<option value="">--Please Select--</option>';
                        $.each(datas.reasons, function( index, reason ) {
                        reasonhtml += '<option value="'+reason.reasonid+'">'+reason.reasonname+'</option>';
                        });
                        $.each(datas.tests, function( index, test ) {
                                //num = num+index;
                                num = num+1;
                                rejection = test.rejectionreason;
                                teststatus = test.status; 
                               // alert(teststatus);
                                if(test.rejectionreason == null || test.rejectionreason == undefined){
                                rejectreason = '-NA-';
                                } else {
                                    rejectreason = rejection;
                                }
                                if(test.samplecollectionnote == null || test.samplecollectionnote == undefined) {
                                    collectionnote = '';
                                } else {
                                    collectionnote = test.samplecollectionnote;
                                }            
                                if(teststatus == 'collected'){ statushtml = '<span class="btn btn-sm bg-success text-white" style="padding: .10rem .5rem; width:120px;">Collected</span>';} 
                
                
                                if(teststatus == 'pending'){ statushtml = '<span class="btn btn-sm bg-warning text-dark" style="padding: .10rem .5rem; width:120px;">Pending</span>'; }
                                if(teststatus == 'notcollected') {statushtml = '<span class="btn btn-sm bg-info text-white" style="padding: .10rem .5rem; width:120px;">Not Collected e</span>';}
                                if(teststatus == 'rejected') {statushtml = '<span class="btn btn-sm bg-danger text-white" style="padding: .10rem .5rem; width:120px;">Rejected</span>';}
                                 testlist += '<tr><td>'+num+'</td><td>'+test.testname+'</td><td><select class="form-select form-select-lg" name="collectionstatus" id="collectionstatus'+test.id+'" onchange="collectionnoteupdate('+test.id+',this)"><option value="pending">Pending</option><option value="collected">Collected</option><option value="rejected">Rejected</option></select><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collectionstatusalert'+test.id+'" style="display:none ;">Please select status</div></td><td><input type="text" class="form-control form-control-lg flatpickr collecteddate flatpickr-input" name="collecteddate" id="collecteddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collecteddatealert'+test.id+'" style="display:none ;">Please enter collected date</div></td><td><input type="text" class="form-control form-control-lg flatpickr receiveddate flatpickr-inputname="receiveddate" id="receiveddate'+test.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="receiveddatealert'+test.id+'" style="display:none ;">Please enter received date</div></td><td><textarea class="form-control form-control-lg" name="collectionnote" id="collectionnote'+test.id+'"  style="resize:none;">'+collectionnote+'</textarea></td><td class="text-center" id="statusid'+test.id+'">'+statushtml+'</td><td><span id="rejectreasonview'+test.id+'">'+rejectreason+'</span> <select class="form-select form-select-lg" name="rejectreason" id="rejectreason'+test.id+'" style="resize:none; display:none;">'+reasonhtml+'</select><textarea class="form-control form-control-lg mt-1" name="rejectionnote" id="rejectionnote'+test.id+'" style="resize:none; display:none;" placeholder="Enter rejection reason"></textarea><div class="alert-danger pt-1 pb-1 px-1 py-1" id="rejectreasonalert'+test.id+'" style="display:none ;">Please select reason</div></td><td><input type="hidden" id="hidregid'+test.id+'" value="'+test.rid+'"><a class="btn btn-sm bg-success text-white" id="'+test.id+'" onclick="collectionupdate(this.id)">Save</a></td></tr>';
                            });
                            //alert(datas.upstatus);
                            if(datas.upstatus == 'pending') { 
                                    statusmsg = '<div class="alert-warning  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample status updated to pending</div>';
                                } else if (datas.upstatus == 'rejected') {
                                    statusmsg = '<div class="alert-danger  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample has been rejected</div>';
                                } else { 
                                    statusmsg = '<div class="alert-success  text-center mt-2 mx-auto" role="alert" style="padding: 0.3rem 2.5rem; border-radius:3px;">Sample collected successfully</div>';
                                }
                             alerthtml = statusmsg;

                             
                            
                                $('#samplealert').html(alerthtml);
                                $('#tblcollectionpopup').html(testlist);
                            
                        
                        
                        }
            });
    }
}



    function viewdetails(id){
    // alert(id);
    var note;
    var notestatus;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
       // url:"{{ 'viewnote' }}",
       url:"{{ route('samplecollection.view') }}",
       type: 'POST',
       data: { 
            id:id
            
            },
       success: function(response){


     
        if(response.note == null )
        {
            note='-NA-';
        }else{
            note=response.note;
        }

        if(response.notestatus == 'confirmed'){
            notestatus = 'Confirmed';
        }
        $('#modaltitle').html('View Details # '+response.res);
        $('#note').html(note);
        $('#notedate').html(response.notedate);
        $('#notetime').html(response.notetime);
        $('#notestatus').html(notestatus);


         $('#viewdetails').modal('show');
         //
       }
    });
}
 



</script>

<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
<!-- <script src="{!! asset('assets/bundles/bootstrapdatepicker.bundle.js') !!}"></script> -->
<script src="{!! asset('assets/bundles/flatpickr.bundle.js') !!}"></script>

<script>
    // date time picker
$(function() {
    $("body").delegate(".collecteddate", "focusin", function(){
        $(this).flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y h:i K",
            //time24hr:false
            //defaultDate: "2020-11-26 14:30 PM" 
            
            
        });
    });
    $("body").delegate(".receiveddate", "focusin", function(){
        $(this).flatpickr({
            enableTime: true,
            minDate: "today",
            dateFormat: "d-m-Y h:i K"
        });
    });
    $("body").delegate(".searchdate", "focusin", function(){
            $(this).flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
            });
        });
});

function collectionnoteupdate(id,sel){
   // alert(id+' '+sel.value);
    if(sel.value == 'collected') { 
        $('#collectionnote'+id).val('');
        $('#rejectreasonview'+id).show();
        $('#rejectreason'+id).hide();
        $('#rejectionnote'+id).hide();

    } else if(sel.value == 'rejected') { 
        $('#rejectreasonview'+id).hide();
        $('#rejectreason'+id).show();
        $('#rejectionnote'+id).show();

    } else {
        $('#rejectreasonview'+id).show();
        $('#rejectreason'+id).hide();
        $('#rejectionnote'+id).hide();

    }
}   

    

</script> 

<script src="{!! asset('assets/js/bundle/dataTables.bundle.js') !!}"></script>
        <script>
    // project data table
    $('.test').addClass('nowrap').dataTable({
      
     order: [[0, "desc"]],
      responsive: true,
     
    });  
    
       
  </script>
  <script>
 function checkAll(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox' && checkboxes[i].id != 'selectedAll') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox' && checkboxes[i].id != 'selectedAll') {
                checkboxes[i].checked = false;
            }
        }
    }
}


</script>
<!--<script>-->
<!--$(document).ready(function() {-->
<!--    $('.select2').select2({-->
<!--        placeholder: 'Search for a reason',-->
<!--        allowClear: true-->
<!--    });-->
<!--});-->
<!--</script>-->

<script>
    $(document).ready(function() {
  $('.select2').select2();
});

</script>
<script>
    
function showRejectReason(selectedValue) {
    if(selectedValue === "rejected") {
        document.getElementById("reject_reason_div").style.display = "block";
    } else {
        document.getElementById("reject_reason_div").style.display = "none";
    }
}

</script>


<script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<script>
    
    function collectiondetails(id){
        
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    // alert("dk");
    //alert('regid->'+id+'token->'+token); return false;
    $.ajax({
        url:"{{'sample-view'}}",
        type: 'POST',
        data: { 
            id:id,
            _token:token
        },
        success: function(response){
            $('#collection').modal('show');
            
            // alert("hiiii");
            
            
			//$('#collection').modal({backdrop: 'static', keyboard: false}, 'show');
          var testlist = "";
          var num = 0;
          var teststatus;
          var statushtml;
          var rejectreason="NA";
          var rejection;
          var collectionnote;
          var reasonhtml = "";
          

          
          var 
          reasonhtml = '<option value="">--Please Select--</option>';
         
          $.each(response.reasons, function( index, reason ) {
                        reasonhtml += '<option value="'+reason.reasonid+'">'+reason.reasonname+'</option>';
                        });
            $.each(response.testlists, function( index, tests ) { 
                //num = num+index;
                num = num+1;
                teststatus = tests.status;
                rejection = tests.rejectionreason;
                console.log(tests);
                // alert(teststatus);

                // alert(tests.rejectionreason);
               // alert(rejection); return false;
               if(tests.rejectionreason == null || tests.rejectionreason == undefined){
                rejectreason = '-NA-';
                } else {
                    rejectreason = rejection;     
                }
                
                if(tests.samplecollectionnote ==null || tests.samplecollectionnote ==undefined) {
                    collectionnote = '';
                } else {
                    collectionnote = tests.samplecollectionnote; 
                }
                
                if(tests.collection_date ==null || tests.collection_date ==undefined) {
                    collection_date =  moment().format('DD-MM-YYYY HH:mm:ss');
                } else {
                    collection_date = tests.collection_date; 
                }
                
                if(tests.received_date ==null || tests.received_date ==undefined) {
                    received_date =  moment().format('DD-MM-YYYY HH:mm:ss');
                } else {
                    received_date = tests.received_date; 
                }
                
                if(teststatus == 'collected'){ statushtml = '<span class="btn btn-sm bg-success text-white" style="padding: .10rem .5rem; width:120px;">Collected</span>';} 
                
                if(teststatus == 'pending'){ statushtml = '<span class="btn btn-sm bg-warning text-dark" style="padding: .10rem .5rem; width:120px;">Pending</span>';} 
                if(teststatus == 'notcollected') {statushtml = '<span class="btn btn-sm bg-info text-white" style="padding: .10rem .5rem; width:120px;">Not Collected</span>';}
                if(teststatus == 'rejected') {statushtml = '<span class="btn btn-sm bg-danger text-white" style="padding: .10rem .5rem; width:120px;">Rejected</span>';}
                if(teststatus == 'collected'){
                testlist += '<tr><td><input type="checkbox" class="row-select" name="testcheckbox" value="'+tests.id+'"></td><td>'+tests.testname+'</td><td><input type="text" class="form-control form-control-lg flatpickr collecteddate flatpickr-input" name="collecteddate" style="width:auto;" value="'+collection_date +'" id="collecteddate'+tests.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collecteddatealert'+tests.id+'" style="display:none ;">Please enter collected date</div></td><td><input type="text" class="form-control form-control-lg flatpickr receiveddate flatpickr-inputname="receiveddate" style="width:auto;" value="'+received_date +'" id="receiveddate'+tests.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="receiveddatealert'+tests.id+'" style="display:none ;">Please enter received date</div></td><td><textarea class="form-control form-control-lg" name="collectionnote" id="collectionnote'+tests.id+'" style="resize:none;">'+collectionnote+'</textarea></td><td class="text-center" id="statusid'+tests.id+'"> <button class="status-toggle" data-id="'+tests.id+'" data-status="'+teststatus+'">'+statushtml+'</button></td><td><input type="hidden" id="hidregid'+tests.id+'" value="'+tests.rid+'"><a class="btn btn-sm bg-success text-white" id="'+tests.id+'" onclick="collectionupdat_rejecte(this.id)">Reject</a></td></tr>';
                }
                else if(teststatus == 'rejected')
                {
                    testlist += '<tr><td><input type="checkbox" class="row-select" name="testcheckbox" value="'+tests.id+'"></td><td>'+tests.testname+'</td><td><input type="text" class="form-control form-control-lg flatpickr collecteddate flatpickr-input" name="collecteddate" style="width:auto;" value="'+collection_date +'" id="collecteddate'+tests.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collecteddatealert'+tests.id+'" style="display:none ;">Please enter collected date</div></td><td><input type="text" class="form-control form-control-lg flatpickr receiveddate flatpickr-inputname="receiveddate" style="width:auto;" value="'+received_date +'" id="receiveddate'+tests.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="receiveddatealert'+tests.id+'" style="display:none ;">Please enter received date</div></td><td><textarea class="form-control form-control-lg" name="collectionnote" id="collectionnote'+tests.id+'" style="resize:none;">'+collectionnote+'</textarea></td><td class="text-center" id="statusid'+tests.id+'"> <button class="status-toggle" data-id="'+tests.id+'" data-status="'+teststatus+'">'+statushtml+'</button></td><td><input type="hidden" id="hidregid'+tests.id+'" value="'+tests.rid+'"><u>Reject Reason:-</u> <br>'+tests.rejectionreason+'</td></tr>';
                    
                }
                else{
                    testlist += '<tr><td><input type="checkbox" class="row-select" name="testcheckbox" value="'+tests.id+'"></td><td>'+tests.testname+'</td><td><input type="text" class="form-control form-control-lg flatpickr collecteddate flatpickr-input" name="collecteddate" style="width:auto;" value="'+collection_date +'" id="collecteddate'+tests.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="collecteddatealert'+tests.id+'" style="display:none ;">Please enter collected date</div></td><td><input type="text" class="form-control form-control-lg flatpickr receiveddate flatpickr-inputname="receiveddate"  style="width:auto;" value="'+received_date +'" id="receiveddate'+tests.id+'"><div class="alert-danger pt-1 pb-1 px-1 py-1" id="receiveddatealert'+tests.id+'" style="display:none ;">Please enter received date</div></td><td><textarea class="form-control form-control-lg" name="collectionnote" id="collectionnote'+tests.id+'" style="resize:none;">'+collectionnote+'</textarea></td><td class="text-center" id="statusid'+tests.id+'"> <button class="status-toggle" data-id="'+tests.id+'" data-status="'+teststatus+'">'+statushtml+'</button></td><td><input type="hidden" id="hidregid'+tests.id+'" value="'+tests.rid+'">----No action---</td></tr>';
                 
                }
            });
            
            $('#headid').html(response.rid);
            $('#samplealert').html('');
            $('#tblcollectionpopup').html(testlist);
            
            
        }
    });   

} 



$(document).on('click', '.status-toggle', function() {
    var button = $(this);
    var id = button.data('id');
    var currentStatus = button.data('status');
    var collected_note = $('#collectionnote'+id).val();
    var collected_date =  $('#collecteddate'+id).val();
    var recv_date =  $('#receiveddate'+id).val();
    // Toggle the status
    var newStatus = (currentStatus === 'notcollected') ? 'collected' : 'notcollected';
    
    // Update the button text
    button.html('<span class="btn btn-sm ' + getStatusButtonClass(newStatus) + '">' + getStatusButtonText(newStatus) + '</span>');
    
    // Update the database value using AJAX
    $.ajax({
        url: "{{ route('update-database-status') }}",
        method: 'POST',
        data: {
            id: id,collected_note:collected_note,collected_date:collected_date,recv_date:recv_date,
            status: newStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
           
           collectiondetails(response.reg_id)
        },
        error: function(response) {
            // Handle any errors if needed
        }
    });
});

// Helper function to get the button class based on the status
function getStatusButtonClass(status) {
    if (status === 'collected') {
        return 'bg-success text-white';
    } else if (status === 'notcollected') {
        return 'bg-info text-white';
    } else if (status === 'pending') {
        return 'bg-warning text-dark';
    } else if (status === 'rejected') {
        return 'bg-danger text-white';
    } else {
        return '';
    }
}

// Helper function to get the button text based on the status
function getStatusButtonText(status) {
    if (status === 'collected') {
        return 'Collected';
    } else if (status === 'notcollected') {
        return 'Not Collected';
    } else if (status === 'pending') {
        return 'Partially Collected';
    } else if (status === 'rejected') {
        return 'Rejected';
    } else {
        return '';
    }
}


   
   // Select all rows when "select-all" checkbox is checked
      //  $('#select-all').on('change', function() {
      //      $('.row-select').prop('checked', $(this).prop('checked'));
      //  });

        // Update status column when dropdown is changed
        $('#collected_status_val').on('change', function() {
            var value = $(this).val();
            var ids = [];
            var collection_note = [];
            var collection_date = [];
            var recev_date = [];

            $('.row-select:checked').each(function() {
                ids.push($(this).val());
                var checkboxValue = $(this).val();//alert(checkboxValue);
                
                var note = $('#collectionnote'+ checkboxValue).val();
                var collect_date = $('#collecteddate'+ checkboxValue).val();
                var recv_date =  $('#receiveddate'+ checkboxValue).val();
                collection_note.push(note);
                collection_date.push(collect_date);
                recev_date.push(recv_date);
                
            });
            
            if (ids.length > 0) {
                $.ajax({
                    url: "{{ route('update-database') }}",
                    method: 'POST',
                    data: {
                        value: value,
                        ids: ids,
                        collection_note:collection_note,
                        collection_date:collection_date,
                        recev_date:recev_date,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(response) {
                        // Handle any errors
                    }
                });
            }
        
});



</script>
<!--<script>
  $(document).ready(function() {
    $(document).on('click', function() {
       window.location.reload();
    });
  });
</script>-->
<!--<script>
  document.addEventListener('click', function(event) {
    var targetElement = event.target;

    // Check if the clicked element is the modal close button or its descendant
    if (targetElement.closest('.btn-close')) {
      window.location.reload();
    }
  });
</script>-->
<script>
  document.getElementById('modal-close-btn').addEventListener('click', function() {
    window.location.reload();
  });
</script>
<script>
    function collectionupdat_rejecte(id) {
       // alert(id);
        document.getElementById("itemId").value = id;
        var modal = document.getElementById("myModalReject");
  
        var span = document.getElementsByClassName("close")[0];
        modal.style.display = "block";
       // modal.style.border = "1px solid black";
   
        span.onclick = function() {
            modal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Set the ID of the item being rejected as a data attribute on the modal
        modal.dataset.itemId = id;
    }

    // Add event listener to reject button
    var rejectButton = document.getElementById("collectionupdat_rejecte");
    rejectButton.addEventListener("click", function() {
        collectionupdat_rejecte(this.id);
    });

   
</script>


@endsection
