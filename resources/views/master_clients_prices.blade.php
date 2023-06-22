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
    <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">-->

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
                            <div class="col-xl-12">
                                <div class="card">
                                    <form id="updateForm">
                                    <div class="card-header">
                                        <h6 class="card-title m-0">Update Test Price</h6>
                                        <h5> <button type="submit" id="updateAllButton" class="btn btn-primary">UniPricing</button></h5>
                                    </div>
                                    <div class="card-body">

                                        <table id="updatetestprice" class="table card-table table-hover align-middle mb-1 mt-0">
                                            <thead>

                                                <tr>
                                                    <th style="width:10px;">#</th>
                                                   <th style="width:200px;" class="text-center">Test Name</th>
                                                   <th style="width:50px;" class="text-center">Original Price</th>
                                                   <th style="width:50px;" class="text-center">Client Price</th>
                                                   <th style="width:50px;" class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count=1; @endphp

                                                @foreach($tests as $data)

                                                <tr>
                                                    <td>{{$count++}}</td>
                                                    <td>
                                                        <input type="hidden" class="form-control form-control-lg" value="{{$data->id}}" name="testid" id="testid">
                                                        <input type="hidden" class="form-control form-control-lg" value="{{$client->id}}" name="clientid" id="clientid">
                                                        <input type="text" class="form-control form-control-lg" value="{{$data->testname}}" name="testname_{{$data->id}}" id="testname_{{$data->id}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-lg" value="{{$data->primaryprice}}" name="originalPrice_{{$data->id}}" id="originalPrice_{{$data->id}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-lg" value="{{$data->price}}" name="clientPrice_{{$data->id}}" id="clientPrice_{{$data->id}}" onchange="updateValue(this)">
                                                        <input type="hidden" class="form-control form-control-lg" value="{{$data->price_id}}" name="clientPriceId_{{$data->id}}" id="clientPriceId_{{$data->id}}">
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <a onclick="UpdateClientPrice({{$data->id}},{{$client->id}});" class="btn-sm btn-info" style="color:#fff; font-weight:600; cursor:pointer;">Update</a>
                                                    </td>
                                                </tr>
                                                 @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="{!! asset('assets/plugin/jquery/3.3.1/jquery.min.js') !!}"></script>
    <script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#updatetestprice').DataTable({
                "order": [[0, "asc"]] // Sort by the first column (ID) in descending order
            });
        });
    </script>


<script>
$(document).ready(function() {
    // Global variable to store the collected data
    var data = [];

    // Function to collect data from a table page
    function collectDataFromPage(pageUrl) {
        $.ajax({
            url: pageUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                var pageHtml = $(response);
                var pageRows = pageHtml.find('tbody tr');

                pageRows.each(function(index) {
                var row = $(this);
                var id = row.find('input[name^="testid"]').val();
                var cid = row.find('input[name^="clientid"]').val();
                var testname = row.find('input[name^="testname"]').val();
                var originalPrice = row.find('input[name^="originalPrice"]').val();
                var clientPrice = row.find('input[name^="clientPrice"]').val();
                var clientPriceId = row.find('input[name^="clientPriceId"]').val();

                    data.push({
                        id: id,
                        cid:cid,
                        testname: testname,
                        originalPrice: originalPrice,
                        clientPrice: clientPrice,
                        clientPriceId: clientPriceId
                    });

                });
 console.log(data);
                // Check if there are more pages to collect data from
                var nextPageLink = pageHtml.find('.pagination li.active').next().find('a');
                if (nextPageLink.length > 0) {
                    var nextPageUrl = nextPageLink.attr('href');
                    collectDataFromPage(nextPageUrl); // Recursively collect data from the next page
                } else {
                    // If all pages have been processed, send the data to the server using AJAX
                    sendDataToServer();
                }
            },
            error: function(xhr, status, error) {
                console.error(error); // Handle the error case
            }
        });
    }

    // Function to send the collected data to the server
    function sendDataToServer() {
        $.ajax({
             url:"{{ route('update-prices_all.submit') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { data: data },
            success: function(response) {
                console.log(response); // Handle the server response as needed
                 if(response.status === true)
               {
                    var id = response.id;
                    localStorage.setItem("hideUpdateButton", "true");
                    // Refresh the page with the specific ID

                    window.location.href = "{{ url('update_test_prices') }}/" + id;

                }
                else
                {
                    swal(""+response.message+"");
                }
            },
            error: function(xhr, status, error) {
                console.error(error); // Handle the error case
            }
        });
    }


    // Handle form submission
    $('#updateForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Reset the data array before collecting new data
        data = [];

        // Collect data from the first page
        var firstPageUrl = $('.pagination li:first-child a').attr('href');
        collectDataFromPage(firstPageUrl);
    });
});
</script>
<script>
    function updateValue(input) {
      var newValue = input.value; // Get the new value entered by the user
      // Perform any additional logic or processing if needed
      console.log("New value:", newValue);
      // Update the input field value (optional)
      input.value = newValue;
    }
  </script>
    <script>

    function UpdateClientPrice(sid,cid)
{
  var sid                   = sid;
  var cid                   = cid;
  var CSRF_TOKEN            = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
  var test_name             = document.getElementById("testname_"+sid).value;
  var original_price        = document.getElementById("originalPrice_"+sid).value;
  var client_price          = document.getElementById("clientPrice_"+sid).value;
  var client_price_id       = document.getElementById("clientPriceId_"+sid).value;


       var updatePrice = new FormData();
        updatePrice.append('_token',CSRF_TOKEN);
        updatePrice.append('test_name',test_name);
        updatePrice.append('original_price',original_price);
        updatePrice.append('client_price',client_price);
        updatePrice.append('cid',cid);
        updatePrice.append('sid',sid);
        updatePrice.append('client_price_id',client_price_id);

         $.ajax({
           url:"{{ route('update-prices.submit') }}",
           method: 'POST',
           data: updatePrice,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
               console.log(response);
               if(response.status === true)
               {
               var id = response.id;

        // Refresh the page with the specific ID
        window.location.href = "{{ url('update_test_prices') }}/" + id;
           }
           else
           {
               swal(""+response.message+"");
           }
           }


           });
}

</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    </script>
@endsection
