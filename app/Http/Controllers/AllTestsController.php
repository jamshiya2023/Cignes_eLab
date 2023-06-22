<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\AllTests;
use App\Models\Normalrange;
use App\Models\Tax;
use App\Models\Logactivity;
use App\Models\TestCategory;
use App\Models\Parameter;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Models\Labunit;
use App\Models\Tube;
use App\Models\Machine;
use App\Models\TestMethod;
use App\Models\Sampletype;

class AllTestsController extends Controller
{
    /* SINGLE TEST SECTION STARTS HERE */
    public function testsview(){
        if(Auth::check()){  
            $singletest = AllTests::where('status','=',1)
            ->where('testtype','singletest')
            ->get();  
            $profiletest = AllTests::select('*')->where('status','=',1)->where('testtype','=','profiletest')->get();      
            return view('tests', [
                'singletest' => $singletest,
                'profiletest' => $profiletest 
            ]);
        }
        return redirect("/")->withError('You do not have access');

    }
    public function singletestsview(){
        if(Auth::check()){  
            $singletest = AllTests::leftJoin('master_test_category', 'master_test_category.id','=','alltests.testcategory')
            // ->where('alltests.status','=',1)
            ->where('alltests.testtype','singletest')
            ->select('alltests.*','master_test_category.testcategory as category')
            ->orderBy('id','desc')
            ->get();  
            
            return view('singletests', [  
                'singletest' => $singletest,
               
            ]);
            
            
        }
        return redirect("/")->withError('You do not have access');

    }
    public function profiletestsview(){
        if(Auth::check()){  
              
            $profiletest = AllTests::select('*')->where('status','=',1)->where('testtype','=','profiletest')->orderBy('id','desc')->get();      
            return view('profiletests', [
                
                'profiletest' => $profiletest 
            ]);
        }
        return redirect("/")->withError('You do not have access');

    }
     public function viewaddsingletest()
    {
        if(Auth::check()){
            $labunit=Labunit::all();
            $tax = Tax::where('status','=','1')->get();
 			$parameter = Parameter::where('status','=','1')->get();
			$tube=Tube::all();
           // dd($parameter);die();
			 $containers = Container::select('id','container_name','container_name_arabic','container_serial_no','status')
                          ->get();
			 $testcategory = TestCategory::select('id','testcategory','testcategory_arabic')
                           ->get();
                           $machines = Machine::select('id as machineid', 'machine_name')->where('status','=','1')->get();
                           $methods = TestMethod::select('id as testmethodid', 'testmethod')->where('status','=','1')->get();
                            $sample = Sampletype::select('id as sampleid', 'sample_type_name')->where('status','=','1')->get();
			return view('addsingletest',[
                'taxes'=>$tax,
				 'parameter'=>$parameter,
				'containers'=>$containers,
				'testcategory'=>$testcategory,
				'labunit'=>$labunit,
				 'machines' => $machines,
				 'testmethods' => $methods,
				  'samplrtype' => $sample,
				'tube'=>$tube
                ]);
        }
        return redirect("/")->withError('You do not have access');
    }
    
    public function viewaddsingletest33()
    {
        if(Auth::check()){
           // return view('addsingletest');
            $tax = Tax::where('status','=','1')->get();
            return view('addsingletest', [
                'taxes'=>$tax
                ]);
        }
        return redirect("/")->withError('You do not have access');
    }

    public function addranges(Request $request)
    {       
        $normalranges =  new Normalrange ;       
        $normalagefrom = $request->input('agefrom');
        $normalageto = $request->input('ageto');
        $normalgeneralrange= $request->input('generalrange');
        $normalmalerange = $request->input('malerange');
        $normalfemalerange = $request->input('femalerange');
        $sid = $request->input('sid');   
  
        $normalranges->singletest_id = $sid;
        $normalranges->agefrom = $normalagefrom;
        $normalranges->ageto = $normalageto;
        $normalranges->generalrange = $normalgeneralrange;
        $normalranges->malerange = $normalmalerange;
        $normalranges->femalerange = $normalfemalerange;
        $normalranges->status = '1';
        $normalranges->save(); 
    
        $lastid = $normalranges->id;
        $responseDocuments = Normalrange::select('*')->where('id', $lastid)->first();            
            $data['id'] = $responseDocuments->id;
            $data['agefrom'] = $responseDocuments->agefrom;
            $data['ageto'] = $responseDocuments->ageto;
            $data['generalrange'] = $responseDocuments->generalrange;
            $data['malerange'] = $responseDocuments->malerange;
            $data['femalerange'] = $responseDocuments->femalerange;
            $data['success'] = 1;
        return response()->json($data);
    }

    public function addsingletest(Request $request)
    {
       // dd($request);
        $singletest                 =  new AllTests ;
        $singletestname             = $request->input('testname');
        $singletestname_ar          = $request->input('testname_ar');
        $singletestliscode          = $request->input('liscode');
        $singleprimaryprice         = $request->input('primaryprice');
        $singlesecondaryprice       = $request->input('secondaryprice');
        $singletestquantity         = $request->input('quantity');
        $taxtid                     = $request->input('taxname');
        $taxmethod                  = $request->input('taxmethod');
        $containers                 = $request->input('containers');
		$testcategory               = $request->input('testcategory');
 		$labunit                    = $request->input('units');
		$tubes                      = $request->input('tubes');
		$equipment                  = $request->input('equipment');
		$resultvalue                = $request->input('resultvalue');
		$duration                   = $request->input('duration');
		$parametermethod            = $request->input('parametermethod');
		$samplrtype                 = $request->input('samplrtype');
		$instruction                = $request->input('instruction');
		$instruction_ar             = $request->input('instruction_ar');
		$description                = $request->input('description');
		$description_ar             = $request->input('description_ar');
		$test_separately           = $request->has('test_separately');
		
        $singletest->testname               = $singletestname;
        $singletest->testnamear             = $singletestname_ar;
        $singletest->testcode               = $singletestliscode;
        $singletest->containers             = $containers;
		$singletest->testcategory           = $testcategory;
        $singletest->primaryprice           = $singleprimaryprice;
        $singletest->secondaryprice         = $singlesecondaryprice;
        $singletest->tax_id                 = $taxtid;
        $singletest->tax_method             = $taxmethod;  
        //$singletest->parameter              = $parameter;
        $singletest->units                  = $labunit;
        $singletest->tubes                  = $tubes;
        $singletest->equipment              = $equipment;                  
		$singletest->resultvalue            = $resultvalue;               
		$singletest->duration               = $duration;                  
		$singletest->parameter_method       = $parametermethod;            
		$singletest->test_description       = $description;
        $singletest->test_description_ar    = $description_ar;
        $singletest->test_instruction_ar    = $instruction_ar;
        $singletest->test_instruction       = $instruction;
        $singletest->testtype               = 'singletest';
        $singletest->sample_type            = $samplrtype;
        $singletest->quantity               = $singletestquantity;
        $singletest->status                 = '1';
        $singletest->test_separately       = $test_separately;
        $singletest->save(); 
        $singlelastid = $singletest->id; 
        
        // UPDATE THE SINGLE TEST ID IN THE SINGLE TEST DOCUMENTS  STARTS HERE 
        
        $NorLVal = $request->tableData;
        $dataArray = json_decode($NorLVal, true);
        if(!empty( $dataArray))
        {
            foreach ($dataArray as $data) {
            $normalranges                       = new Normalrange;
            $normalranges->singletest_id        = $singlelastid;
            $normalranges->lowertype            = $data['lowertype'];
            $normalranges->agefrom              = $data['lowervalue'];
            $normalranges->lowerchronological   = $data['lowerchronological'];
            $normalranges->highertype           = $data['highertype'];
            $normalranges->ageto                = $data['highervalue'];
            $normalranges->higherchronological	= $data['higherchronological'];
            $normalranges->malerange            = $data['malevalue'];
            $normalranges->minmalevalue         = $data['minmalevalue'];
            $normalranges->maxmalevalue         = $data['maxmalevalue'];
            $normalranges->femalerange          = $data['femalevalue'];
            $normalranges->minfemalevalue       = $data['minfemalevalue'];
            $normalranges->maxfemalevalue       = $data['maxfemalevalue'];
            $normalranges->status               = '1';
            $normalranges->save(); 
                
        }
        }
     
        /*$update_details = array('singletest_id' => $singlelastid);    
        $normalrangetestid = Normalrange::where('singletest_id', '0')->update($update_details);*/
        
        
        
        
        // UPDATE THE SINGLE TEST ID IN THE SINGLE TEDT DOCUMENTS  ENDS HERE 


        // LOG ACTIVITY STARTS HERE 
        $loguserid = Auth::user()->staff_id;
        $logbranchid = Auth::user()->branchid;
        $logurl = url()->current();
        $logip = request()->ip();
        $logmethod =  request()->method();
        $logagent = $request->header('User-Agent');
        $logsubject = "added ".$singletestname." as single test";
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
        return redirect("singletest")->with('singletestsuccess',"Single test added successfully");
    }

    public function deletenormalrange(Request $request)
    {
        $id = $request->input('id'); 
        $sid = $request->input('sid'); 
        $res=Normalrange::where('id',$id)->delete();
        $doccount = Normalrange::where('singletest_id',$sid)->count();
        $data['success'] = 1;  
        $data['doccount'] = $doccount;  
        
        
        return response()->json($data);
        // $data['success'] = 1;
    }

    public function viewnormalrange(Request $request)
    {
        $id = $request->id; 
        
        $res = Normalrange::join('alltests','alltests.id','=','normalranges.singletest_id')
                ->join('master_labunit','master_labunit.id','=','alltests.units')
            ->select('master_labunit.labunit_name as units','alltests.testname as name','normalranges.*')
             ->where('normalranges.singletest_id',$id)
            ->orderBy('id','asc')
            ->get();
            
        return Response($res);
    }


    public function updatesingletest($id)
    {
        if(Auth::check()){        
            $singletestlist = AllTests::where('id', $id)->first();
            $normalrangelist = Normalrange::where('singletest_id', $id)->get();
            $tax = Tax::where('status','=','1')->get();
            
            $containers = Container::select('id','container_name','container_name_arabic','container_serial_no','status')
                          ->get();
			$testcategory = TestCategory::select('id','testcategory','testcategory_arabic')
                           ->get();
			 $labunit = Labunit::all();
            $tube= Tube::all();
             $machines = Machine::select('id as machineid', 'machine_name')->where('status','=','1')->get();
                           $methods = TestMethod::select('id as testmethodid', 'testmethod')->where('status','=','1')->get();
                            $sample = Sampletype::select('id as sampleid', 'sample_type_name')->where('status','=','1')->get();
            return view('editsingletest', [
                'singletestlist'=>$singletestlist,
                'normalrangelist'=>$normalrangelist,
                'taxes'=>$tax,
                'containers'=>$containers,
				'testcategory'=>$testcategory,
				 'labunit'=>$labunit,
				 'tube'=>$tube,
				  'machines' => $machines,
				 'testmethods' => $methods,
				  'samplrtype' => $sample,
				 'testId' =>$id
                ]);
        }
        return redirect("/")->withError('You do not have access');
    }

    public function updatesingletestpost(Request $request, $id)
    {
        //dd($request);
        $singletest = AllTests::find($id);
        $singletest->testname           = $request->input('testname'); 
        $singletest->containers         = $request->input('containers'); 
        $singletest->primaryprice       = $request->input('primaryprice'); 
        $singletest->secondaryprice     = $request->input('secondaryprice'); 
        $singletest->tax_id             = $request->input('taxname');  
        $singletest->tax_method         = $request->input('taxmethod');
        $singletest->testcategory       = $request->input('testcategory');
        $singletest->units              = $request->input('units');
        $singletest->tubes              = $request->input('tubes');
        $singletest->testnamear         = $request->input('testname_ar');
        $singletest->testcode           = $request->input('liscode');
        $singletest->quantity           = $request->input('quantity');
        $singletest->equipment          = $request->input('equipment');
        $singletest->resultvalue        = $request->input('resultvalue');
        $singletest->duration           = $request->input('duration');
        $singletest->parameter_method   = $request->input('parametermethod');
        $singletest->sample_type        = $request->input('samplrtype');
        $singletest->test_instruction   = $request->input('instruction');
        $singletest->test_instruction_ar= $request->input('instruction_ar');
        $singletest->test_description        = $request->input('description');
        $singletest->test_description_ar    = $request->input('description_ar');
        $singletest->test_separately           = $request->has('test_separately');
        
        $singletest->update();

        // LOG ACTIVITY STARTS HERE 
        $singletestname = AllTests::where('id',$id)->select('testname')->first();
        $loguserid = Auth::user()->staff_id;
        $logbranchid = Auth::user()->branchid;
        $logurl = url()->current();
        $logip = request()->ip();
        $logmethod =  request()->method();
        $logagent = $request->header('User-Agent');
        $logsubject = "updated ".$singletestname->testname." single test ";
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
        return redirect("singletest")->with('singletestsuccess',"Single test updated successfully");
    }

/* SINGLE TEST SECTION ENDS HERE*/

/* PROFILE TEST SECTION STARTS HERE */

    public function addprofiletestview()
    {
        if(Auth::check()){        
            $singletest = AllTests::select('*')->where('status','=',1)->where('testtype','=','singletest')->get();
            //return view('addprofiletest', compact('singletest'));
            $tax = Tax::where('status','=','1')->get();
            return view('addprofiletest', [
                'singletest'=>$singletest,
                'taxes'=>$tax
                ]);


            // return view('addprofiletest');
        }
        return redirect("/")->withError('You do not have access');
    }

    public function addprofiletest(Request $request)
    {
        $profiletest =  new AllTests ;
        $profilename = $request->input('profilename');
        
         $profilenamear = $request->input('profilenamear');
         
         $profileprimaryprice = $request->input('primaryprice');
        $profilesecondaryprice= $request->input('secondaryprice');
        $taxtid= $request->input('taxname');
        
         $image=$request->input('image');
        $test_description=$request->input('test_description');
         $test_descriptionar=$request->input('test_descriptionar');
        $taxmethod = $request->input('taxmethod');
        $singletestString = implode(",", $request->get('singletest'));
        
        $profiletest->testname = $profilename;
        $profiletest->testnamear = $profilenamear;
        
        $profiletest->primaryprice = $profileprimaryprice;
        $profiletest->secondaryprice = $profilesecondaryprice;
        $profiletest->tax_id = $taxtid;
        $profiletest->tax_method = $taxmethod;
        $profiletest->image=$image;
        $profiletest->test_description=$test_description;
        $profiletest->test_description_ar=$test_descriptionar;

        $profiletest->testtype = 'profiletest';
        $profiletest->status = '1';
        $profiletest->singletestids = $singletestString;
        $profiletest->save(); 

        // LOG ACTIVITY STARTS HERE 
        $loguserid = Auth::user()->staff_id;
        $logbranchid = Auth::user()->branchid;
        $logurl = url()->current();
        $logip = request()->ip();
        $logmethod =  request()->method();
        $logagent = $request->header('User-Agent');
        $logsubject = "added ".$profilename." as profile test";
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
        return redirect("profiletest")->with('profiletestsuccess',"Profile test added successfully");

    }

    public function addadditionaltestprofile(Request $request)
    {
        $profiletest =  new AllTests;            
        $singletestname = $request->input('singletestname');

        $profiletest->testname = $singletestname;
        $profiletest->testtype = 'singletest';
        $profiletest->status = '0';
        $profiletest->save(); 

        // LOG ACTIVITY STARTS HERE 
        $loguserid = Auth::user()->staff_id;
        $logbranchid = Auth::user()->branchid;
        $logurl = url()->current();
        $logip = request()->ip();
        $logmethod =  request()->method();
        $logagent = $request->header('User-Agent');
        $logsubject = "added ".$singletestname." as additional single test to profile test";
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

        $lastid = $profiletest->id; 

            $responsesingletest = AllTests::select('*')->where('id', $lastid)->where('testtype','singletest')->first();
            $data['sid'] = $responsesingletest->id;
            $data['singletestname'] = $responsesingletest->testname;
            $data['success'] = '1';                      
            return response()->json($data);
    }

    public function viewsingletests(Request $request)
    {       
        $id = $request->id; //1,4 
        $idsArr = explode(',',$id);  //1 4
        $res = AllTests::whereIn('id',$idsArr)->get();
        return Response($res);
    }


    public function updateprofiletest($id)
    {
        if(Auth::check())
        {        
            $profiletestlist = AllTests::where('id', $id)->where('testtype','profiletest')->first();

            $profiletest = AllTests::find($id);
            $prefs = $profiletest->singletestids;
            $tags = explode(',', $prefs);
            $singletests = AllTests::whereIn('id', $tags)
                ->get(['id', 'testname']);
            $remainingstests =    AllTests::whereNotIn('id', $tags)
            ->where('status','=',1)
            ->where('testtype','=','singletest')
            ->get(['id', 'testname']); 
            $tax = Tax::where('status','=','1')->get();
                return view('editprofiletest', [
                    'profiletestlist'=>$profiletestlist,
                    'singletest'=>$singletests,
                    'remainingsingletest'=>$remainingstests,
                    'taxes'=>$tax               
                ]); 
        }
        return redirect("/")->withError('You do not have access');
    }

    public function updateprofiletestpost(Request $request, $id)
    {
       // dd($request->all());      
        $profiletest = AllTests::find($id);
        $profiletest->testname = $request->input('profilename'); 
        $profiletest->testnamear = $request->input('profilenamear'); 
        $profiletest->primaryprice = $request->input('primaryprice'); 
        $profiletest->secondaryprice = $request->input('secondaryprice');
        $profiletest->tax_id = $request->input('taxname'); 
        $profiletest->tax_method = $request->input('taxmethod');
        $singletestString = implode(",", $request->get('singletest')); 
        $profiletest->singletestids = $singletestString;
        $profiletest->update();

        // LOG ACTIVITY STARTS HERE 
        $profiletestname = AllTests::where('id',$id)->select('testname')->first();
        $loguserid = Auth::user()->staff_id;
        $logbranchid = Auth::user()->branchid;
        $logurl = url()->current();
        $logip = request()->ip();
        $logmethod =  request()->method();
        $logagent = $request->header('User-Agent');
        $logsubject = "updated ".$profiletestname->testname." profile test";
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

        return redirect("profiletest")->with('profiletestsuccess',"Profile test updated successfully");
    }



/* PROFILE TEST SECTION ENDS HERE */

/* Normal range modal  */
    public function viewtest(Request $request)
    {
        $id = $request->id;
        // $test =Normalrange::where('id',$id)
        //         ->select('id','agefrom','ageto','generalrange','malerange','femalerange')
        //         ->first();
        $test = Normalrange::select('*')->where('id', $id)->first();  
                return Response($test);
    }
 /* Normal range edit  */   
    public function rangeedit(Request $request){
        $id = $request->input('hiddenid');
        $testid = $request->input('testid');
        $range=Normalrange::find($id);        
        $range->agefrom=$request->input('agefrom');
        $range->ageto=$request->input('ageto');
        $range->generalrange=$request->input('generalrange');
        $range->malerange=$request->input('malerange');
        $range->femalerange=$request->input('femalerange');
        $range->update();
        return redirect("update-singletest/".$testid);
    }
    
    /************************Update List****************/
     public function updateNormalRangeList(Request $request)
    {
            //dd($request->input('sid'));
            $id =  $request->input('sid'); 
            $normalranges                       = new Normalrange;
            $normalranges->singletest_id        = $id;
            $normalranges->lowertype            = $request->input('lowertype');
            $normalranges->agefrom              = $request->input('lowervalue');
            $normalranges->lowerchronological   = $request->input('lowerchronological');
            $normalranges->highertype           = $request->input('highertype');
            $normalranges->ageto                = $request->input('highervalue');
            $normalranges->higherchronological	= $request->input('higherchronological');
            $normalranges->malerange            = $request->input('malevalue');
            $normalranges->minmalevalue         = $request->input('minmalevalue');
            $normalranges->maxmalevalue         = $request->input('maxmalevalue');
            $normalranges->femalerange          = $request->input('femalevalue');
            $normalranges->minfemalevalue       = $request->input('minfemalevalue');
            $normalranges->maxfemalevalue       = $request->input('maxfemalevalue');
            $normalranges->status               = '1';
            $normalranges->save(); 
            
           // $res=Normalrange::where('singletest_id','=',$id)->get();
            return response()->json(['id' => $id]);
            
           
       
    }
    
    public function updateRangeList(Request $request)
    { 
        $id = $request->input('sid');
        //dd($id);
            $normalranges                       = Normalrange::find($id);
            $normalranges->lowertype            = $request->input('lowertype');
            $normalranges->agefrom              = $request->input('lowervalue');
            $normalranges->lowerchronological   = $request->input('lowerchronological');
            $normalranges->highertype           = $request->input('highertype');
            $normalranges->ageto                = $request->input('highervalue');
            $normalranges->higherchronological	= $request->input('higherchronological');
            $normalranges->malerange            = $request->input('malevalue');
            $normalranges->minmalevalue         = $request->input('minmalevalue');
            $normalranges->maxmalevalue         = $request->input('maxmalevalue');
            $normalranges->femalerange          = $request->input('femalevalue');
            $normalranges->minfemalevalue       = $request->input('minfemalevalue');
            $normalranges->maxfemalevalue       = $request->input('maxfemalevalue');
            $normalranges->update();
            
            $res=Normalrange::where('id','=',$id)->first();
            return response()->json(['id' => $res['singletest_id']]);
         
    }
/*******************************************************************************/

public function blocksingletest(Request $request, $id)
    {
        $singletest = AllTests::find($id);
        $singletest->status = '0';        
        $singletest->update();
        return redirect('singletest')->withSuccess('singletest blocked successfully');
    }
    public function singletestunblock(Request $request, $id)
    {
        $singletest = AllTests::find($id);
        $singletest->status = '1';        
        $singletest->update();
        return redirect('singletest')->withSuccess('singletest unblocked successfully');
    }
    
    
  public function blockprofiletest(Request $request, $id)
{
    $profiletest = AllTests::find($id);
    $profiletest->status = '0';        
    $profiletest->update();
    return redirect('profiletest')->withSuccess('Profile test blocked successfully');
}

public function profiletestunblock(Request $request, $id)
{
    $profiletest = AllTests::find($id);
    $profiletest->status = '1';        
    $profiletest->update();
    return redirect('profiletest')->withSuccess('Profile test unblocked successfully');
}

    
    



}
