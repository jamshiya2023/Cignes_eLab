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
    .red {
    color: #FF0000;
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
    </style>
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
    <div class="container-fluid" style="min-height:450px;" >
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

            <div class="row g-4" >
                                           
                    <form class="row g-3" id="editUserrole" name="editUserrole" method="post" action="{{ url('edit-user_role/'.$userrole->id) }}"> 
                         @csrf
                        <div class="col-lg-12 col-md-12 col-sm-12" >
                            <div class="card" >
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Update User Role</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">

                                    <div class="col-sm-6">
                                        <label class="form-label">User Role <span class='red'>*</span></label>
                                        <input type="text" class="form-control form-control-lg" placeholder="Enter here" name="userrole" id="userrole" value="{{$userrole->name}}">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="departmentalert" style="display:none ;">Please enter User Role</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">User Role (Arabic) <span class='red'>*</span></label>
                                        <input type="text" class="form-control form-control-lg" placeholder="Enter here" name="userrolear" id="userrolear" value="{{$userrole->name_arabic}}">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="departmentalertar" style="display:none ;">Please enter User Role(Arabic)</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" class="form-control" placeholder="A brief description of the user role">{{$userrole->description}}</textarea>
                                               
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="description">Description (Arabic)</label>
                                        <textarea id="description_ar" name="description_ar" class="form-control" placeholder="A brief Arabic description of the user role">{{$userrole->description_ar}}</textarea>
                                    </div>
                                        
                                    </div>                                
                                </div>
                                <div class="card-footer">
                                    <a style="cursor:pointer;" class="btn btn-primary" onclick="formValidation();">Save</a>
                                     <a style="cursor:pointer;" class="btn btn-secondary" onclick="cancelForm();">Cancel</a>
                                    <!--<input type="reset" value="Cancel" class="btn btn-default">-->
                                    <!--<a style="cursor:pointer;" class="btn btn-default">Cancel</a>-->
                                </div>
                            </div>
                        </div>

                    </form>
                    
                </div> <!-- .row end -->


            </div>
            <!-- COL 9 ENDS HERE -->

        </div>
    </div>
</div>




<script>


  function formValidation() 
{
    document.getElementById('departmentalert').style.display = 'none'; 
    document.getElementById('departmentalertar').style.display = 'none'; 
    if(document.editUserrole.userrole.value == ''){
        document.getElementById('departmentalert').style.display = 'block';  
        document.editUserrole.userrole.focus(); 
        return false;     
    }
    else if(document.editUserrole.userrolear.value == ''){
        document.getElementById('departmentalertar').style.display = 'block'; 
        document.editUserrole.userrolear.focus(); 
        return false;      
    }

document.editUserrole.submit();
return true;
}

</script>
<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
<script>
function cancelForm() {
    // Perform any necessary cancellation logic here
    // For example, you can redirect to another page or clear the form fields

    // Clear the form fields
    document.getElementById("editUserrole").reset();

    // Redirect to the departments page
    // window.location.href = "{{ url('departments/') }}";
}


</script>
@endsection
