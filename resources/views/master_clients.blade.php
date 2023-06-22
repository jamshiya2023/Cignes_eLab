@extends('layout.maintemplate')
@section('content')
<style>
    .sidemenu{
        border: 1px dashed var(--border-color);
        list-style: none;
        border-radius: .75rem;
        padding: 0 1rem;
        font-size: 1rem;
        background:#fff;
    }

    .sidemenu .m-link {
        color: var(--color-600);
        align-items: center;
        padding: 10px 0;
    }

    .sidemenu .m-link, .sidemenu .ms-link {
        display: flex;
    }


    .sidemenu .sub-menu {
        transition: ease 0.2s;
        list-style: none;
        position: relative;
        padding-left: 34px;
        margin-bottom: 10px;
    }

    .sidemenu .sub-menu::before {
        background-color: var(--secondary-color);
        content: "";
        position: absolute;
        height: 100%;
        width: 1px;
        left: 10px;
        top: 0;
    }

    .sidemenu .ms-link:hover, .sidemenu .ms-link.active {
        color: var(--secondary-color);
    }

    .sidemenu .ms-link {
        color: var(--color-600);
        position: relative;
        padding: 4px 0!important;
        font-size: 15px;
    }



    .sidemenu .m-link:hover::before, .sidemenu .m-link.active::before, .sidemenu .ms-link:hover::before, .sidemenu .ms-link.active::before {
        display: block;
    }


    .sidemenu .ms-link::before{
        background-color: var(--secondary-color);
        content: "";
        display: none;
        position: absolute;
        height: 9px;
        width: 9px;
        left: -28px;
        top: 10px;
        border-radius: 10px;
    }

    .sidemenu > li {
        border-bottom: 1px dashed var(--border-color);
    }

    .sidemenu li a span .ms-auto {
        margin-left: !important;
    }
    .red {
        color:#f00;
    }
    </style>


        <!-- start: page body -->
        <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
            <div class="container-fluid"> 
            	<div class="row">
                	<!-- COL 3 STARTS HERE -->
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">                   		
                        <div class="row">
                            @include('layout.sidemenu')
                        </div>                                            
                    </div>
                    <!-- COL 3 ENDS HERE -->
                    <!--COL 9 STARTS HERE -->
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                    
                    <div class="row g-2 row-deck">
                <!-- SINGLE CLIENT STARTS HERE -->
                    <div class="col-xl-12">
                        
                        <div class="card">
                        
                        		
                            <div class="card-header">
                                <h6 class="card-title m-0">Clients</h6> <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-client">Add Clients</a>
                                
                            </div>
                            @if(\Session::get('Clientsuccess'))
                                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                    {{ \Session::get('Clientsuccess') }}
                                </div>
                                @endif
                                @if(\Session::has('Clienterror'))
                                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                        {{ \Session::get('Clienterror') }}
                                    </div>
                                @endif
                            <div class="card-body">
                                <table id="masterclients" class="table card-table table-hover align-middle mb-0" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">#</th>
                                            <th style="width:45%">Clients</th>
                                            <th style="width:40%">Clients (Arabic)</th>
                                            <th style="width:45%">Email</th>
                                            <th style="width:45%">Phone</th>
                                            <th class="text-center" style="width:10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         
@php
$i=1; 
@endphp

                                    @foreach ($clients as $names)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$names->name}}</td>
                                            <td>
                                            @php if($names->name_arabic) { $arabicname = $names->name_arabic;} else { $arabicname = '-NA-';} @endphp    
                                            {{$arabicname}}</td>
                                           <td>{{$names->email}}</td>
                                           <td>{{$names->phone_code}} -{{$names->phone}}</td>
                                            <td class="text-center">
                                            <a  onclick="editview('{{$names->id }}');" class="btn btn-link btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#edit-client-type{{ $names->id }}"> 
                                                    <i class="fa fa-edit" style="color:#555CB8;"></i>
                                            </a>
                                                    
                                            <?php if($names->status == '1') { ?>
                                                <a href="{{ 'block-clients/'.$names->id }}" onclick="return confirm('Do you want to block this Client?')" class="btn btn-link btn-sm text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Active" aria-label="Active">
                                                <i class="fa fa-ban" style="color:#198754;"></i>
                                             </a>

                                             <?php } else { ?>
                                                <a href="{{ 'unblock-clients/'.$names->id }}" onclick="return confirm('Do you want to unblock this Client?')" class="btn btn-link btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Blocked" aria-label="Blocked">
                                                <i class="fa fa-circle" style="color:#d63384;"></i>


                                             <?php } ?>
                                              
                                            </a>
                                                <a href="{{ 'update_test_prices/'.$names->id }}">
                                                  <i class="fa fa-tag" style="color:#d63384;"></i>  
                                                </a>
                                                <!-- <a href="" class="btn btn-link btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete" aria-label="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a> -->
                                            </td>
                                        </tr>
                                       
                                       
@php
$i=$i+1;
@endphp  
                                  @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>

                            <!-- Modal -->
    




                        </div>
                    </div>
                    <!-- SINGLE CLIENT LISTING ENDS HERE -->
  <!-- ADD CLIENT POPUP STARTS HERE -->
            <link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
   />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

                 <form class="row g-3" id="addclient" name="addclient" method="post" action="{{ route('master.client') }}">                              
                @csrf 
                        <div class="modal fade modelpopup" id="add-client" tabindex="-1" aria-hidden="true" style="overflow:hidden;" data-bs-backdrop="static">

                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Client</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body custom_scroll">
                                    <div class="row g-4">
                                    <div class="col-sm-6">
                                        <label class="form-label">Client Name <span class="red">*</span></label>                                        
                                        <input type="text" class="form-control form-control-lg" name="name" id="name" >  
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="clientnamealert" style="display:none ;">Please enter Client name</div>                                      
                                    </div>

                                    <div class="col-sm-6 text-end">
                                        <label class="form-label">Client Name (Arabic) <span class="red">*</span></label>                                        
                                        <input  dir="rtl" type="text" class="form-control form-control-lg" name="arabic_name" id="arabic_name" >  
                                    <div class="alert-danger pt-1 pb-1 px-1 py-1" id="clientnamealertar" style="display:none ;">Please enter Client Arabic name</div>                                      

                                    </div>
                                     
                                    
                                </div>
                                
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <label class="form-label">Email<span class="red">*</span></label>
                                        <input type="email" class="form-control form-control-lg" name="email" id="email">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="emailalert" style="display:none ;">Please enter a Valid email</div>
                                    </div>
                                     <div class="col-sm-6 text-end">
                                       <label class="form-label">Contact Number <span class="red"> *</span></label>                                      
                                        <input type="text" class="form-control form-control-lg" max="10" name="phone" id="phone" type="tel">
                                       <input type="hidden" class="form-control form-control-lg" max="10" name="country_code" id="country_code">
                                    <div class="alert-danger pt-1 pb-1 px-1 py-1" id="phonealert" style="display:none ;">Please enter contact number</div>
                                    </div>
                               
                                    </div>
                                    <div class="modal-footer">
                                        <a style="cursor:pointer;" class="btn btn-primary" onclick="formValidation();">Save</a>
                                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
<!-- ADD CLIENT ENDS HERE-->
</form>   





<!-- EDIT CLIENT POPUP STARTS HERE -->
        <form class="row g-3" id="editclient" name="editclient"  method="post" action="{{ route('client.edit') }}" >                             
                @csrf 
               
   
                    <div class="modal fade" id="edit-client-type" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Client</h5>
                                    <button type="button" id="edit-modal-close-x" class="btn-close"></button>
                                </div>

                                <div class="modal-body custom_scroll">
                                    <div class="row g-4">
                                        <div class="col-sm-6">
                                            <label class="form-label">Client Name <span class="red">*</span></label> 
                                            <input type="text" class="form-control form-control-lg" id="clientnameedit" name="clientnameedit" >
                                            <div class="alert-danger pt-1 pb-1 px-1 py-1" id="clientnameeditalert" style="display:none ;">Please enter Client name</div>
                                        </div>
                                        <div class="col-sm-6 text-end">
                                        <label class="form-label">Client Name (Arabic) <span class="red">*</span></label>                                        
                                        <input  dir="rtl" type="text" class="form-control form-control-lg" name="arabic_nameedit" id="arabic_nameedit" > 
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="clientnameeditalertar" style="display:none ;">Please enter Client name</div>

                                    </div>
                                    </div>
                                     <div class="row g-4">
                                    <div class="col-sm-6">
                                        <label class="form-label">Email<span class="red">*</span></label>
                                        <input type="email" class="form-control form-control-lg" name="email_edit" id="email_edit">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="emailalert" style="display:none ;">Please enter a Valid email</div>
                                    </div>
                                     <div class="col-sm-6 text-end">
                                       <label class="form-label">Contact Number <span class="red"> *</span></label>
                                        <div style="display: flex;">
                                             <label for="country_code_edit" style="flex: 1;">Country Code</label>
                                        <input type="text" class="form-control form-control-lg" max="10" name="country_code_edit" id="country_code_edit">
                                       <input type="number" class="form-control form-control-lg" max="10" name="phone_edit" id="phone_edit">
                                         </div>
                                   
                                    <div class="alert-danger pt-1 pb-1 px-1 py-1" id="phonealert" style="display:none ;">Please enter contact number</div>
                                    </div>
                                
                                    </div>
                                </div>
                            <div class="modal-footer">
                            <input type="hidden" class="form-control form-control-lg" id="hiddenid" name="hiddenid" >
                                        <a style="cursor:pointer;" class="btn btn-primary" onclick="formeditValidation();">Save</a>
                                        <button type="button" id="edit-modal-close" class="btn btn-secondary">Cancel</button>
                                        
                                        
                                        
                                

                                    
                            </div>
                        </div>
                    </div>
                </div>


            </form> 

            <!--  EDIT CATEGORY ENDS HERE-->                  
                    
                    
                </div>
                    
                    
                    
                    
                    </div>
                    <!--COL 9 ENDS HERE -->
                
                </div>      

                 <!-- .row end -->

            </div>
        </div>


        
    
   
    <script src="{!! asset('assets/plugin/jquery/3.3.1/jquery.min.js') !!}"></script>
    <script>
    const phoneInputField = document.querySelector("#phone");
    const countryInputField = document.querySelector("#country_code");
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        initialCountry: "auto",
        separateDialCode: true,
        geoIpLookup: function(callback) {
            fetch('https://ipapi.co/json')
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Failed to fetch user location.');
                    }
                })
                .then(function(data) {
                    callback(data.country);
                })
                .catch(function(error) {
                    console.error(error);
                    callback(''); // Set empty string as the default region if country lookup fails
                });
        },
        // Set a valid default region (e.g., "US" for United States)
    });

    phoneInputField.addEventListener("change", function() {
        
        const selectedCountry = phoneInput.getSelectedCountryData();
      
        countryInputField.value = selectedCountry.dialCode;
        //const dial = selectedCountry.dialCode;
         //console.log(selectedCountry);
         // alert(selectedCountry.dialCode);
         
    });
</script>
<script type="text/javascript">
    
    $('#edit-modal-close-x,#edit-modal-close').click(function(){
        $('#clientnamealertedit').hide();
        $('#edit-client-type').modal('hide');
    });
        // ADD CLIENT FORM VALIDATION STARTS HERE
    function formValidation()
    {
    document.getElementById('clientnamealert').style.display = 'none';
        document.getElementById('clientnamealertar').style.display = 'none';
        document.getElementById('emailalert').style.display = 'none';
        document.getElementById('phonealert').style.display = 'none';

     if(document.addclient.name.value == ''){
        document.getElementById('clientnamealert').style.display = 'block'; 
        document.addclient.name.focus();  
        return false;
     }
      if(document.addclient.arabic_name.value == ''){
        document.getElementById('clientnamealertar').style.display = 'block'; 
        document.addclient.arabic_name.focus();  
        return false;
     }
      if(document.addclient.email.value == ''){
        document.getElementById('emailalert').style.display = 'block'; 
        document.addclient.email.focus();  
        return false;
     }
      if(document.addclient.phone.value == ''){
        document.getElementById('phonealert').style.display = 'block'; 
        document.addclient.phone.focus();  
        return false;
     }
        
     document.addclient.submit();    
return true;

};



function editview(id){

var token = $('input[name="_token"]').val();



$.ajax({
url:"{{ route('client.view')}}",
type : 'POST',
data:{
    id:id,
    _token:token
},

success:function(response){
    console.log(response);
    $('#clientnameedit').val(response.name);
    $('#arabic_nameedit').val(response.name_arabic);
    $('#email_edit').val(response.email);
    $('#country_code_edit').val(response.phone_code);
    $('#phone_edit').val(response.phone);
    $('#hiddenid').val(response.id);
    $('#edit-client-type').modal('show');
    }
});
    
}
function formeditValidation()
{
    
    document.getElementById('clientnameeditalert').style.display = 'none';
        document.getElementById('clientnameeditalertar').style.display = 'none';

     if(document.editclient.clientnameedit.value == ''){
        document.getElementById('clientnameeditalert').style.display = 'block'; 
        document.editclient.clientnameedit.focus();  
        return false;
     }
      if(document.editclient.arabic_nameedit.value == ''){
        document.getElementById('clientnameeditalertar').style.display = 'block'; 
        document.editclient.arabic_nameedit.focus();  
        return false;
     }
     document.editclient.submit();    
return true;
};
 
    
</script>
<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#masterclients').DataTable({
        "order": [], // Disable initial sorting on page load
        "lengthMenu": [10, 25, 50, 75, 100], // Customize the number of records shown per page
        "language": {
            "paginate": {
                "previous": "<i class='fa fa-angle-left'></i>",
                "next": "<i class='fa fa-angle-right'></i>"
            }
        }
    });
});
</script>


@endsection
