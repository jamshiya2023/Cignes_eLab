<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Parameter;
use App\Models\Normalrange;
use App\Models\Testresult;
use App\Models\TestReport;
use App\Models\TestReportValues;
use App\Models\Staff;
use App\Models\Logactivity;
use App\Models\SampleStatusDetails;
use App\Models\AllTests;

 
class TestController extends Controller
{
      public function testview()
       {
            if(Auth::check()){
             $userId = Auth::id();
           
	  $testlist = Invoice::join('registration','invoice.reg_id','=','registration.id')
            ->join('customer','registration.cust_id','=','customer.id')
			  ->join('sample_status_details','registration.id','=','sample_status_details.reg_id')
              // ->where('sample_status_details.collection_status','accepted')
              ->where('sample_status_details.collection_status','!=','rejected')
			    ->select('sample_status_details.id as sampleid','registration.id','customer.name','customer.phone','customer.place','registration.registerdate')
			    ->orderBy('sample_status_details.id','desc')
                 ->get();
                 
       $reporttest = [];

        foreach ($testlist as $pract) {
            $reports = TestReportValues::where('test_sample_id', $pract->sampleid)->select('*')->get();
            $reporttest = array_merge($reporttest, $reports->toArray());
        }
        //dd($reporttest);
			
			//	$reporttest = Testreport::where('reg_id',$regid)->get(); 
			
            return view('testresult',['testlist'=>$testlist,'reporttest'=>$reporttest]);
        }
         return redirect("/")->withError('You do not have access');
     }
	  
	 public function testlist_view(Request $request){
      
	  $sampleid = $request->input('id');
	 
                $testlists = Testreport::join('registration', 'testreport.reg_id', '=', 'registration.id')
                            ->join('invoice', 'registration.id', '=', 'invoice.reg_id')
                            ->join('customer', 'registration.cust_id', '=', 'customer.id')
                            ->join('testreportvalues', 'testreport.id', '=', 'testreportvalues.report_id')
                            ->join('alltests', 'testreportvalues.test_id', '=', 'alltests.id')
                            ->join('normalranges', 'testreportvalues.test_id', '=', 'normalranges.singletest_id')
                            ->where('testreport.test_sample_id',  $sampleid)
                            ->groupBy('testreportvalues.test_id')
                            // ->select('testreport.test_id as main_id','normalranges.generalrange', 'alltests.id AS sid', 'testreportvalues.test_id', 'testreport.id as report_id', 'registration.id as reg_id', 'registration.gender', 'customer.place', 'customer.name', 'customer.phone', 'customer.email', 'testreportvalues.result', 'alltests.testname')
                                ->select('testreport.test_id as main_id', 'normalranges.*', 'alltests.id AS sid', 'testreportvalues.test_id', 'testreport.id as report_id', 'registration.id as reg_id', 'registration.gender', 'registration.age', 'testreportvalues.test_sample_id','testreportvalues.reg_id', 'customer.place', 'customer.name', 'customer.phone', 'customer.email', 'testreportvalues.result', 'alltests.testname','alltests.created_at as date')

                            ->get();
        $testingIds=[];
                //$testdetails = AllTests::where('id',$countIds[$i])->select('*')->first();
                 foreach($testlists as $test)
                {
                          $sid              =  $test->sid;
                		  $rid              =  $test->rid;
                		  $name             =  $test->name;
                		  $email            =  $test->email;
                		  $phone            =  $test->phone;
                		  $place            =  $test->place;
                		  $testname         =  $test->testname;
                		  $gender           =  $test->gender;
                		  $result           =  $test->result;
                           $mainid          = $test->main_id;    
                       $generalrange = $test->agefrom.' '.$test->lowerchronological.'-'. $test->ageto.''.$test->higherchronological.
    '<br>Male Value--'.$test->minmalevalue.' to '.$test->maxmalevalue.
    '<br>Female value--'.$test->minfemalevalue.' to '.$test->maxfemalevalue;
$testingIds[$test->sid][] = $generalrange;
$testIds[] = $test->sid;
                    
                }//dd($testingIds);
                
                if(count($testlists)> 1)
            {
                $datas['SingleTest'] = 'false';
                $testMainName = AllTests::where('id',$mainid)->select('*')->first();
                $datas['Mainid'] = $testMainName->testname;
                
            }
            else
            {
                $datas['SingleTest'] = 'true';
                $datas['Mainid'] = '';
                
            }
                    
                    $datas['testlists'] = $testlists; 
                     $datas['generalrange'] = $testingIds; 
                     $datas['testIds'] = $testIds;
	                $datas['rid'] = $rid; 
                    $datas['name'] = $name; 
		            $datas['email'] = $email; 
		            $datas['phone'] = $phone; 
		            $datas['place'] = $place; 
		            $datas['testname'] = $testname; 
		            $datas['sampleid'] = $sampleid;
            
		   
	  return response()->json($datas);  
		
	 }
	 
	 public function testdetails_view(Request $request){
      
	  $sampleid = $request->input('id');
	 
            
        $testlists = Registration::join('invoice', 'registration.id', '=', 'invoice.reg_id')
                        ->join('customer', 'registration.cust_id', '=', 'customer.id')
                        ->join('testresult', 'registration.id', '=', 'testresult.reg_id')
                        ->join('sample_status_details', 'registration.id', '=', 'sample_status_details.reg_id')
                        ->join('alltests', 'sample_status_details.test_id', '=', 'alltests.id')
                        ->where('sample_status_details.id',$sampleid)
                        ->select('registration.id AS rid', 'alltests.id AS sid', 'alltests.testname', 'alltests.singletestids', 'registration.gender','registration.age', 'customer.name', 'customer.phone', 'customer.email', 'registration.add_line_one', 'customer.place', 'registration.registerdate', 'testresult.status')
                        ->groupBy('sample_status_details.id')
                        ->orderBy('sample_status_details.id', 'desc')
                        ->get();
            // dd($testlists);    
            if(count($testlists)<= 1)
            {   
                 foreach($testlists as $test)
                {
                          $sid              =  $test->sid;
                		  $rid              =  $test->rid;
                		  $name             =  $test->name;
                		  $email            =  $test->email;
                		  $phone            =  $test->phone;
                		  $place            =  $test->place;
                		  $testname         =  $test->testname;
                		  $address          =  $test->add_line_one;
                		  $parameters       =  $test->parameter_id;
                		  $gender           =  $test->gender;
                		  $femalerange      =  $test->femalerange;
                		  $malerange        =  $test->malerange;
                		  $registerdate     =  $test->registerdate;
                		  $age              = $test->age;
                               
                    if($test->singletestids != null)
                    {
                        $testDetails=array();
                        $datas['SingleTest'] = 'false'; 
                        $countIds = explode(',',$test->singletestids);
                        $testingIds =[];
                        for($i=0;$i<count($countIds);$i++)
                        {
                            $testdetails = AllTests::where('id',$countIds[$i])->select('*')->first();
                            $testName[] = $testdetails->testname;
                            $testIds[] =$countIds[$i];
                            
                        $test_details = Normalrange::where('singletest_id', $countIds[$i])
                        ->where('agefrom', '<=', $age)
                        ->where('ageto', '>=', $age)
                        ->select('*')
                        ->get();
                        if ($test_details->isEmpty()) {
                            $test_details = Normalrange::where('singletest_id',$countIds[$i])->select('*')->get();
                        }
                        else
                        {
                            $test_details = Normalrange::where('singletest_id', $countIds[$i])
                        ->where('agefrom', '<=', $test->age)
                        ->where('ageto', '>=', $test->age)
                        ->select('*')
                        ->get();
                        }
                          
                            if ($test_details->isNotEmpty()) {
                                foreach ($test_details as $test) {
                                        $lowertype = $test->lowertype;
                                        $agefrom = $test->agefrom;
                                        $lowerchronological = $test->lowerchronological;
                                        $highertype = $test->highertype;
                                        $ageto = $test->ageto;
                                        $higherchronological = $test->higherchronological;
                                        $minmalevalue = $test->minmalevalue;
                                        $maxmalevalue = $test->maxmalevalue;
                                        $minfemalevalue =  $test->minfemalevalue;
                                        $maxfemalevalue = $test->maxfemalevalue;
                                       // $generalrange[] =$agefrom.' '.$lowerchronological.'-'. $ageto.''.$higherchronological.'--Male Value--'.$minmalevalue.'to'.$maxmalevalue.' --Female value--'.$minfemalevalue.'to'.$maxfemalevalue;
                                        // do something with $generalrange
                                   $generalrange = $agefrom.' '.$lowerchronological.'-'. $ageto.''.$higherchronological.
                      '<br>Male Value--'.$minmalevalue.' to '.$maxmalevalue.
                      '<br>Female value--'.$minfemalevalue.' to '.$maxfemalevalue;
                      $testingIds[$countIds[$i]][] = $generalrange;
                                }
                            } else {
                                $testingIds[] = '';
                            }

                           
                            
                        } //print_r($testName);
                    }
                    else
                    {
                        
                        $testDetails=array();
                        $datas['SingleTest'] = 'true';
                        $testName[]          =  $test->testname;
                        $testIds[] =$test->sid;
                        $testingIds =[];
                        //$testDetails = Normalrange::where('singletest_id',$test->sid)->select('*')->get();
                        $testDetails = Normalrange::where('singletest_id', $test->sid)
                        ->where('agefrom', '<=', $test->age)
                        ->where('ageto', '>=', $test->age)
                        ->select('*')
                        ->get();
                        if ($testDetails->isEmpty()) {
                            $testDetails = Normalrange::where('singletest_id',$test->sid)->select('*')->get();
                        }
                       
                        
                     //dd($testDetails);
                         if ($testDetails->isNotEmpty()) {
                                foreach ($testDetails as $test) {
                                     $lowertype = $test->lowertype;
                                        $agefrom = $test->agefrom;
                                        $lowerchronological = $test->lowerchronological;
                                        $highertype = $test->highertype;
                                        $ageto = $test->ageto;
                                        $higherchronological = $test->higherchronological;
                                        $minmalevalue = $test->minmalevalue;
                                        $maxmalevalue = $test->maxmalevalue;
                                        $minfemalevalue =  $test->minfemalevalue;
                                        $maxfemalevalue = $test->maxfemalevalue;
                                       // $generalrange[] =$agefrom.' '.$lowerchronological.'-'. $ageto.''.$higherchronological.'<br>--Male Value--'.$minmalevalue.'to'.$maxmalevalue.' <br>--Female value--'.$minfemalevalue.'to'.$maxfemalevalue;
                                        // do something with $generalrange
                                     
                                   $generalrange = $agefrom.' '.$lowerchronological.'-'. $ageto.''.$higherchronological.
                      '<br>--Male Value--'.$minmalevalue.' to '.$maxmalevalue.
                      '<br>--Female value--'.$minfemalevalue.' to '.$maxfemalevalue;
                      $testingIds[$test->singletest_id][] = $generalrange;
                                }
                            } else {
                                $testingIds[] = '';
                            }
                    
                    }
                    
                    
                } 
                    //dd($testingIds);
                    $datas['testlists'] = $testlists; 
	                $datas['rid'] = $rid; 
                    $datas['name'] = $name; 
		            $datas['address'] = $address;   
	                $datas['email'] = $email; 
		            $datas['phone'] = $phone; 
		            $datas['place'] = $place; 
		            $datas['date'] = $registerdate; 
		            $datas['testname'] = $testname; 
		            $datas['subtest'] = $testName;
		            $datas['generalrange'] = $testingIds;
		            $datas['testIds'] = $testIds;
		            $datas['sampleid'] = $sampleid;
		            $datas['age'] = $age;
            }
		   
	  return response()->json($datas);  
		
	 }
	   function addtestresult(Request $request)
       {
           
           $ids         = $request->ids;
		   $testVal     = $request->testValue;
		   $sampleid    = $request->samplesIds[0];
		   
		  
		       $samplez = SampleStatusDetails::where('id',$sampleid)->get();
		     //dd($samplez);
    		   foreach($samplez as $sample)
    		   {
    			  $regid= $sample->reg_id;
    			 $testid=  $sample->test_id;
    		   }
		    
    		   $invoicez = Invoice::where('reg_id',$regid)->get();
    		   foreach($invoicez as $invoice)
    		   {
    			  $invoiceid= $invoice->id;
    			  
    		   }
		   
		
        	    $testresult = new Testreport;
                $testresult->reg_id = $regid;
        		$testresult->invoice_id = $invoiceid;
        		$testresult->test_id = $testid;  
        		$testresult->test_sample_id = $sampleid;
               // $testresult->result = $request['normalrange_min'];
                $testresult->status = '1';
                $testresult->save();
                $insertedId = $testresult->id;
                
                if($insertedId)
                { 
                     foreach ($ids as $index => $id) 
                     {
                        $note = $testVal[$index];
                        
                        $testresultvalues = new Testreportvalues;
                        $testresultvalues->report_id = $insertedId;
                        $testresultvalues->reg_id = $regid;
                		$testresultvalues->invoice_id = $invoiceid;
                		$testresultvalues->test_id = $id;  
                		$testresultvalues->test_sample_id = $sampleid;
                        $testresultvalues->result = $note;
                        $testresultvalues->status = '1';
                        $testresultvalues->save();
                     }
                    
                }
                
                $loguserid = Auth::user()->staff_id;
        	    $logbranchid = Auth::user()->branchid;
                $logurl = url()->current();
                $logip = request()->ip();
                $logmethod =  request()->method();
                $logagent = $request->header('User-Agent');
                $logsubject = "Test Result";
                
                if($loguserid == '0') {
                    $logusername = 'Super admin';
                } else {
                    $loguserqry = Staff::where('id',$loguserid)->first();
                    $logusername = $loguserqry->firstname.' '.$loguserqry->lastname;
                }
                $log = new Logactivity;
                $log->subject = $logusername.' '.$logsubject;
                $log->url = $logurl;
                $log->method = $logmethod;
                $log->ip = $logip;
                $log->agent = $logagent;
                $log->user_id = $loguserid;
                $log->staff_name = $logusername;
        		$log->branch_id ='0';
                $log->save();
		
		
		        $SampleStatusDetails = SampleStatusDetails::find($sampleid);
		        $SampleStatusDetails->collection_status  = 'update result';
		        $SampleStatusDetails->update();
		
	            return redirect("test-result")->withSuccess('Test Result Added successfully');    
		  
	    }
	      
	public function testreports()
       {
            if(Auth::check()){
             $userId = Auth::id();
           
	        $testreport = Invoice::join('registration','invoice.reg_id','=','registration.id')
            ->join('customer','registration.cust_id','=','customer.id')
			  ->join('sample_status_details','registration.id','=','sample_status_details.reg_id')
                ->join('testreport','sample_status_details.id','=','testreport.test_sample_id')
				->where('sample_status_details.collection_status','accepted')
			     ->select('sample_status_details.id as sampleid','registration.id','customer.name','customer.phone','customer.place','registration.registerdate')
                  ->get();
             return view('testreport',['testreport'=>$testreport]);
        }
         return redirect("/")->withError('You do not have access');
     }
		  
	 public function invoice_refundview33(Request $request){
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
}
