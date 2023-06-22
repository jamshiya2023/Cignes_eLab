@extends('layout.maintemplate')
@section('content')

<style>
    .red {   
        color:#f00;  
    }
    .text-red{
       color:red;
    }
    .searchdate{ z-index:99999 !important; }
    .partially{
       color: #00ac9a;
    }     
         
        
    .card{
        position: relative;
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
    /*.bottom_section{
        margin-top:20px;
    }*/
    hr{
        height: 2px !important;
    }
</style>
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
    <div class="container-fluid">
        <div class="row g-2 row-deck">
          
            <div class="col-xl-12">
             
                <div class="card">
                    <div class="card-header col-md-12 d-inline-flex">
                        @foreach($invoicelist as $key => $list)
                        <div class="pb-0 col-md-6">
                            <h6 class="card-title m-0">Invoice #{{$list->invoice_number}}</h6>
                        </div>
                        @endforeach
                        <div class="col-md-6">
                            <button class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" id="printButton">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                  
                        @if(\Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            {{\Session::get('success')}}
                        </div>
                        @endif
                        
                        
                        <div class="print_body" style="width: 100%;">
                            <div class="row logo_section">
                                <div class="col-md-6 col-12">
                                    <img src="{!! asset('assets/images/logo3.png') !!}" alt="logo" style="width: 20%;">
                                   <!--src="{!! asset('assets/images/logo3.png') !!}">-->
                                  
                                </div>
                                <div class="col-md-6 col-12 text-end">
                                    <h3>Invoice</h3>
                                    <h5> فاتورة  </h5>
                                </div>
                            </div>
                           @foreach($invoicelist as $lis)
                            <div class="row patient_details" style="display:inline-flex; width:100%;">
                                <div class="col-md-6" style="width: 50%;float:left;padding-right:10px;font-size:13px;">
                                    <div class="row">
                                        <div class="col-md-6 green_text" style="width: 50%;float:left;"><b>INVOICE TO</b></div>
                                        <div class="col-md-6 text-end green_text" style="width: 50%;float:left;text-align: right;"><b> فاتورة إلى  </b></div>
                                        <br><br>
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>Patient Name</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">{{$lis->name}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b> اسم المريض  </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>ID No.</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">IDNO{{$lis->id}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b> رقم بطاقة الهوية  </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 30px;"><b>Mobile No.</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 30px;text-align: center;">{{$lis->mob}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 30px;text-align: right;"><b> رقم المحمول  </b></div>
                                        <br><br>
                                        
                                        <div class="col-md-6 green_text" style="width: 50%;float:left;"><b>RESERVATION INFO</b></div>
                                        <div class="col-md-6 text-end green_text" style="width: 50%;float:left;text-align: right;"><b> معلومات الحجز   </b></div>
                                        <br><br>
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>Reservation No.</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">RESRV{{$lis->id}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b>  رقم الحجز.  </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>User Name</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">{{$lis->username}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b>  اسم المستخدم   </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 30px;"><b>Collection Date & Time</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 30px;text-align: center;">{{$lis->created_at}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 30px;text-align: right;"><b>  تاريخ ووقت التحصيل  </b></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" style="width: 50%;float:left;padding-left:10px;font-size:13px;">
                                    <div class="row">
                                        <div class="col-md-6 green_text" style="width: 50%;float:left;"><b>INVOICE FROM</b></div>
                                        <div class="col-md-6 text-end green_text" style="width: 50%;float:left;text-align: right;"><b>  نموذج الفاتورة  </b></div>
                                        <br><br>
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>Branch Name</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">Cignes</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b>  اسم الفرع  </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>VAT No.</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">---</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b> ضريبة القيمة المضافة لا   </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>Phone No.</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">---</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 30px;text-align: right;"><b>  رقم الهاتف  </b></div>
                                        <br><br>
                                        
                                        <div class="col-md-6 green_text" style="width: 50%;float:left;"><b>PAYMENT INFO</b></div>
                                        <div class="col-md-6 text-end green_text" style="width: 50%;float:left;text-align: right;"><b>  معلومات الدفع   </b></div>
                                        <br><br>
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>Invoice No.</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">{{$lis->invoice_number}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b> رقم الفاتورة   </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>Payment Method</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">@if ($lis->paymentmethod == 0)
                                                Cash/Card 
                                            @else
                                                {{ $lis->pay_method }}
                                            @endif</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: right;"><b> طريقة الدفع او السداد   </b></div>
                                        
                                        <div class="col-md-4" style="width: 33.33333333%;float:left;margin-bottom: 10px;"><b>Date & Time</b></div>
                                        <div class="col-md-4 text-center" style="width: 33.33333333%;float:left;margin-bottom: 10px;text-align: center;">{{$lis->created_at}}</div>
                                        <div class="col-md-4 text-end" style="width: 33.33333333%;float:left;margin-bottom: 30px;text-align: right;"><b>  التاريخ والوقت    </b></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="row invoice_table" style="width: 100%; margin-top: 10px;">
                                <table id="" class="table card-table table-hover align-middle mb-0 test" style="width: 100%;border-color: #c1c1c1;">
                                    <thead>
                                        <tr>
                                            <th style="border-radius: 0.25rem 0 0 0.25rem;border-left: 0;border-top: 1px dashed #c1c1c1;vertical-align: middle;
                                                    white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 1px dashed #c1c1c1;">Service Name  <br>   اسم الخدمة</th>
                                            <th style="border-top: 1px dashed #c1c1c1;vertical-align: middle;
                                                    white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 1px dashed #c1c1c1;
                                                    border-left: 1px dashed #c1c1c1;">Unit Price   <br>   سعر الوحدة</th>
                                            <th style="border-radius: 0 0.25rem 0.25rem 0;border-top: 1px dashed #c1c1c1;vertical-align: middle;
                                                    white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 1px dashed #c1c1c1;
                                                    border-left: 1px dashed #c1c1c1;">Discount   <br>   تخفيض</th>
                                            <th style="border-top: 1px dashed #c1c1c1;vertical-align: middle;
                                                    white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 1px dashed #c1c1c1;
                                                    border-left: 1px dashed #c1c1c1;">VAT Amount   <br>   قيمة الضريبة</th>
                                            <th style="border-top: 1px dashed #c1c1c1;vertical-align: middle;
                                                    white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 1px dashed #c1c1c1;
                                                    border-left: 1px dashed #c1c1c1;">Subtotal (Including VAT)  <br>  المجموع الفرعي (شاملاً ضريبة القيمة المضافة)   </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php  
                                        $totalPrice = 0;
                                        @endphp
                                        
                                         @foreach($itemlist as $item)
                                        @php 
                                            $totalPrice += $item->price;
                                        @endphp
                                        <tr>
                                            <td style="border-bottom: 0;border-radius: 0.25rem 0 0 0.25rem;
                                                    border-left: 0;    
                                                    white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;"> {{$item->testname}}</td>
                                            <td style="border-bottom: 0;white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 0;
                                                    border-left: 1px dashed #c1c1c1;">SR {{$item->price}}</td>
                                            <td style="border-bottom: 0;white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 0;
                                                    border-left: 1px dashed #c1c1c1;">SR {{$item->discount}}</td>
                                            <td style="border-bottom: 0;white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 0;
                                                    border-left: 1px dashed #c1c1c1;">SR {{$item->taxamount}}</td>
                                            <td style="border-radius: 0 0.25rem 0.25rem 0;border-bottom: 0;white-space: nowrap;
                                                    padding-left: 1rem;
                                                    padding-right: 1rem;
                                                    border-right: 0;
                                                    border-bottom: 0;
                                                    border-left: 1px dashed #c1c1c1;">SR {{$item->total}}</td>
                                        </tr>
                                    @endforeach
                                       
                                    </tbody>
                                </table>
                            </div>
                              @foreach($invoicelist as $lis)
                            <div class="row tabel_bottom" style="display:inline-flex; width:100%;margin-top: 3rem;font-size:13px;">
                                <div class="col-md-3" style="width: 25%;float:left;padding-right:15px;">
                                    <div class="qr_code" style="text-align: right;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/800px-QR_code_for_mobile_English_Wikipedia.svg.png" style="width:40%;">
                                    </div>
                                </div>
                                <div class="col-md-9" style="width: 75%;float:left;padding-left:15px;">
                                    <div class="bottom_section">
                                        <div class="row" style="display: inline-flex; width:100%;margin-top:10px;">
                                            <div class="col-md-4" style="width: 33.33333333%;margin-top:"><b>Subtotal (Excluding VAT)</b></div>
                                            <div class="col-md-4 text-center" style="width: 33.33333333%;text-align:center;"><b>SR {{number_format($totalPrice,2) }}</b></div>
                                            <div class="col-md-4 text-end" style="width: 33.33333333%;text-align:right;"><b> المجموع الشامل (شاملاً ضريبة القيمة المضافة)  </b></div>
                                        </div>
                                        <br>
                                        <div class="row" style="display: inline-flex; width:100%;margin-top:10px;">
                                            <div class="col-md-4" style="width: 33.33333333%;"><b>Total VAT</b></div>
                                            <div class="col-md-4 text-center" style="width: 33.33333333%;text-align:center;"><b>SR {{ number_format($lis->totaltax,2)}}</b></div>
                                            <div class="col-md-4 text-end" style="width: 33.33333333%;text-align:right;"><b>  إجمالي ضريبة القيمة المضافة   </b></div>
                                        </div>
                                         <br>
                                         @php
                                            $sum = $totalPrice + $lis->totaltax;
                                            $sumFormatted = number_format($sum, 2);
                                         @endphp
                                          <div class="row" style="display: inline-flex; width:100%;margin-top:10px;">
                                            <div class="col-md-4" style="width: 33.33333333%;"><b>Total Amount </b></div>
                                            <div class="col-md-4 text-center" style="width: 33.33333333%;text-align:center;"><b>SR {{ $sumFormatted}} </b></div>
                                            <div class="col-md-4 text-end" style="width: 33.33333333%;text-align:right;"><b>     </b></div>
                                        </div>
                                         <br>
                                        <div class="row" style="display: inline-flex; width:100%;margin-top:10px;">
                                            <div class="col-md-4" style="width: 33.33333333%;"><b>Total Paid Amount</b></div>
                                            <div class="col-md-4 text-center" style="width: 33.33333333%;text-align:center;"><b>SR {{ number_format($lis->paidamt,2)}} </b></div>
                                            <div class="col-md-4 text-end" style="width: 33.33333333%;text-align:right;"><b>     </b></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row total_section" style="display:inline-flex; width:100%;margin-top: 3rem;">
                                <div class="col-md-3" style="width: 25%;float:left;"></div>
                                <div class="col-md-9" style="width: 75%;float:left;padding-left:15px;">
                                    <div class="bottom_section">
                                        <div class="row" style="display: inline-flex; width:100%;">
                                            <div class="col-md-4 green_text" style="width: 33.33333333%;"><b>Total Amount Due</b></div>
                                            <div class="col-md-4 text-center green_text" style="width: 33.33333333%;text-align:center;"><b>{{ number_format($lis->balanceamt,2)}} SAR</b></div>
                                            <div class="col-md-4 text-end green_text" style="width: 33.33333333%;text-align:right;"><b>  إجمالي المبلغ المستحق  </b></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <hr style="height: 2px !important;margin: 1rem 0;color: #464545;">
                            
                            <div class="row login_detail_section" style="display:inline-flex; width:100%;">
                                <h6 class="card-title" style="color: #181818;font-weight: 600;margin-bottom: 0.5rem;font-size: 1rem;margin-top:0;">Login Details</h6>
                            </div>
                            
                            <div class="row" style="display:inline-flex; width:100%;">
                                <div class="col-md-3" style="width: 25%;float:left;">
                                    <span>Username: <b>{{$list->username}}</b></span>
                                </div>
                                <div class="col-md-3" style="width: 25%;float:left;">
                                    <?php 
                                            $passname = strtolower(substr($list->name, 0, 4));  // First 4 characters of name        
                                            $passmob = strtolower(substr($list->mob, -4));  // Last 4 digits of phone
                                            $customerpass = $passname.$passmob; // Password
                                       ?>  
                                    <span>Password: <b>{{$customerpass}}</b></span>
                                </div>
                            </div>
                        </div>
                   
                    </div>
   
                </div>
            </div>
        </div>
        <!-- .row end -->
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


<script type="text/javascript">
    $(document).ready(function () {
        $('#printButton').click(function () {
            var printWindow = window.open('', '_blank');

            let htmlContent = $('.print_body').html();
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
                            margin-top: 20px;
                        }
                        .invoice_table th, .invoice_table td{
                            text-align: center;
                        }
                        .qr_code img{
                            width:40%;
                        }
                        .print_body .table.card-table tr td, .print_body .table.card-table tr th {
                            vertical-align: middle;
                            white-space: nowrap;
                            padding-left: 1rem;
                            padding-right: 1rem;
                            border-right: 0;
                            border-bottom: 1px dashed var(--border-color);
                            border-left: 1px dashed var(--border-color);
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



<!--<script type="text/javascript">
  $(document).ready(function () {
    $('#printButton').click(function () {
        var printWindow = window.open('', '_blank');

      let htmlContent = $('.print_body').html();
        printWindow.document.open();
        printWindow.document.write(htmlContent);
        printWindow.document.close();

// Trigger the print dialog for the new window or iframe
        printWindow.print();
     // printJS({ printable: htmlContent, type: 'html', documentTitle: 'Invoice' });
    });
  });
</script>-->



@endsection