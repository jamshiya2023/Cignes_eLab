<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterInsurance;

class InsuranceController extends Controller
{
    public function viewinsurancelist()
    {
    
            $insurance = MasterInsurance::all();

    	 	
    	return view('insursncelist',['insurance'=>$insurance]);
    }

		   

    public function addinsurance(Request $request)
    {
        $insurance = MasterInsurance::all();
    	$insurance= new MasterInsurance;
    	// $insurance->id=$request->id;
        $insurance->insurance_name = $request->name;
         $insurance->insurance_namear = $request->namear;
        $insurance->status='1';
 
 
 $insurance->save();


 return redirect('Insurance')->with('Insurancesuccess', "Insurance added successfully");

}

public function block(Request $request, $id)
    {
        $city = MasterInsurance::find($id);
        $city->status = '0';        
        $city->update();
        return redirect("Insurance")->withSuccess('Insurance blocked successfully');
    }

    public function unblock(Request $request, $id)
    {
        $city = MasterInsurance::find($id);
        $city->status = '1';        
        $city->update();
        return redirect("Insurance")->withSuccess('Insurance unblocked successfully');
    }

public function editinsuranceview(Request $request)
{

    $id = $request->id;
	// Fetch the insurance record from the database based on the $id parameter
    $insurance = MasterInsurance::find($id);

    // Return the view with the insurance record data
    //return view('view-master-insurance', ['insurance' => $insurance]);
	 // $id = $request->id;
   // $insurance =MasterInsurance::where('id',$id)
   //            ->select('id','insurance_name')
   //            ->get();
              
    // $insurance = MasterInsurance::where('id',$id)
    // ->select('country','state')
    // ->first();
     $datas['insurance'] = $insurance->insurance_name;
      $datas['insurancear'] = $insurance->insurance_namear;
     $datas['insurance_id'] = $insurance->id;
                       
    return Response($datas);

    }


    public function insuranceedit(Request $request)
    {
        //dd($request);
    	 $id = $request->input('sampleidss');
        $insurance=MasterInsurance::find($id);
    // dd($request);
        $insurance->insurance_name=$request->input('nameedit');
    $insurance->insurance_namear=$request->input('nameeditar');
    $insurance->update();
    return redirect("Insurance")->withSuccess('Insurance update successfully');
}
    }

