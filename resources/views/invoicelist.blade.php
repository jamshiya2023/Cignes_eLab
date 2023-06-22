@extends('layout.mainregister')
@section('content')
<style>
    .red {
        color:#f00;
    }
    .searchdate{ 
        z-index:99999 !important; 
    }
    
    
    .logo_section{
        /*position: absolute;*/     
        /*top: 4.5rem;*/
        /*width: 98%;*/
    }
    .patient_details{
        /*position: absolute;*/
        /*top: 8rem;*/
        /*width: 98%;*/
        margin-top:30px;
    }
    .green_text{
        color: #11b396;
    }
    .invoice_table{
        margin-top: 50px;
    }
    .invoice_table th, .invoice_table td{
        text-align: center;
    }
    .invoice_table{
        /*height: 300px;*/
        /*position: absolute;*/
        /*top: 10rem;*/
        /*width: 98%;*/
    }
    .table.card-table tr td{
        vertical-align: top !important;
    }
    .tabel_bottom {
        /* position: absolute; */
        /* top: 300px; */
        margin-top: 3rem;
    }
    .qr_code{
        text-align: right;
    }
    .qr_code img{
        width:40%;
    }
    .bottom_section{
        margin-top:20px;
    }
    hr{
        height: 2px !important;
    }
</style>    
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
            <div class="container-fluid">

                <div class="row g-2 row-deck">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h6 class="card-title m-0 col-md-12">Invoice List</h6>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12 bg-light pt-3 mb-3" style="border-radius:5px;">
                                        <h6 class="card-title mb-2 col-md-12">Filter By</h6>
                                        <br>
                                        <form class="row g-3"  id="searchform" name="searchform" method="post"  action="{{ route('payment.search') }}" >  
                                            @csrf
                                            <div class="row g-4 mb-3 mt-0">
                                                <div class="col-sm-2 mt-1">
                                                <label class="form-label">From Date</label>
                                                    <input type="text" class="form-control form-control-lg searchdate" name="searchfrmdate" value="{{$frmdate}}">
                                                    <!-- <div class="alert-danger pt-1 pb-1 px-1 py-1" id="frmdatealert" style="display:none ;">Please enter tax name</div> -->
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
                                                <label class="form-label">Invoice No</label>
                                                    <input type="text" class="form-control form-control-lg" name="searchinvoice" value="{{$invoiceno}}">
                                                </div>
    
                                                <div class="col-sm-2 mt-1">
                                                <label class="form-label">Status</label>
                                                <select class="form-select form-select-lg" name="searchstatus">
                                                <option value="">--Please Select--</option>
                                                <option value="credit" {{ ($status == 'credit') ? 'selected' : '' }}>Credit</option>
                                                <option value="partial" {{ ($status == 'partial') ? 'selected' : '' }}>Partially Paid</option>
                                                <option value="paid" {{ ($status == 'paid') ? 'selected' : '' }}>Paid</option>
                                                </select>
                                                </div>
    
                                                <div class="col-sm-2 mt-1">
                                                    <a style="cursor:pointer;" class="btn btn-primary mt-5" onclick="formSearch();">Search</a>
                                                    <a href="{{ url('/invoice-list') }}" class="btn btn-dark mt-5 text-white">Clear</a>
                                                </div>
    
                                                <div class="col-sm-10 m-0">
                                                    <div class="alert-danger pt-1 pb-1 px-1 py-1" id="searchalert" style="display:none;">Please enter any one of the above fields</div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="card-body">
                                
                                @if(\Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                    {{ \Session::get('success') }}
                                </div>
                                @endif


                                <table id="" class="table card-table table-hover align-middle mb-0 test" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">Registration No</th>
                                            <th style="width:10%">Invoice No</th>
                                            <th style="width:20%">Name</th>
                                            <th style="width:10%">Invoice Date</th>
                                            <th style="width:10%" class="text-center">Total</th>
                                            <th style="width:10%" class="text-center">VAT</th>
                                            <th style="width:10%" class="text-center">Paid</th>
                                            <th style="width:10%" class="text-center">Balance</th>
                                            <th style="width:10%" class="text-center">Status</th>
                                            <th style="width:10%" class="text-center">Actions</th> 
                                        </tr>
                                    </thead>
                                     <tbody>
                        @foreach($invoicelist as $key => $invoice)
                        @php
                        $date = $invoice->date;
                        $receptdate = explode('-', $date);
                        $day   = $receptdate[2];
                        $month = $receptdate[1];
                        $year  = $receptdate[0];
                        $monthname = date("M", mktime(0, 0, 0, $month, 10));                              
                        $time = $invoice->time;
                        $recepttime = explode(':', $time);
                        $timeformat = explode(' ', $recepttime[2]);
                        if($invoice->balanceamt == '0.00') { $balanceamout = '00.00'; } else { $balanceamout = $invoice->balanceamt;}
                        if($invoice->paymentstatus == 'paid') {
                        $paymentstatus = '<span class="btn btn-sm bg-success text-white" style="padding: .10rem .5rem; width:120px; cursor:text;"> Paid</span>';
                        } else if($invoice->paymentstatus == 'refunded') {
                        $paymentstatus = '<span class="btn btn-sm bg-info text-white" style="padding: .10rem .5rem; width:120px; cursor:text;"> Refunded</span>';
                        }
					               else if($invoice->paymentstatus == 'partial') {
                        $paymentstatus = '<span class="btn btn-sm bg-info text-white" style="padding: .10rem .5rem; width:120px; cursor:text;"> Partially Paid</span>';
                        } else {
                        $paymentstatus = '<span class="btn btn-sm bg-danger text-white" style="padding: .10rem .5rem; width:120px; cursor:text;"> Not Paid</span>';
                        }
                        @endphp
                        <tr>
                             <td>{{$invoice->regnumber}}</td>
                           <td><a style="cursor:pointer;" onclick="viewinvoice('{{$invoice->id}}');">{{$invoice->invoice_number}}</a></td>
                           <td>{{$invoice->name}}</td>
                           <td>{{ $monthname}} {{ $day }}, {{ $year }} {{$recepttime[0]}}:{{$recepttime[1]}} {{strtolower($timeformat[1])}}</td>
                           <td class="text-end">SR {{$invoice->totalamt}}</td>
                           <td class="text-end">SR {{number_format((float)$invoice->totaltax, 2, '.', '')}}</td>
                           <td class="text-end">SR {{$invoice->paidamt}}</td>
                           <td class="text-end"><strong>SR {{$balanceamout}}</strong></td>
                           <td class="text-center">{!! $paymentstatus !!}</td>
                           <td style="text-align:center;">
                              @php
                              if($invoice->paymentstatus != 'paid'){
                              @endphp    
                              <button type="button" class="btn btn-sm bg-success text-white"  title="Pay Now" onclick="paynow('{{$invoice->id}}');">Pay Now</button>
                              @php
                              }
                              @endphp
                              <button type="button" class="btn btn-sm bg-dark text-white"  title="View Invoice" onclick="viewinvoice('{{$invoice->id}}');">View</button>
                           @php
                              if($invoice->paidamt != '0'){
                              @endphp   
							  <!--<a class="btn btn-sm bg-success text-white" onclick = "invoicedetails({{$invoice->reg_id}})">Refund</a> -->
							  
                            @php
                              }
                              @endphp
                                <a class="btn btn-sm bg-success text-white" onclick = "invoicedetails_new({{$invoice->reg_id}})">Pay View</a>
						   </td>
						 
                        </tr>
                        @endforeach    
                     </tbody>
                    </table>
                            </div>

                            <!-- Modal -->
                            
                         <form class="row"  method="post"    action="{{ url('refundpaymentadd') }}" >                            
                    
                  @csrf
			   <div class="modal fade" id="refundcollections" tabindex="-1" style="z-index:9999;">
                     <div class="modal-dialog">
					  
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Refund Payment</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closesinglenormalrange"></button>
                           </div>
                           <div class="modal-body">
                              <div class="row g-4">
                                 <div class="col-sm-4">
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Payment Method
                                    </label>
                                 </div>
                                
                                 <div class="col-sm-4">
                                 <label class="form-check-label" for="flexCheckDefault">
                                    Refund Amount  
                                 </label>
                                 </div>
                                 <div class="col-sm-8">
								  <input type="hidden"   id="indid" name="invoiceid"  > 
                                 <input type="text" class="form-control form-control-lg" name="total"> 
                               <!---  <div class="alert-danger pt-1 pb-1 px-1 py-1" id="paidamountalert" style="display:none ;">Please enter amount</div>---->
                                 </div>
                                 <div class="col-sm-12"> 
                                 <button type="submit" class="btn btn-primary" value="submit"> Submit</button>
                                 <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>  
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
				    </form>    
                         <!-- VIEW INVOICE MODAL STARTS HERE -->
               <div class="modal fade" id="collection" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-scrollable">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">Invoice #<span id="invoice_number"></span></h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom_scroll">
                           <table class="table table-borderless mb-0">
                              <tbody>
                                 <tr>
                                    <td>
                                       Date <span id="date"></span>
                                    </td>
                                    <td class="text-end">
                                       <span class="text-success"> <strong>Status:</strong> <span id="paymentstatus"></span></span>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>
                                       <div>From:</div>
                                       <div class="fs-6 fw-bold mb-1">Cignes Lab App </div>
                                       <div>7272 Abi Dhar Al Ghaffari</div>
                                       <div>Email: info@cignes.com.pl</div>
                                       <div>Phone: +966 50 524 0523</div>
                                    </td>
                                    <td class="text-end">
                                       <div>To:</div>
                                       <div class="fs-6 fw-bold mb-1">Bob Mart</div>
                                       <div>Attn: Daniel Marek</div>
                                       <div>Email: mart@bobmart.com</div>
                                       <div>Phone: +48 123 456 789</div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="2">
                                       <table class="table table-borderless table-striped mb-0">
                                          <thead>
                                             <tr>
                                                <th class="text-center" style="width:5%">#</th> 
                                                <th class="text-center" style="width:30%">Test</th>
                                                <th class="text-end" style="width:15%">Unit Price</th>
                                                <th class="text-end" style="width:15%">Discount</th>
                                                <th class="text-end" style="width:15%">Tax</th>
                                                <th class="text-end" style="width:15%">Sub Total</th>
                                                <th class="text-end" style="width:5%">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody id="tblcollectionpopup">
                                          </tbody>
                                          <tbody>
                                                <tr>
                                                <td colspan="4">
                                                   <h6>Terms &amp; Condition</h6>
                                                   <p class="text-muted">You know, being a test pilot isn't always the healthiest<br/> business in the world. We predict too much for the next<br/> year and yet far too little for the next 10.</p>
                                                </td>
                                                <td colspan="3">
                                                   <table class="table table-borderless mb-0">
                                                      <tbody>
                                                         <tr>
                                                            <td><strong>Total Unit Price</strong></td>
                                                            <td class="text-end">SR <span id="test_unitprice"></span></td>
                                                         </tr>
                                                         <tr>
                                                            <td><strong>Tax </strong></td>
                                                            <td class="text-end">SR <span id="test_tax_amount"></span></td>
                                                         </tr>
                                                         <tr>
                                                            <td><strong>Total</strong></td>
                                                            <td class="text-end"><strong>SR <span id="test_subtotal"></span></strong></td>
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
					<input type="hidden" name="invoice_number"	id="invoice_number">
                        <div class="modal-footer">
                         <a class="btn btn-sm bg-success text-white" onclick="collectrefund()"><i class="fa fa-backward me-2"></i>Refund</a> 
                       
						 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div> 
                     </div>
                  </div>
               </div>
               <!-- VIEW INVOICE MODAL ENDS HERE -->   
               
               
               
              
               
               
               
               
               
               
               
                            
<!-- VIEW INVOICE MODAL STARTS HERE -->
                        
                    <div id="printThis">
                        <div class="modal fade" id="invoice_detail" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable invoice_modal_view" style="width: 100%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modaltitle"> </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body custom_scroll" id="printable_invoice" style="width: 100%;">
                                        <div class="row logo_section">
                                            <div class="col-md-6 col-12">
                                                <img src="{!! asset('assets/images/logo3.png') !!}" alt="logo" style="width:20%;">
                                               <!--src="{!! asset('assets/images/logo3.png') !!}">-->
                                              
                                            </div>
                                            <div class="col-md-6 col-12 text-end">
                                                <h3>Invoice</h3>
                                                <h5> فاتورة  </h5>
                                            </div>
                                        </div> 
                                        <div class="row patient_details" style="display:inline-flex; width:100%;">
                                            <div class="col-md-6" style="padding-right: 10px;">
                                                <div class="row">
                                                    <div class="col-md-6 green_text"><b>INVOICE TO</b></div>
                                                    <div class="col-md-6 text-end green_text"><b> فاتورة إلى  </b></div>
                                                    <br><br>
                                                    <div class="col-md-4"><b>Patient Name</b></div>
                                                    <div class="col-md-4 text-center"><span id="patientname"></span> </div>
                                                    <div class="col-md-4 text-end"><b> اسم المريض</b></div>
                                                    
                                                    <div class="col-md-4"><b>ID No.</b></div>
                                                    <div class="col-md-4 text-center">IDNO<span id="reg_id"></span></div>
                                                    <div class="col-md-4 text-end"><b> رقم بطاقة الهوية  </b></div>
                                                    
                                                    <div class="col-md-4" style="margin-bottom: 30px;"><b>Mobile No.</b></div>
                                                    <div class="col-md-4 text-center" style="margin-bottom: 30px;"><span id="patientphone"></span></div>
                                                    <div class="col-md-4 text-end" style="margin-bottom: 30px;"><b> رقم المحمول  </b></div>
                                                    <br><br>
                                                    
                                                    <div class="col-md-6 green_text"><b>RESERVATION INFO</b></div>
                                                    <div class="col-md-6 text-end green_text"><b> معلومات الحجز   </b></div>
                                                    <br><br>
                                                    <div class="col-md-4"><b>Reservation No.</b></div>
                                                    <div class="col-md-4 text-center">RESRV<span id="reg_id"></div>
                                                    <div class="col-md-4 text-end"><b>  رقم الحجز.  </b></div>
                                                    
                                                    <div class="col-md-4"><b>User Name</b></div>
                                                    <div class="col-md-4 text-center"><span id="username"></span></div>
                                                    <div class="col-md-4 text-end"><b>  اسم المستخدم   </b></div>
                                                    
                                                    <div class="col-md-4" style="margin-bottom: 30px;"><b>Collection Date & Time</b></div>
                                                    <div class="col-md-4 text-center" style="margin-bottom: 30px;"><span id="collectiondate"></span></div>
                                                    <div class="col-md-4 text-end" style="margin-bottom: 30px;"><b>  تاريخ ووقت التحصيل  </b></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6" style="padding-left: 10px;">
                                                <div class="row">
                                                    <div class="col-md-6 green_text"><b>INVOICE FROM</b></div>
                                                    <div class="col-md-6 text-end green_text"><b>  نموذج الفاتورة  </b></div>
                                                    <br><br>
                                                    <div class="col-md-4"><b>Branch Name</b></div>
                                                    <div class="col-md-4 text-center">Cignes Lab App</div>
                                                    <div class="col-md-4 text-end"><b>  اسم الفرع  </b></div>
                                                    
                                                    <div class="col-md-4"><b>VAT No.</b></div>
                                                    <div class="col-md-4 text-center">---</div>
                                                    <div class="col-md-4 text-end"><b> ضريبة القيمة المضافة لا   </b></div>
                                                    
                                                    <div class="col-md-4" style="margin-bottom: 30px;"><b>Phone No.</b></div>
                                                    <div class="col-md-4 text-center" style="margin-bottom: 30px;">---</div>
                                                    <div class="col-md-4 text-end" style="margin-bottom: 30px;"><b>  رقم الهاتف  </b></div>
                                                    <br><br>
                                                    
                                                    <div class="col-md-6 green_text"><b>PAYMENT INFO</b></div>
                                                    <div class="col-md-6 text-end green_text"><b>  معلومات الدفع   </b></div>
                                                    <br><br>
                                                    <div class="col-md-4"><b>Invoice No.</b></div>
                                                    <div class="col-md-4 text-center"><span id="invoiceNumber"></span></div>
                                                    <div class="col-md-4 text-end"><b> رقم الفاتورة   </b></div>
                                                    
                                                    <div class="col-md-4"><b>Payment Method</b></div>
                                                    <div class="col-md-4 text-center"><span id="paymethod"></span></div>
                                                    <div class="col-md-4 text-end"><b> طريقة الدفع او السداد   </b></div>
                                                    
                                                    <div class="col-md-4" style="margin-bottom: 30px;"><b>Date & Time</b></div>
                                                    <div class="col-md-4 text-center" style="margin-bottom: 30px;"><span id="invoicedate"></span></div>
                                                    <div class="col-md-4 text-end" style="margin-bottom: 30px;"><b>  التاريخ والوقت    </b></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row invoice_table">
                                            <table id="" class="table card-table table-hover align-middle mb-0" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Service Name  <br>   اسم الخدمة</th>
                                                        <th>Unit Price   <br>   سعر الوحدة</th>
                                                        <th>Discount   <br>   تخفيض</th>
                                                        <th>VAT Amount   <br>   قيمة الضريبة</th>
                                                        <th>Subtotal (Including VAT)  <br>  المجموع الفرعي (شاملاً ضريبة القيمة المضافة)   </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="modelbody">
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row tabel_bottom">
                                            <div class="col-md-3">
                                                <div class="qr_code">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/800px-QR_code_for_mobile_English_Wikipedia.svg.png">
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="bottom_section">
                                                     <div class="row">
                                                        <div class="col-md-4"><b>Subtotal (Excluding VAT)</b></div>
                                                        <div class="col-md-4 text-center"><b><span id="totalunitprice"></span></b></div>
                                                        <div class="col-md-4 text-end"><b> المجموع الشامل (شاملاً ضريبة القيمة المضافة)  </b></div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4"><b>Total VAT</b></div>
                                                        <div class="col-md-4 text-center"><b><span id="totaltax"></span></b></div>
                                                        <div class="col-md-4 text-end"><b>  إجمالي ضريبة القيمة المضافة   </b></div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4"><b>Total Amount</b></div>
                                                        <div class="col-md-4 text-center"><b><span id="finaltotal"></span></b></div>
                                                        <div class="col-md-4 text-end"><b>  إجمالي ضريبة القيمة المضافة   </b></div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4"><b>Total Paid Amount</b></div>
                                                        <div class="col-md-4 text-center"><b><span id="payAmount"></span></b></div>
                                                        <div class="col-md-4 text-end"><b>  إجمالي ضريبة القيمة المضافة   </b></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row total_section">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9">
                                                <div class="bottom_section">
                                                    <div class="row">
                                                        <div class="col-md-4 green_text"><b>Total Amount Due</b></div>
                                                        <div class="col-md-4 text-center green_text"><b><span id="balanceamount"></span></b></div>
                                                        <div class="col-md-4 text-end green_text"><b>  إجمالي المبلغ المستحق  </b></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        <div class="row login_detail_section">
                                            <h6 class="card-title" style="">Login Details</h6>
                                        </div>
                                    
                                        <div class="row login_detail_section1">
                                            <div class="col-md-3">
                                                <span>Username: <b><span id="usernames"></span></b></span>
                                            </div>
                                            <div class="col-md-3">
                                                <span>Password: <b><span id="password"></span></b></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="printInvoice()"><i class="fa fa-print me-2"></i>Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                        
                        <!-- PRINT DIV ENDS HERE -->
<!-- VIEW INVOICE MODAL ENDS HERE -->  

<!--Pay View Modal Start-->
<div class="modal fade" id="collection_new" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invoice #<span id="invoicesNumber"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom_scroll">
                <table class="table table-borderless mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:18%">#</th>
                            <th class="text-center" style="width:18%">Date</th>
                            <th class="text-center" style="width:18%">Voucher Number</th>
                            <th class="text-center" style="width:18%">Paid Amount</th>
                            <th class="text-center" style="width:18%">Paid Method</th>
                        </tr>
                    </thead>
                    <tbody id="tblinvoicepopup"></tbody>
                </table>
            </div>
            <input type="hidden" name="invoicesNumber" id="invoicesNumber">
            <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--Pay View Modal End-->


                <!-- PAYMENT MODAL STARTS HERE -->
                <form class="row" id="paymentupdateform" name="paymentupdateform" method="post"  action="{{ route('payment.update') }}" >                            
                @csrf
                
                <div class="modal fade" id="payment" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Payment of Invoice# INV-<span id="invoicenumber"></span></h5>
                                            <button type="button" class="btn-close" id="payment-update-close-x" ></button>
                                        </div>
                                        <div class="modal-body">


                                        <div class="row g-4">
                                            <div class="col-sm-4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                Total Amount 
                                                </label>
                                            </div>
                                            <div class="col-sm-8" id="totalamt"> 
                                                
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-check-label text-success" for="flexCheckDefault">
                                                Paid Amount 
                                                </label>
                                            </div>
                                            <div class="col-sm-8 text-success" id="paidamt"> 
                                                
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-check-label text-danger" for="flexCheckDefault">
                                                Balance Amount 
                                                </label>
                                            </div>
                                            <div class="col-sm-8 text-danger" id="balanceamt"> 
                                                
                                            </div>
                                            

                                            <div class="col-sm-4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                               Pay Amount <span class="red">*</span>
                                                </label>
                                            </div>  
                                            <div class="col-sm-8"> 
                                                <input type="number" class="form-control form-control-lg" name="paidamount" id="txtpaidamount" onchange="calculatedueamt();" onkeyup="calculatedueamt();"> 
                                                <div class="alert-danger pt-1 pb-1 px-1 py-1" id="paidamountalert" style="display:none ;">Please enter pay amount</div>  
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-check-label text-danger" for="flexCheckDefault">
                                               Due Amount
                                                </label>
                                            </div>  
                                            <div class="col-sm-8 text-danger" id="dueamount"><strong>SR 0.00</strong></div>
                                            
                                            

                                            <div class="col-sm-4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                Payment Method <span class="red">*</span>
                                                </label>
                                            </div>  
                                            <div class="col-sm-8"> 
                                            <select class="form-select form-select-lg" name="paymentmethod" id="paymentmethod">
                                            </select>
                                            <div class="alert-danger pt-1 pb-1 px-1 py-1" id="paymentmethodalert" style="display:none ;">Please select payment method</div>    
                                            </div>

                                            <div class="col-sm-12"> 
                                            <input type="hidden" id="hiddenbalanceamt" name="hiddenbalanceamt" value="">
                                            <input type="hidden" id="hiddenid" name="hiddenid" value=""> 
                                            <input type="hidden" id="hiddeninvoiceid" name="hiddeninvoiceid" value="">    
                                            <a style="cursor:pointer;" class="btn btn-primary" onclick="paymentupdatevalidation();">Save</a>
                                            </div>                  
                                            
                                            <div class="col-sm-12">
                                                <span><strong>Previous Payment List</strong></span>
                                            <table class="table card-table table-hover align-middle mb-0">
                             
                                           <thead>
                                             <tr>
                                                <th class="text-center" style="width:18%">#</th> 
                                                 <th class="text-center" style="width:18%">Date</th>
                                                <!--<th class="text-center" style="width:30%">Test</th>-->
                                                <th class="text-center" style="width:18%">Voucher Number</th>
                                                <!--<th class="text-end" style="width:15%">Discount</th>-->
                                                <!--<th class="text-end" style="width:15%">Tax</th>-->
                                                <th class="text-center" style="width:18%">Paid Amount</th>
                                                 <th class="text-center" style="width:18%">Paid Method</th>
                                                <!--<th class="text-end" style="width:5%">Action</th>-->
                                             </tr>
                                </thead>
                                     <tbody id="tblinvoicePaypopup"></tbody>
                                        
                                         
                                       </table>
                                            </div>
                                                
                                        </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

</form>

<!-- PAYMENT MODAL ENDS HERE -->


                            
                        </div>
                    </div>
                </div> <!-- .row end -->

            </div>
        </div>



      
<script src="{!! asset('assets/plugin/jquery/3.3.1/jquery.min.js') !!}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#invoice_detail,#payment').modal({
            backdrop: 'static',
            keyboard: false
        })
   });
   
function collectrefund() {
                
		   var input = document.getElementsByName("test_subtotal");
		   
		  var total = 0;
		  for (var i = 0; i < input.length; i++) {
			if (input[i].checked) {
			  total += parseFloat(input[i].value);
			}
		  }
		   
    document.getElementsByName("total")[0].value = "" + total.toFixed(2); 
	var ind_id = document.getElementById("ind_id").value; 
	 $('#indid').val(ind_id);
	 $('#refundcollections').modal('show');
}

 
                       		    
		function myclickz() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("submit_values");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}		
                       
			    
                       
function formSearch(){
   
    document.getElementById('searchalert').style.display = 'none';

    if(document.searchform.searchfrmdate.value !='' || document.searchform.searchtodate.value !='' || document.searchform.searchcustomer.value !='' || document.searchform.searchinvoice.value !='' || document.searchform.searchstatus.value !='')
    {
        document.searchform.submit();
       /* var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        var searchfrmdate   = document.searchform.searchfrmdate.value;
        var searchtodate    = document.searchform.searchtodate.value;
        var searchcustomer  = document.searchform.searchcustomer.value;
        var searchinvoice   = document.searchform.searchinvoice.value;
        var searchstatus    = document.searchform.searchstatus.value;
        

        //alert(token);
        $.ajax({
            url:"{{'search-invoice'}}",
            type: 'POST',
            data: { 
                frmdate:searchfrmdate,
                todate:searchtodate,
                customer:searchcustomer,
                invoiceno:searchinvoice,
                status:searchstatus,
                _token:token
            },
            success: function(response){
                alert(response.invdata);

            }
        });*/

    } else {
        document.getElementById('searchalert').style.display = 'block';
        return false;

    }

    //document.searchform.submit();
    

}   

function calculatedueamt(){
    var bal = $('#hiddenbalanceamt').val();
    var payamt = $('#txtpaidamount').val();

    var dueamt;
    if(payamt !=''){
     dueamt = (parseFloat(bal) - parseFloat(payamt));
    } else { 
        //alert(payamt);
        dueamt = 0;        
    }
    $('#dueamount').html('<strong>SR '+dueamt.toFixed(2)+'</strong>');
}  

function paymentupdatevalidation(){
    document.getElementById('paymentmethodalert').style.display = 'none';
    document.getElementById('paidamountalert').style.display = 'none';
    
    if(document.paymentupdateform.paidamount.value =='')
    {
        document.getElementById('paidamountalert').style.display = 'block';
        return false;
    }

    if(document.paymentupdateform.paymentmethod.value =='')
    {
        document.getElementById('paymentmethodalert').style.display = 'block';
        return false;
    }
    

    if (parseFloat(document.paymentupdateform.paidamount.value) > parseFloat(+document.paymentupdateform.hiddenbalanceamt.value))
    {
        document.getElementById('paidamountalert').style.display = 'block';
        document.getElementById('paidamountalert').innerHTML = 'Paid amount is greater than balance amount.';
        document.newregistration.paidamount.select();
        return false;
    }
    
    document.paymentupdateform.submit();
    return true;
}

function paynow(id){
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    $.ajax({
        url:"{{'view-payment'}}",
        type: 'POST',
        data: { 
            id:id,
            _token:token
        },
        success: function(response){
            var invnumber;
            var totalamt;
            var paidamt;
            var balanceamt;
            var roundtotalamt;
            var roundpaidamt;
            var roundbalanceamt;
            var hiddenid;
            //var paymethodhtml="";
            var paymethodhtml = "";
            $('#payment').modal('show');
           
            $.each(response.paymentdetails, function( index, paydetails ) {
                hiddenid = paydetails.invid; 
                invnumber = paydetails.invoice_number;
                totalamt = Number(paydetails.totalamt);
                paidamt = Number(paydetails.paidamt);
                balanceamt = Number(paydetails.balanceamt);
            });
            roundtotalamt = totalamt.toFixed(2);
            roundpaidamt = paidamt.toFixed(2);
            roundbalanceamt = balanceamt.toFixed(2);
            $('#hiddenid').val(hiddenid);
            $('#hiddeninvoiceid').val(invnumber);            
            $('#hiddenbalanceamt').val(roundbalanceamt);
            $('#invoicenumber').html(invnumber);
            $('#totalamt').html('<strong>SR '+roundtotalamt+'</strong>');
            $('#paidamt').html('<strong>SR '+roundpaidamt+'</strong>');
            $('#balanceamt').html('<strong>SR '+roundbalanceamt+'</strong>');
            paymethodhtml = '<option value="">-- Please Select --</option>';
            
            $.each(response.paymentmethods, function( index, paymethod) { 
                
                paymethodhtml += '<option value="'+paymethod.id+'">'+paymethod.paymentmethod+'</option>';            
               
            });
            $('#paymentmethod').html(paymethodhtml);            
            var testlist = "";
                            var num = 0;  
                             
                              $.each(response.testlists, function(index, tests) {
                                  console.log(tests);
                                  
                                  num = num+1;    
                                //"'+tests.ind_id+'" 
                  			   testlist += '<tr><td class="text-center">'+ num +'</td><td class="text-center">'+tests.date+'</td><td class="text-center">'+tests.vouchernumber+'</td><td class="text-center">'+tests.paidamt+'</td><td class="text-center">'+tests.paymentmethod+'</td><td class="text-center"><input type="hidden" id="ind_id" name="ind_id" value="'+tests.ind_id+'"></td></tr>';     
                               $('#invoicesNumber').html(tests.invoiceno);
                                 console.log(tests.invoiceno); 
                              });
                              $('#tblinvoicePaypopup').html(testlist);
            
        }
    });



    

}

function viewinvoice(id){
   // var token = $('input[name="_token"]').val();
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    $.ajax({
        url:"{{'view-invoice'}}", 
        type: 'POST',
        data: { 
            id:id,
            _token:token
        },
        success: function(response){
            var paymentstatus;
            var statushtml;
            var invoicenumber;
            var registerdate;
            var customerdetailshtml=''; 
            var invoicehtml='';
            var num;
            var tax;
            var unitprice;
            var subtotal;
            var discount;
            var unitpricetotal = 0;
            var taxtotal = 0;
            var discounttotal = 0;
            var finaltotal = 0;
            var paidamt;
            var balanceamt; 

            var addonehtml;
            var addtwohtml;
            var placehtml;
            var cityhtml;
            var pincodehtml;
            var emailhtml;
            var phonehtml;

            var splitdate;
            var monthname;
            var day;
            var year;
            var registertime;
            var splittimespace;
            var splittimecolumn;
            var timeformat;

            
            $('#invoice_detail').modal('show');
           
            $.each(response.invoicedetails, function( index, indetails ) { 
                num = index+1;
                unitprice = Number(indetails.unitprice);
                unitpricetotal += unitprice;
                tax = Number(indetails.tax);
                taxtotal += tax;
                discount = Number(indetails.discount);
                discounttotal += discount;
                subtotal = Number(indetails.subtotal);
                finaltotal += subtotal;                
                invoicehtml +='<tr><td class="text-center" style="text-align:center !important;border: 1px solid #eee !important;padding: 0.8rem 0.6rem;">'+num+'</td><td class="text-first" style="border: 1px solid #eee !important;padding: 0.8rem 0.6rem;">'+indetails.testname+'</td><td class="text-end" style="text-align:right !important;border: 1px solid #eee !important;padding: 0.8rem 0.6rem;">SR '+indetails.unitprice+'</td><td class="text-end" style="text-align:right !important;border: 1px solid #eee !important;padding: 0.8rem 0.6rem;">SR '+indetails.discount+'</td><td class="text-end" style="text-align:right !important;border: 1px solid #eee !important;padding: 0.8rem 0.6rem;">SR '+indetails.tax+'</td><td class="text-end" style="text-align:right !important;border: 1px solid #eee !important;padding: 0.8rem 0.6rem;">SR '+indetails.subtotal+'</td></tr>';             
            });
            var roundunitpricetotal = unitpricetotal.toFixed(2);
            var roundtaxtotal = taxtotal.toFixed(2);
            var roundfinaltotal = finaltotal.toFixed(2);
            var rounddiscounttotal = discounttotal.toFixed(2);
            document.getElementById('modelbody').innerHTML = invoicehtml;
           
               
            $.each(response.customerdetails, function( index, customer ) { 
                paymentstatus = customer.paymentstatus;
                invoicenumber = customer.invoice_number;   
                paidamt = customer.paidamt;
                balanceamt = customer.balanceamt;  
                
                
                //registerdate = '<strong>'+customer.date+'</strong>';

                registerdate = customer.date;
                splitdate = registerdate.split("-");
                monthname = new Date(registerdate).toLocaleString('en-us',{month:'short'})
                day = splitdate[2];
                year = splitdate[0];                
                registerdatehtml = monthname+' '+day+', '+year;

                registertime = customer.time;
                splittimespace = registertime.split(" ");
                splittimecolumn = splittimespace[0].split(":");
                timeformat = splittimecolumn[0]+':'+splittimecolumn[1]+' '+splittimespace[1].toLowerCase();

                if($.trim(customer.phone) == ''){ phonehtml = ''; } else { phonehtml = 'Phone: '+customer.phone; }
                if($.trim(customer.email) == ''){ emailhtml = ''; } else { emailhtml = 'Email: '+customer.email; }
                if($.trim(customer.addone) == ''){ addonehtml = ''; } else { addonehtml = customer.addone; }
                if($.trim(customer.addtwo) == ''){ addtwohtml = ''; } else { addtwohtml = customer.addtwo; }
                if($.trim(customer.place) == ''){ placehtml = ''; } else { placehtml = customer.place; }
                if($.trim(customer.city) == ''){ cityhtml = ''; } else { cityhtml = customer.city+','; }
                if($.trim(customer.pincode) == ''){ pincodehtml = ''; } else { pincodehtml = '- '+customer.pincode; }
                
                 console.log(customer.name);
                 $('#patientname').html(customer.name);
                  $('#patientphone').html(customer.phone);
                  $('#username').html(customer.username);
                  $('#usernames').html(customer.username);
                  $('#password').html(response.password);
                  $('#reg_id').html(response.reg_id);
                   $('#collectiondate').html('<strong>'+registerdatehtml+' '+timeformat+'</strong>');
                   $('#invoiceNumber').html(invoicenumber);
                   $('#invoicedate').html('<strong>'+registerdatehtml+' '+timeformat+'</strong>');
                   $('#payAmount').html('<strong>SR '+paidamt+'</strong');
                    var payment_methods  = response.invoicelist[index];
                  console.log(payment_methods.pay_method);
                  if(payment_methods.pay_method == null)
                  {
                      $('#paymethod').html('Cash/Card');
                  }
                  else
                  {
                       $('#paymethod').html(payment_methods.pay_method);
                  }
                   
                   
                customerdetailshtml = '<div>To:</div><div class="fs-6 fw-bold mb-1">'+customer.name+'</div><div>'+addonehtml+'</div><div>'+addtwohtml+' '+placehtml+'</div><div>'+cityhtml+' '+customer.country+' '+pincodehtml+'</div><div>'+emailhtml+'</div><div>'+phonehtml+'</div>';            
                
            });
            if(paymentstatus == 'paid'){
                statushtml = '<span class="text-success"> <strong>Status:</strong> Paid</span>';
                $('#paidamount').html('');
                $('#balanceamount').html('SR 0.00'); 
            } else if(paymentstatus == 'partial'){
                statushtml = '<span class="text-info"> <strong>Status:</strong> Partially Paid</span>';   
                $('#paidamount').html('<strong>SR '+paidamt+'</strong>');
                $('#balanceamount').html('<strong>SR '+balanceamt+'</strong>'); 
            } else {
                statushtml = '<span class="text-danger"> <strong>Status:</strong> Not Paid</span>'; 
                $('#paidamount').html('<td class="text-success"><strong>Paid</strong></td><td class="text-end text-success  "><strong>SR '+paidamt+'</strong></td>');
                $('#balanceamount').html('<td class="text-danger"><strong>Balance</strong></td><td class="text-end text-danger"><strong>SR '+balanceamt+'</strong></td>'); 
            }
            //$('#modelfoot').html('<tr><td colspan="3"><h6>Terms &amp; Condition</h6><p class="text-muted">You know, being a test pilot isnt always the healthiest business in the world. We predict too much for the next year and yet far too little for the next 10.</p></td><td colspan="3"><table class="table table-borderless mb-0"><tbody><tr><td ><strong>Total Unit Price</strong></td><td class="text-end">SR '+unittotal+'</td></tr><tr><td ><strong>Tax </strong></td><td class="text-end">SR 22.50</td></tr><tr><td ><strong>Total</strong></td><td class="text-end"><strong>SR 422.50</strong></td></tr></tbody></table></td></tr>');
            
            $('#totalunitprice').html('<strong>SR '+roundunitpricetotal+'</strong>');
            $('#totaltax').html('<strong>SR '+roundtaxtotal+'</strong>');
            $('#totaldiscount').html('<strong>SR '+rounddiscounttotal+'</strong>');
            $('#finaltotal').html('<strong>SR '+roundfinaltotal+'</strong>');             
            $('#modaltitle').html('Invoice# '+invoicenumber);
            
            
            $('#status').html(statushtml);
            $('#customeraddress').html(customerdetailshtml);


            
        }
    });

}


$('#payment-update-close-x, #payment-update-close').click(function() {
        $('#txtpaidamount').val('');
        //$('#regfrom').prop('selectedIndex',0);
        $('#paidamountalert').hide();
        $('#paymentmethodalert').hide();
        
        //$('#statenamealert').hide();
        $('#payment').modal('hide');
    });

</script>

<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
<script src="{!! asset('assets/bundles/flatpickr.bundle.js') !!}"></script>
<script>
$(function() {
    $("body").delegate(".searchdate", "focusin", function(){
        $(this).flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            //dateFormat: "d-M-Y",
            //time24hr:false
            //defaultDate: "2020-11-26 14:30 PM" 
            
            
        });
    });
    
});    

</script>
  <script type='text/javascript' src="{!! asset('assets/bundles/jquery.inputmask.bundle.js') !!}"></script>


<!--*******************Print Script*************************/
<!-- Add the following script at the end of your Laravel Blade template -->
<script type="text/javascript">
  $(document).ready(function () {
    $('#printButton').click(function () {
      //  var printWindow = window.open('', '_blank');

      let htmlContent = $('#printable').html();
        printWindow.document.open();
         printWindow.document.write(`
            <html>
                <head>
                    <style>
                        @import url('https://elab.apitgroup.com/assets/css/luno.style.min.css');
                        @media print{
                        .print_body .logo_section, .print_body .patient_details {
                            width: 100% !important;
                        }
                        .logo_section{
                            display: inline-flex !important;
                        }
                        .print_body .logo_section .col-md-6, .print_body .patient_details .col-md-6, .print_body .patient_details .col-md-6 .row .green_text{
                            float:left !important;
                            width: 50% !important;
                            display: inline-flex !important;
                        }
                        .print_body .patient_details .col-md-6 .row .text-end{
                            text-align: right !important;
                        }
                        .text-end{
                            text-align: right !important;
                        }
                        .text-center{
                            text-align: center !important;
                        }
                        .green_text{
                            color: #11b396;
                        }
                        .invoice_table{
                            margin-top: 50px;
                        }
                        .invoice_table th, .invoice_table td{
                            text-align: center;
                        }
                        .qr_code img{
                            width:40%;
                        }
                    }
                </style>
            </head>
            <body>
                ${htmlContent}
            </body>
        </html>
    `);
        printWindow.document.close();

// Trigger the print dialog for the new window or iframe
        printWindow.print();
     // printJS({ printable: htmlContent, type: 'html', documentTitle: 'Invoice' });
    });
  });
</script>

<script type="text/javascript">
function printInvoice() {
    let printWindow = window.open("", "_blank");

    printWindow.document.write("<html><head><title>Print Invoice</title>");
    printWindow.document.write("<link rel='stylesheet' href='{!! asset('assets/css/print.css') !!}' media='print'>");
    printWindow.document.write("<style>");
    printWindow.document.write("body { margin: 5px; }");
    // Add any additional styling for the modal here

    printWindow.document.write("</style></head><body>");
    printWindow.document.write("<div class='modal fade show' tabindex='-1' aria-hidden='true'>");
    printWindow.document.write("<div class='modal-dialog modal-lg modal-dialog-scrollable'>");
    printWindow.document.write("<div class='modal-content'>");

    let printableElement = document.getElementById("printable_invoice").cloneNode(true);
    // Remove any unwanted elements from the printable content
    let unwantedElements = printableElement.getElementsByClassName("modal-footer");
    while (unwantedElements.length > 0) {
        unwantedElements[0].parentNode.removeChild(unwantedElements[0]);
    }
    
    printWindow.document.write(printableElement.outerHTML);

    printWindow.document.write("</div></div></div></body></html>");
    printWindow.document.close();

    printWindow.onload = function () {
        printWindow.print();
        printWindow.onafterprint = function () {
            printWindow.close();
        };
    };
}
</script>

<!--<script type="text/javascript">

 function printInvoice() {
     // printJS('printable', 'html')

     let printFrame = document.createElement("iframe")
     let printableElement = document.getElementById("printable")
     //
     // // printframe.setattribute("style", "visibility: hidden; height: 0; width: 0; position: absolute;")
     printFrame.setAttribute("id", "printjs")
     printFrame.srcdoc = "<html><head><title>document</title></head><body style='margin: 5px;'>" +
       printableElement.outerHTML + "<style>@page { size: A4; }"

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
</script>-->
<script>
     function invoicedetails_new(id){
                      var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                        $.ajax(
					  {
                          url:"{{'invoicepay-view'}}", 
                          type: 'POST',
                          data: {
                              id:id,
                              _token:token
                          },
                          success: function(response){
                              
                      
                              $('#collection_new').modal('show');
                  			  var testlist = "";
                            var num = 0;  
                             
                              $.each(response.testlists, function(index, tests) {
                                  console.log(tests);
                                  
                                  num = num+1;    
                                //"'+tests.ind_id+'" 
                  			   testlist += '<tr><td class="text-center">'+ num +'</td><td class="text-center">'+tests.date+'</td><td class="text-center">'+tests.vouchernumber+'</td><td class="text-center">'+tests.paidamt+'</td><td class="text-center">'+tests.paymentmethod+'</td><td class="text-center"><input type="hidden" id="ind_id" name="ind_id" value="'+tests.ind_id+'"></td></tr>';     
                               $('#invoicesNumber').html(tests.invoiceno);
                                 console.log(tests.invoiceno); 
                              });
							  // $('#ind_id').html(tests.ind_id); 
							  //$('#test_date').html(response.test_date);
                             // $('#test_unitprice').html(response.test_unitprice);
							 // $('#test_tax_amount').html(response.test_tax_amount);
							 // $('#test_subtotal').html(response.test_subtotal);
							   
							  // console.log(response.invoice_number);
							  //  $('#date').html(response.date);
							  // $('#paymentstatus').html(response.paymentstatus);
                              $('#samplealert').html('');
                              $('#tblinvoicepopup').html(testlist);
                              
                               
                          }
                      });   
                       }
			    
</script>

<script src="{!! asset('assets/js/bundle/dataTables.bundle.js') !!}"></script>

        <script>
    // project data table
    $('.test').addClass('nowrap').dataTable({
      

      responsive: true,
     order: [[1, 'desc']]
    });
    
    
  </script>
@endsection