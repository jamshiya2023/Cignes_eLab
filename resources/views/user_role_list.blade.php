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
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title m-0">User Roles</h6> <a href="{{ url('/user_role') }}" class="btn btn-primary">Add User Roles</a>
                                
                            </div>
                                @if(\Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                    {{ \Session::get('success') }}
                                </div>
                                @endif
                           <div class="card-body">
    <table id="userRole" class="table card-table table-hover align-middle mb-0" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>User Role</th>
                <th>User Role(Arabic)</th>
                <th class="text-center">Created Date</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
            $count = 1;
            @endphp
            @foreach($userroles as $key => $value)
            <?php
            $timestamp = strtotime($value->created_at);
            $date = date('M d, Y', $timestamp);
            ?>
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->name_arabic }}</td>
                <td class="text-center">{{ $date }}</td>
                <td class="text-center">
                    <a href="{{ 'edit-user_role/'.$value->id }}" class="btn btn-link btn-sm text-secondry" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit" aria-label="Edit">
                                                    <i class="fa fa-edit" style="color:#555CB8;"></i>
                                                </a>
                                                <a href="{{ 'permission-staff/'.$value->id }}" class="btn btn-link btn-sm text-danger"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                <?php if($value->status =='1') { ?> 
                                                <a href="{{ 'block-userrole/'.$value->id }}"  onclick="return confirm('Do you want to block this User role?')" class="btn btn-link btn-sm text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Active" aria-label="Active">
                                                    <i class="fa fa-ban" style="color:#198754;"></i>
                                                    
                                                </a>
                                                <?php } else { ?>
                                                    <a href="{{ 'unblock-userrole/'.$value->id }}" onclick="return confirm('Do you want to unblock this User role?')" class="btn btn-link btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="InActive" aria-label="InActive">
                                                    <i class="fa fa-circle" style="color:#d63384;"></i>
                                                </a>
                                                <?php } ?>    
                                                
                                                <!-- <a href="" class="btn btn-link btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete" aria-label="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a> -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


                            <!-- Modal -->
                            
                            
                        </div>
                    </div>
                </div> <!-- .row end -->






                    </div>
                    <!--COL 9 ENDS HERE -->



                
                

                </div>
            </div>
        </div>



      
    <script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
     <script src="{!! asset('assets/plugin/jquery/3.3.1/jquery.min.js') !!}"></script>
     <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
$(document).ready(function() {
  $('#userRole').DataTable();
});
</script>

@endsection
