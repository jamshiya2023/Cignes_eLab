<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\RejectReason;
use App\Models\Testresult;
use App\Models\SampleStatusDetails;
use App\Models\AllTests;
use App\Models\Staff;
use App\Models\Logactivity;
use App\Models\Customer;

class RejectReasonController extends Controller
{
    public function rejectreasonview()
    {
        if(Auth::check()){
            $userId = Auth::id();
            $rejectreasons = RejectReason::select('id','rejectreason','status','rejectreason_arabic')
            ->orderBy('id','desc')
            ->get();
            return view('master_reject_reason', ['rejectreasons' => $rejectreasons]);
        }
        return redirect("/")->withError('You do not have access');
    }
    public function rejectreasonadds(Request $request)
    {//dd($request);
        if(Auth::check()){
            $userId = Auth::id();
            $rejectreason = new RejectReason;
            $rejectreason->rejectreason = $request->input('rejectreasonname');
             $rejectreason->rejectreason_arabic = $request->input('arabicrejectreasonname');
            
            $rejectreason->status = '1';
            $rejectreason->staffid = $userId;
            $rejectreason->branchid = '0';        
            $rejectreason->save();
            return redirect("reject-reason")->withSuccess('Reject reason added successfully');
        }
        return redirect("/")->withError('You do not have access');
    }
    public function editrejectreasonview(Request $request)
    {         
       $id = $request->id;
       $rejectreason = RejectReason::where('id',$id)
                ->select('id','rejectreason','rejectreason_arabic')
                ->first();
       return Response($rejectreason);
    }

    public function rejectreasonedit(Request $request)
    { 
        $id = $request->input('hiddenid');
        $rejectreason = RejectReason::find($id);
        $rejectreason->rejectreason = $request->input('rejectreasonnameedit');
         $rejectreason->rejectreason_arabic = $request->input('arabicrejectreasonnameedit');
        $rejectreason->update();
        return redirect("reject-reason")->withSuccess('Reject reason updated successfully');    
    }

    // BLOCKING AND UNBLOCKING REJECT REASON STARTS HERE
    public function block(Request $request, $id)
    {
        $rejectreason = RejectReason::find($id);
        $rejectreason->status = '0';        
        $rejectreason->update();
        return redirect("reject-reason")->withSuccess('Reject reason blocked successfully');
    }

    public function unblock(Request $request, $id)
    {
        $rejectreason = rejectreason::find($id);
        $rejectreason->status = '1';        
        $rejectreason->update();
        return redirect("reject-reason")->withSuccess('Reject reason unblocked successfully');
    }
    // BLOCKING AND UNBLOCKING REJECT REASON ENDS HERE 
    
    
    /* public function rejectreasonadd_new(Request $request)
    {
        if(Auth::check()){
           
            $userId = Auth::id();
            $rejectreason = new RejectReason;
            $rejectreason->rejectreason = $request->input('rejectreasonname');
            $rejectreason->status = '1';
            $rejectreason->staffid = $userId;
            $rejectreason->branchid = '0';        
            $rejectreason->save();
            // return redirect("sample",['rejectreson'=>$rejectreson])->withSuccess('Reject reason added successfully');
            return redirect("sample")->with(['rejectreason' => $rejectreason])->withSuccess('Reject reason added successfully');

        }
        return redirect("/")->withError('You do not have access');
    }*/
    public function rejectreasonadd_new(Request $request)
    {
        $rejectreason = $request->input('rejectReasonPopup');
        $rejectionnote = $request->input('rejectioNote');
        $sample_id = $request->input('itemId');
        //dd($sample_id);
       /* $rejectreason = Testresult::find($id);
        $rejectreason->status ='rejected';
        $rejectreason->reject_reason =$rejectreason;
        $rejectreason->reject_note =$rejectionnote;
        $rejectreason->updated_at =date("Y-m-d h:i:s");*/

        //dd($sample_id);
           if($sample_id)
           {
            //dd($rejectreason);
                $upquery = Testresult::where('id', $sample_id)->update([
                'status'=>'rejected',
                'reject_reason'=>$rejectreason,
                'reject_note'=>$rejectionnote,
                'staff_id'=>'1',
                'updated_at' =>date("Y-m-d h:i:s"),
                ]);
                if($upquery){
                    
                        $testdetails = Testresult::where('id',$sample_id)->select('*')->first();
                         $status = 'rejected'; 
                        // LOG ACTIVITY STARTS HERE 
            $logtest = AllTests::where('id',$testdetails->test_id)->select('testname')->first(); 
            $logcustomer = Customer::where('id',$testdetails->cust_id)->select('name')->first();
            if($status == 'collected')
            {
                $logstatus = "collected sample for".$logtest->testname." test of ".$logcustomer->name;
            } else {
                $logstatus = "moved the status of ".$logtest->testname." test's of ".$logcustomer->name." to pending status";
            }
            
            $loguserid = Auth::user()->staff_id;
            $logbranchid = Auth::user()->branchid;
            $logurl = url()->current();
            $logip = request()->ip();
            $logmethod =  request()->method();
            $logagent = $request->header('User-Agent');
            $logsubject = $logstatus;
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
            $log->branch_id = $logbranchid;
            $log->save();       
            // LOG ACTIVITY ENDS HERE  
                        
                      
                       $samplestatus = new SampleStatusDetails;
                        $samplestatus->cust_id = $testdetails->cust_id;
                        $samplestatus->sample_id =$sample_id;
                        $samplestatus->reg_id = $testdetails->reg_id;
                        $samplestatus->test_id = $testdetails->test_id;
                        $samplestatus->sample_collection_note = $testdetails->sample_collection_note;
                        $samplestatus->sample_collected_date_time = $testdetails->sample_collected_date_time;
                        $samplestatus->sample_received_date_time = $testdetails->sample_received_date_time;
                        $samplestatus->collection_status = $status;
                        $samplestatus->staff_id = $loguserid;
                        $samplestatus->branch_id = $logbranchid;
                        $samplestatus->save();
                    
                }


           }
           
            // return redirect("sample",['rejectreson'=>$rejectreson])->withSuccess('Reject reason added successfully');
            return redirect("sample")->withSuccess('Reject reason added successfully');

        
    }

}
