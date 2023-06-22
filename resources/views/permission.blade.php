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
    .table.card-table tr td, .table.card-table tr th {
        vertical-align: middle;
        white-space: normal;
        padding-left: 1rem;
        padding-right: 1rem;
        border-right: 0;
        border-bottom: 1px dashed var(--border-color);
        border-left: 1px dashed var(--border-color);
    }
    </style>

<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
    <div class="container-fluid">
        <div class="row">
              <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">                   		
                        <div class="row">
                            @include('layout.sidemenu')
                        </div>                                            
                    </div>
                    
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">

                    <div class="row g-2 row-deck">
                    <div class="col-xl-12">
                            <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Add New Staff</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-4">
                                <!-- FORM STARTS HERE -->
                                <form class="row g-3" id="addstaff" name="addstaff" method="post" enctype="multipart/form-data" action="{{ route('staff.add') }}">                            
                                    @csrf
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6 class="card-title mb-0">Menu Permissions <span class="red">*</span>( Select All <input type="checkbox" id="select-all" class="form-check-input mt-0" name="selectall"> )</h6>
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="permissionalert" style="display:none ;">Please assign permission to atleast one menu</div>
                                        <table id="documentlist" class="table card-table table-hover align-middle mb-1 mt-5" style="width: 100%;" >
                                            <thead>
                                                <tr>
                                                    <th>Menu</th>
                                                    <th class="text-center">View</th>
                                                    <th class="text-center">Add</th>
                                                    <th class="text-center">Edit</th>
                                                    <th class="text-center">Block</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>                 
                                                @php 
                                                $i = 0; 
                                                $j = 0;
                                                @endphp
                                                @foreach ($menulist as $menu)
                                                <tr>
                                                    @if($menu->id == '1')
                                                    <td>
                                                        {{$menu->menu_name}}
                                                        <input type="hidden" name="menuid[]" value="{{$menu->id}}"> 
                                                        <input type="hidden" name="parentid[]" value="{{$menu->id}}">                           
                                                    </td>
                                                    @php
                                                    $j = $j+1;
                                                    @endphp
                                                    <td class="text-center">
                                                        <input type="hidden" name="menuview[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menuview[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menuadd[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menuadd[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menuedit[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menuedit[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menublock[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menublock[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menudelete[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menudelete[{{$i}}]" value="1">
                                                    </td>
                                                    @else
                                                    <td colspan="6"><strong>{{$menu->menu_name}}</strong></td>        
                                                    @endif
                                                </tr>
                                                
                                                @foreach($menu->childs as $child) 
                                                @php  $i = $i+1; @endphp
                                                <tr>
                                                    <td>    
                                                        {{ $child->menu_name }}  <input type="hidden" name="menuid[]" value="{{$child->id}}">
                                                        <input type="hidden" name="parentid[]" value="{{$menu->id}}">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menuview[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menuview[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menuadd[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menuadd[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menuedit[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menuedit[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menublock[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menublock[{{$i}}]" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="menudelete[{{$i}}]" value="0">
                                                        <input type="checkbox" class="form-check-input menucheckbox" name="menudelete[{{$i}}]" value="1">
                                                    </td>
                                                </tr>
                                                @endforeach
                                          
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer mt-5" >
                                        <a style="cursor:pointer;" class="btn btn-primary" onclick="formValidation();">Save</a>
                                        <a style="cursor:pointer;" class="btn btn-default">Cancel</a>
                                    </div>
                                </form>
                                <!-- FORM ENDS HERE -->
                            </div> <!-- .row end -->
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}
</script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script src="{!! asset('assets/plugin/jquery/3.3.1/jquery.min.js') !!}"></script>
<script type="text/javascript">
/*$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
*/
var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
$(document).ready(function () {
$('#department').on('change',function(e) {
    
var department_id = e.target.value;
//alert(department_id+' token -> '+token); exit();
$.ajax({
url:"{{ 'designation' }}",
type:"POST",
data: {
    department_id: department_id,
    _token:token

},
beforeSend: function() {
            $('#designation').append('<option value="">- Loading -</option>');
},
success:function (data) {
    //alert(data); exit();
    $('#designation').empty();
    $('#designation').append('<option value="">- Please Select -</option>');
    $.each(data,function(key, value){
    $('#designation').append('<option value="'+value.id+'">'+value.designation_name+'</option>');
})
}
})
});
});

// DOCUMENT ADDING STARTS HERE
    function documentsValidation() 
    {
    document.getElementById('documenttypealert').style.display = 'none'; 
    document.getElementById('documentnumberalert').style.display = 'none';
    document.getElementById('docexpirydatealert').style.display = 'none';

    if(document.addstaff.documenttype.value == ''){
        document.getElementById('documenttypealert').style.display = 'block'; 
        document.addstaff.documenttype.focus();  
        return false;     
    } else if(document.addstaff.documentnumber.value == ''){
        document.getElementById('documentnumberalert').style.display = 'block'; 
        document.addstaff.documentnumber.focus();  
        return false;     
    } else if(document.addstaff.docexpirydate.value == ''){
        document.getElementById('docexpirydatealert').style.display = 'block'; 
        document.addstaff.docexpirydate.focus();  
        return false;     
    } else if(document.getElementById('docattachement').files.length == 0 ){
                document.getElementById('docattachementalert').style.display = 'block';
                document.getElementById('docattachementalert').innerHTML = 'Select image';
                return false;
    } else {
                var fileInput = document.getElementById('docattachement');
                var filePath = fileInput.value;
                // Allowing file type
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        //alert('Invalid file type');
                        //fileInput.value = '';
                        document.getElementById('docattachementalert').style.display = 'block';
                        document.getElementById('docattachementalert').innerHTML = 'Upload only image';
                        return false;
                    } 
    }

    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    var files = $('#docattachement')[0].files;
    var dtype = $('#documenttype').val();
    var dnumber= $('#documentnumber').val();
    var dexpirydate= $('#docexpirydate').val();
    var tempcustid= $('#tempcustid').val();


    var fd = new FormData();
    
         // Append data 
         fd.append('file',files[0]);
         fd.append('_token',CSRF_TOKEN);
         fd.append('dtype',dtype);
         fd.append('dnumber',dnumber);
         fd.append('dexpirydate',dexpirydate);
         fd.append('token',tempcustid);
    // var filename  = files[0];
         $.ajax({
            url:"{{ 'documentadd' }}",
           method: 'POST',
           data: fd,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
               //alert(response.success);
            if(response.success == 1){ // Uploaded successfully
                //alert(response.documenttype);
                $("#docattachement").val('');
                $("#documenttype").val('');
                $("#documentnumber").val('');
                $("#docexpirydate").val('');

                var tableRef = document.getElementById('tabledocumentlist').getElementsByTagName('tbody')[0];
                var nums = tableRef.rows.length;
                var counts = nums+1;
               
                //var nums = ((tableRef.rows.length)+1);
                var myHtmlContent='<tr><td>'+counts+'</td><td>'+response.documenttype+'</td><td>'+response.documentnumber+'</td><td>'+response.documentexpirydate+'</td><td class="text-center"><div class="btn btn-link btn-sm text-success tooltips"><i class="fa fa-eye"></i><span class="tooltiptext"><img src="{{ url("uploads") }}/'+response.documentfile+'" width="120" height="auto"></span></div></td><td class="text-center"><span class="btn btn-link btn-sm text-danger delete" onclick="return deletedoc(0,'+response.documentid+',this);"><i class="fa fa-trash"></i></span></td></tr>';
                
                var newRow = tableRef.insertRow(tableRef.rows.length);

                if(document.getElementById('tabledocumentlist').style.display == 'none'){
                document.getElementById('tabledocumentlist').style.display = 'block';
                    newRow.innerHTML = myHtmlContent;
                } else {
                    newRow.innerHTML = myHtmlContent;
                }
            }

           }, error: function(response){
              console.log("error : " + JSON.stringify(response) );
           }

        });

    
}
// DOCUMENTS ADDING ENDS HERE


// Delete 
function deletedoc(stid,deleteid,trid){
  var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");  
  var confirmalert = confirm("Are you sure to delete?");
  if (confirmalert == true) {
     // AJAX Request
     $.ajax({
        url:"{{ 'documentdelete' }}",
       type: 'POST',
       data: { 
           id:deleteid,
           sid:stid,
           _token:token
         },
       success: function(response){
           
        if(response.success == 1){      
            // HIDE TABLE IF NOT RECORDS FOUND STARTS HERE
            if(response.doccount == 0 ){
                document.getElementById('tabledocumentlist').style.display = 'none';
            }        
            // HIDE TABLE IF NOT RECORDS FOUND ENDS HERE
            // REMOVE CORRESPONDING COLUMN AFTER DELETE
                $tr= $(trid).closest("tr");
                $tr.find('td').fadeOut(700, function () {
                $tr.remove();    
            });

        }else{
        alert('Invalid ID.');
        }

       }
     });
  }

}
</script>


<script>
function formValidation() 
{
    var selected_data = 0;
    var chks = document.getElementsByClassName("menucheckbox");
        
    var emails = document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    
    for (var i = 0; i < chks.length; i++) {
            if (chks[i].checked) {
                selected_data++;
            }
        }
    

    document.getElementById('firstnamealert').style.display = 'none';
    document.getElementById('lastnamealert').style.display = 'none';
    document.getElementById('departmentalert').style.display = 'none';
    document.getElementById('designationalert').style.display = 'none';
    document.getElementById('genderalert').style.display = 'none'; 
    document.getElementById('dobalert').style.display = 'none'; 
    document.getElementById('emailalert').style.display = 'none';
    document.getElementById('phonealert').style.display = 'none'; 
    document.getElementById('profilepicalert').style.display = 'none'; 
    document.getElementById('signaturealert').style.display = 'none';
    document.getElementById('permissionalert').style.display = 'none'; 
    
    
    if(document.addstaff.firstname.value == ''){
        document.getElementById('firstnamealert').style.display = 'block'; 
        document.addstaff.firstname.focus();  
        return false;     
    }else if(document.addstaff.lastname.value == ''){
        document.getElementById('lastnamealert').style.display = 'block'; 
        document.addstaff.lastname.focus();  
        return false;     
    }else if(document.addstaff.department.value == ''){
        document.getElementById('departmentalert').style.display = 'block'; 
        document.addstaff.department.focus();  
        return false;     
    }else if(document.addstaff.designation.value == ''){
        document.getElementById('designationalert').style.display = 'block'; 
        document.addstaff.designation.focus();  
        return false;     
    }else if(document.addstaff.gender.value == ''){
        document.getElementById('genderalert').style.display = 'block'; 
        document.addstaff.gender.focus();  
        return false;     
    }else if(document.addstaff.dateofbirth.value == ''){
        document.getElementById('dobalert').style.display = 'block'; 
        document.addstaff.dateofbirth.focus();  
        return false;     
    }else if(document.addstaff.email.value == ''){
        document.getElementById('emailalert').style.display = 'block'; 
        document.addstaff.email.focus();  
        return false;     
    }else if (!filter.test(emails.value)) {
            //document.addstaff.email.value=''
            document.getElementById('emailalert').style.display = 'block'; 
            document.getElementById("emailalert").innerHTML="Invalid email address! Please re-enter";
            document.addstaff.email.select();
            document.addstaff.email.focus();
            return false;
    }else if(document.addstaff.contactnumber.value == ''){
        document.getElementById('phonealert').style.display = 'block'; 
        document.addstaff.contactnumber.focus();  
        return false;     
    } else if(IsNumeric(document.addstaff.contactnumber.value)==false){
        document.getElementById('phonealert').style.display = 'block'; 
        document.getElementById("phonealert").innerHTML="Invalid contact number! Please re-enter";
        document.addstaff.contactnumber.select();
        document.addstaff.contactnumber.focus(); 
        return false;
    } else if (selected_data == 0) {
            //alert("Please select CheckBoxe(s).");
            document.addstaff.selectall.focus();
            //document.getElementById("documentlist").focus();
            
            document.getElementById('permissionalert').style.display = 'block';             
            return false;
    } 

    //alert(chks.length); 
    //exit();



document.addstaff.submit();
return true;
}

// PROFILE PICTURE VALIDATION STARTS HERE
function profilepicValidation() {
    var fileInput = document.getElementById('profilepic');
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (!allowedExtensions.exec(filePath)) {
                document.getElementById('profilepicalert').style.display = 'block'; 
                return false;
            } else {
                document.getElementById('profilepicalert').style.display = 'none'; 
            }
}
// PROFILE PICTURE VALIDATION ENDS HERE

// SIGNATURE VALIDATIONS STARTS HERE 
function signatureValidation() {
    var fileInput = document.getElementById('signature');
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (!allowedExtensions.exec(filePath)) {
               //alert('Invalid file type');
                //fileInput.value = '';
                document.getElementById('signaturealert').style.display = 'block'; 
                return false;
            } else {
                document.getElementById('signaturealert').style.display = 'none'; 
            }
}
//SIGNATURE VALIDATION ENDS HERE
// Documents details adding scripts starts here 




// DOCUMENT ATTACHMENT FILE STARTS HERE 
function documentAttachValidation() {
    var fileInput = document.getElementById('docattachement');
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (!allowedExtensions.exec(filePath)) {
               //alert('Invalid file type');
                //fileInput.value = '';
                document.getElementById('docattachementalert').style.display = 'block'; 
                return false;
            } else {
                document.getElementById('docattachementalert').style.display = 'none'; 
            }
}
// DOCUMENT ATTACHMENT FILE ENDS HERE 




// NUMBER VALIDATION 

function IsNumeric(strString)
{
   var strValidChars = "0123456789-+(). ";
   var strChar;
   var blnResult = true;
   if (strString.length == 0) return false;
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         	{
        	 blnResult = false;
         	}
      }
   return blnResult;
}
</script>

<script type='text/javascript' src="{!! asset('assets/bundles/jquery.inputmask.bundle.js') !!}"></script>
<script>
var $j = jQuery.noConflict();
$j(document).ready(function(){
        $j('#dateofbirth').inputmask('99/99/9999',{placeholder:"dd/mm/yyyy"});
        $j('#docexpirydate').inputmask('99/99/9999',{placeholder:"dd/mm/yyyy"});
});
</script>
<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
@endsection