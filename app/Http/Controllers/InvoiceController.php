<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Invoicedetails;  
use App\Models\PaymentMethod;
use App\Models\Transactions;


use App\Models\Staff;  
use App\Models\Logactivity;
use App\Models\Customer;

use App\Models\Registration;


class InvoiceController extends Controller
{
    
    
      public function invoicepay_view(Request $request){
        
           $registerid = $request->input('id');
		  
		  $testlists = Transactions::join('invoice','invoice.id','=','transactions.invoice_id')
            ->join('staff','staff.id','=','transactions.staff_id')
            ->join('registration','registration.id','=','invoice.reg_id')
            ->join('customer','customer.id','=','registration.cust_id')
            ->join('master_payment_method','transactions.paymentmethod','=','master_payment_method.id')
            ->select('transactions.id as id','transactions.paidamount as paidamt','transactions.paymenttime as paytime','transactions.balanceamount as balanceamount','transactions.voucher_number as vouchernumber','invoice.invoice_number as invoiceno','invoice.totalamt as totalamt','staff.firstname','staff.lastname','invoice.reg_id','customer.name as customername','master_payment_method.paymentmethod as paymentmethod', Transactions::raw("CONCAT(transactions.paymentdate, ' ', transactions.paymenttime) AS date"))
            ->where('invoice.reg_id',$registerid)
            ->orderBy('transactions.id','desc')
            ->get();  
            $datas['testlists'] = $testlists;
             //dd($testlists);
             foreach ($testlists as $invoice)
             {
			    $invoice_number = $invoice->invoice_number; 
			    $paidamt = $invoice->paidamt;
             }
              $datas['invoice_number'] = $invoice_number; 
			  $datas['paidamt'] = $paidamt; 
             return response()->json($datas);
          
		  
	/*	$testlists = Invoice::join('registration','invoice.reg_id','=','registration.id')
	            ->join('invoice','invoice.id','=','transactions.invoice_id')
                ->join('customer','registration.cust_id','=','customer.id')
			    ->join('invoicedetails','invoice.id','=','invoicedetails.invoice_id')
			    ->join('alltests','invoicedetails.test_name','=','alltests.id')
			    ->join('master_payment_method','invoice.paymentmethod','=','master_payment_method.id')
			   
			    ->where('invoice.reg_id',$registerid)
                ->select('invoice.*','customer.name as name','registration.registerdate as date','registration.registertime as time','alltests.testname as testname','alltests.primaryprice as primaryprice','invoicedetails.test_unitprice as test_unitprice','invoicedetails.test_discount as test_discount','invoicedetails.test_tax_amount as test_tax_amount','invoicedetails.test_subtotal as test_subtotal','invoicedetails.test_name as test_name','invoicedetails.id as ind_id','master_payment_method.paymentmethod as paymentmethod')
                ->orderBy('invoice.id','desc')
            ->get();
			$unitprice = array();
			 foreach ($testlists as $invoice){
			    $invoice_number = $invoice->invoice_number; 
			    $paidamt = $invoice->paidamt;
			    $paymentstatus = $invoice->paymentstatus;
			    $date = $invoice->date;
			    $unitprice[] = $invoice->test_unitprice;
			    $tax_amount[] = $invoice->test_tax_amount;
			    $subtotal[] = $invoice->test_subtotal;
			 }
			  $test_unitprice = array_sum($unitprice);  
														 
			     $test_tax_amount = array_sum($tax_amount); 
			     $test_subtotal = array_sum($subtotal); 
			     
         $datas['testlists'] = $testlists; 
          $datas['test_unitprice'] = $test_unitprice; 
		   $datas['test_tax_amount'] = $test_tax_amount; 
		    $datas['test_subtotal'] = $test_subtotal; 
		     $datas['invoice_number'] = $invoice_number; 
			  $datas['paidamt'] = $paidamt; 
		       $datas['date'] = $date;
		        $datas['paymentstatus'] = $paymentstatus;
		  
        return response()->json($datas); */
        
    }
    
     public function invoice_refundview(Request $request){
        $registerid = $request->input('id');
		  
		$testlists = Invoice::join('registration','invoice.reg_id','=','registration.id')
            ->join('customer','registration.cust_id','=','customer.id')
			  ->join('invoicedetails','invoice.id','=','invoicedetails.invoice_id')
			   ->join('alltests','invoicedetails.test_name','=','alltests.id')
			    ->where('invoice.reg_id',$registerid)
                ->select('invoice.*','customer.name as name','registration.registerdate as date','registration.registertime as time','alltests.testname as testname','alltests.primaryprice as primaryprice','invoicedetails.test_unitprice as test_unitprice','invoicedetails.test_discount as test_discount','invoicedetails.test_tax_amount as test_tax_amount','invoicedetails.test_subtotal as test_subtotal','invoicedetails.test_name as test_name','invoicedetails.id as ind_id')
                ->orderBy('invoice.id','desc')
            ->get();
			$unitprice = array();
			 foreach ($testlists as $invoice){
			 $invoice_number = $invoice->invoice_number;
			$paymentstatus = $invoice->paymentstatus;
			$date = $invoice->date;
			 
			  $unitprice[] = $invoice->test_unitprice;
			  $tax_amount[] = $invoice->test_tax_amount;
			  $subtotal[] = $invoice->test_subtotal;
			 }
			  $test_unitprice = array_sum($unitprice); 
			     $test_tax_amount = array_sum($tax_amount); 
				        $test_subtotal = array_sum($subtotal); 
         $datas['testlists'] = $testlists; 
          $datas['test_unitprice'] = $test_unitprice; 
		   $datas['test_tax_amount'] = $test_tax_amount; 
		    $datas['test_subtotal'] = $test_subtotal; 
		     $datas['invoice_number'] = $invoice_number; 
		      $datas['date'] = $date;
		       $datas['paymentstatus'] = $paymentstatus;
		  
        return response()->json($datas);  
    }
    
     
    public function invoicelistview()
    {
        if(Auth::check()){ 
            $userId = Auth::id();
            $invoicelist = Invoice::join('registration','invoice.reg_id','=','registration.id')
            ->join('customer','registration.cust_id','=','customer.id')
            ->select('invoice.*','customer.name as name','registration.registerdate as date','registration.registertime as time','registration.register_number as regnumber')
            ->orderBy('invoice.id','desc')
            ->get();
            
             $paymentmethod = PaymentMethod::where("status", "=", 1)->get();
            return view('invoicelist', ['paymentmethods' => $paymentmethod, 'invoicelist' => $invoicelist, 'frmdate'=>'', 'todate'=>'', 'customer'=>'', 'invoiceno'=>'', 'status'=>'']);
        }
        return redirect("/")->withError('You do not have access');
    }

    public function viewinvoicelist(Request $request)
    {         
       $id = $request->id;
       $customerdetails = Invoice::join('registration','invoice.reg_id','=','registration.id')
                ->join('customer','registration.cust_id','=','customer.id')
                ->join('country','registration.country','=','country.id')
                ->select('registration.id as reg_id','invoice.*','customer.username','customer.name as name','customer.phone as phone','customer.place as place','customer.email as email','registration.registerdate as date','registration.registertime as time','registration.add_line_one as addone','registration.add_line_two as addtwo','registration.city as city','registration.pincode as pincode','country.country_name as country')
                ->where('invoice.id',$id)
                ->get();
        $invoicedetails = Invoicedetails::join('alltests','alltests.id','=','invoicedetails.test_name')
                ->where('invoice_id',$id)
                ->select('alltests.testname as testname','invoicedetails.test_unitprice as unitprice','invoicedetails.test_discount as discount','invoicedetails.test_tax_amount as tax','invoicedetails.test_subtotal as subtotal')
                ->get();
        $reg_id = Invoice::join('registration','invoice.reg_id','=','registration.id')->where('invoice.id',$id)->select('*') ->first();
        
         $cust_details = Customer::join('registration','customer.id','=','registration.cust_id')->where('registration.id',$reg_id->reg_id)->select('name','phone') ->first();
        
       
        
        $passname = strtolower(substr($cust_details->name, 0, 4));  // First 4 characters of name        
                $passmob = strtolower(substr($cust_details->phone, -4));  // Last 4 digits of phone
                $customerpass = $passname.$passmob;
            
            $paymentMethodIsNotZero = "True";
            $registrationlastid =$reg_id->reg_id;
            
            $paymentMethodIs = Invoice::join('registration', 'invoice.reg_id', '=', 'registration.id')
                ->where('registration.id', '=', $registrationlastid)
                ->select('invoice.paymentmethod')
                ->first(); // Retrieve the first row
            
            if ($paymentMethodIs && $paymentMethodIs->paymentmethod == 0) {
                $paymentMethodIsNotZero = "False";
            }   
            
            $invoicelist = Invoice::join('registration','invoice.reg_id','=','registration.id')
            ->join('customer','registration.cust_id','=','customer.id')
			   //->join('invoicedetails','invoice.id','=','invoicedetails.invoice_id')
			    //->join('alltests','invoicedetails.test_name','=','alltests.id')
			->leftJoin('master_payment_method', 'invoice.paymentmethod', '=', 'master_payment_method.id')
            ->selectRaw("IF($paymentMethodIsNotZero, master_payment_method.paymentmethod, 'Split Method') AS paymentmethod")
            ->addSelect('master_payment_method.paymentmethod AS pay_method')
                //   ->select('invoice.*','customer.name as name','registration.registerdate as date','registration.registertime as time','alltests.testname as testname','alltests.primaryprice as primaryprice','invoicedetails.test_unitprice as test_unitprice','invoicedetails.test_discount as test_discount','invoicedetails.test_tax_amount as test_tax_amount','invoicedetails.test_subtotal as test_subtotal')
   
			->where('registration.id','=', $registrationlastid)
			->orderBy('invoice.id','desc')
            ->get();
            
                
                $invdata['reg_id'] =$reg_id->reg_id;
                $invdata['invoicedetails'] = $invoicedetails;
                $invdata['customerdetails'] = $customerdetails;
                $invdata['invoicelist'] = $invoicelist;
                $invdata['password'] =$customerpass;
       return Response($invdata);
    }


    public function viewpayment(Request $request)
    {
        $id = $request->id;
        $paymentdetails = Invoice:: where('id',$id)->select('id as invid','invoice_number','totalamt','paidamt','balanceamt')->get();
        $paymentmethods = PaymentMethod::where("status", "=", 1)->select('id','paymentmethod')->get();
        
        $testlists = Transactions::join('invoice','invoice.id','=','transactions.invoice_id')
            ->join('staff','staff.id','=','transactions.staff_id')
            ->join('registration','registration.id','=','invoice.reg_id')
            ->join('customer','customer.id','=','registration.cust_id')
            ->join('master_payment_method','transactions.paymentmethod','=','master_payment_method.id')
            ->select('transactions.id as id','transactions.paidamount as paidamt','transactions.paymenttime as paytime','transactions.balanceamount as balanceamount','transactions.voucher_number as vouchernumber','invoice.invoice_number as invoiceno','invoice.totalamt as totalamt','staff.firstname','staff.lastname','invoice.reg_id','customer.name as customername','master_payment_method.paymentmethod as paymentmethod', Transactions::raw("CONCAT(transactions.paymentdate, ' ', transactions.paymenttime) AS date"))
            ->where('invoice.id',$id)
            ->orderBy('transactions.id','desc')
            ->get();  
            $invdata['testlists'] = $testlists;
        
        $invdata['paymentdetails'] = $paymentdetails;
        $invdata['paymentmethods'] = $paymentmethods;
        return Response($invdata);
    }

    function paymentupdate(Request $request){        
        $id = $request['hiddenid'];
        $invid = $request['hiddeninvoiceid'];
        $paymentmethod = $request['paymentmethod'];
        $paidamt =  number_format((float)$request['paidamount'], 2, '.', '');

        $updatepayment = Invoice::find($id);
        $grandtotal = $updatepayment->totalamt;
        $previouspaid = $updatepayment->paidamt;
        $previousbalance = $updatepayment->balanceamt;
        $totalpaid = $previouspaid+$paidamt;
        $currentbalance = $grandtotal-$totalpaid;
        $roundtotalpaid = number_format((float)$totalpaid, 2, '.', '');
        $roundbalanceamt = number_format((float)$currentbalance, 2, '.', '');
        if($roundbalanceamt == '0.00'){
            $paymenttype = 'paid';
        }else {
            $paymenttype = 'partial';
        }
              
        $updatepayment->paidamt = $roundtotalpaid;
        $updatepayment->balanceamt = $roundbalanceamt;
        $updatepayment->paymentstatus = $paymenttype;
        $updatepayment->paymentmethod = $paymentmethod;
        $updatepayment->update();

        if($paymenttype == 'paid') {
            $paymethod = 'full payment';
        } else 
        { 
            $paymethod = 'partial payment';
        }
        // LOG ACTIVITY STARTS HERE 
        $customerdetails = Invoice::join('registration','invoice.reg_id','=','registration.id')
                ->join('customer','registration.cust_id','=','customer.id')               
                ->select('customer.name as customername')
                ->where('invoice.id',$id)
                ->first();
        $loguserid = Auth::user()->staff_id;
        $logbranchid = Auth::user()->branchid;
        
        $logurl = url()->current();
        $logip = request()->ip();
        $logmethod =  request()->method();
        $logagent = $request->header('User-Agent');
        if($loguserid == '0') {
            $logusername = 'Super admin';
        } else {
            $loguserqry = Staff::where('id',$loguserid)->first();
            $logusername = $loguserqry->firstname.' '.$loguserqry->lastname;
        }
        $logsubject = "collected ".$paymethod." from ".$customerdetails->customername;
        
        $log = new Logactivity;
        $log->subject = $logusername.' '.$logsubject;
        $log->url = $logurl;
        $log->method = $logmethod;
        $log->ip = $logip;
        $log->agent = $logagent;
        $log->user_id = $loguserid;
        $log->staff_name = $logusername;
        $log->branch_id = $logbranchid;
        $log->save();
        // LOG ACTIVITY ENDS HERE
        
        $transaction = new Transactions();
        $vouchercount = Transactions::count();
       
        if($vouchercount>0){
            $latestvoucher= Transactions::latest('id')->first();
            $lastvouchernumber = $latestvoucher->voucher_number ;
            $incrementvouchernumber = ($lastvouchernumber+1);
            $vouchernumber = str_pad($incrementvouchernumber, 6, "0", STR_PAD_LEFT);
        } else 
        {
            $vouchernumber = '000001';
        }
        $transaction->voucher_number = $vouchernumber;
        $transaction->invoice_id = $id;
        $transaction->category  = 'registration';
        $transaction->transaction_type  = 'income';
        $transaction->paidamount = $paidamt;
        $transaction->balanceamount = $roundbalanceamt;
        $transaction->paymentmethod = $paymentmethod;
        $transaction->paymentdate = date('Y-m-d');
        $transaction->paymenttime = date('H:i a');
       // $transaction->staff_id = Auth::user()->staff_id;
       $transaction->staff_id = '3';
        $transaction->branchid = Auth::user()->branchid;
        $transaction->save();

        return redirect("invoice-list")->withSuccess('Payment updated successfully');
    }

    public function searchinvoicelist(Request $request)
    {
        //echo "working"; exit();
        /*
        $frmdate = $request->frmdate;
        $todate = $request->todate;
        $customer = $request->customer;
        $invoiceno = $request->invoiceno;
        $status = $request->status;
        */
        $frmdate = $request->searchfrmdate;
        $todate = $request->searchtodate;
        $customer = $request->searchcustomer;
        $invoiceno = $request->searchinvoice;
        $status = $request->searchstatus;
         $registration =$request->registration;

        $invoicelist = Invoice::join('registration','invoice.reg_id','=','registration.id')
        ->join('customer','registration.cust_id','=','customer.id');
        if($frmdate){
        $invoicelist = $invoicelist->where('registration.registerdate','>=',$frmdate);
        }
        if($todate) {
        $invoicelist = $invoicelist->where('registration.registerdate','<=',$todate);
        }
        if($customer) {
            $invoicelist = $invoicelist->where('customer.name','like',"%$customer%"); 
        }
        if($invoiceno) {
            $invoicelist = $invoicelist->where('invoice.invoice_number','like',"%$invoiceno%"); 
        }
        if($registration) {
        $invoicelist = $invoicelist->where('registration.cust_id','<=',$registration);
        }
        if($status) {
            $newstatus = strtolower($request->searchstatus);
            $invoicelist = $invoicelist->where('invoice.paymentstatus','like',"%$newstatus%"); 
        }
        

        $invoicelist = $invoicelist->select('invoice.*','customer.name as name','registration.registerdate as date','registration.registertime as time','registration.register_number as regnumber')
        ->orderBy('invoice.id','desc');
        
        $invoiceresult = $invoicelist->get();
       // $invoiceresult = $invoicelist->toSql();
        //dd($invoiceresult);
        
        return view('invoicelist', [
            'invoicelist' => $invoiceresult, 
            'frmdate'=>$frmdate, 
            'todate'=>$todate, 
            'customer'=>$customer, 
            'invoiceno'=>$invoiceno, 
            'status'=>$status
        ]);

        //$invoiceresult = $invoicelist->toSql();

        /*$invdata = Registration::select('')
        where('registerdate','=',$frmdate)->toSql();*/

        //$data['invdata'] = $invdata;
       // return Response($invoiceresult);


    }


}
