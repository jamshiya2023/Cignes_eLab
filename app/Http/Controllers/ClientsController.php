<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\AllTests;
use App\Models\ClientTestPrice;
use Illuminate\Database\QueryException;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use Carbon\Carbon;

class ClientsController extends Controller
{
   public function showMasterClientTestPrice()
    {
             
    if(Auth::check()){
             $singletest = AllTests::where('status','=',1)
            ->where('testtype','singletest')
            ->get();  
            $profiletest = AllTests::select('*')->where('status','=',1)->where('testtype','=','profiletest')->get();     
            return view('master_clients_prices', ['tests' => $singletest,'profile_test' =>$profiletest]);
        }
    
    return redirect("/")->withError('You do not have access');
    
           
    }
    
    public function showUpdatePricesForm($clientId)
    {
        $client = Client::findOrFail($clientId);
        $tests = AllTests::leftJoin('client_test_price', function ($join) use ($clientId) {
            $join->on('client_test_price.alltests_id', '=', 'alltests.id')
                ->where('client_test_price.client_id', '=', $clientId);
        })
        ->select('alltests.id', 'alltests.testname', 'alltests.primaryprice', 'client_test_price.price','client_test_price.id as price_id')
        ->get();
        
        return view('master_clients_prices', compact('client', 'tests'));
    }
    public function updatePrices(Request $request)
    {
        $currentTime = Carbon::now();
        $cid = $request->cid;
        $id =$request->client_price_id;
        $clientPrice = $request->client_price;
            try {
                    if(empty($id))
                    {
                        
                        if (empty($clientPrice)) {
                            $clientPrice = $request->original_price;
                        }
                    
                        $clients_price              = new ClientTestPrice;
                        $clients_price->client_id   = $request->cid;
                        $clients_price->alltests_id = $request->sid;
                        $clients_price->price       = $clientPrice;
                        $clients_price->updated_at  = $currentTime;
                        $clients_price->save();
                    }
                    else
                    {
                        $clients_price              = ClientTestPrice::find($id);
                        $clients_price->client_id   = $request->cid;
                        $clients_price->alltests_id = $request->sid;
                        $clients_price->price       = $clientPrice;
                        $clients_price->updated_at  = $currentTime;
                        $clients_price->update();
                    }
                
                    // Success message or further actions
                }
                catch (\Illuminate\Database\QueryException $exception) 
                {
                    
                    return response()->json(['status'=>false,'id' => $cid,'message' =>"Duplicate entry not possible"]);
                }
        
        return response()->json(['status'=>true,'id' => $cid]);
    }
    public function updatePricesAll(Request $request)
    {
        $data = $request->input('data');
        foreach ($data as $row) {
            $id = $row['id'];
            $testname = $row['testname'];
            $originalPrice = $row['originalPrice'];
            $clientPrice = $row['clientPrice'];
            $clientPriceId = $row['clientPriceId'];
            $cid =$row['cid'];
        }
    }
    public function viewclients()
    {

        if(Auth::check()){
            $clientss = Client::select('*')->get();
           // dd($clientss);
            return view('master_clients', ['clients' => $clientss]);
        }
    
    return redirect("/")->withError('You do not have access');
    }
    
    public function addclients(Request $request)

    {
      
        try {
            $clients = new Client;
            $clients->name = $request->name;
            $clients->name_arabic = $request->arabic_name;
            $clients->email = $request->email;
            $clients->phone = $request->phone;
            $clients->phone_code = $request->country_code;
            $clients->status = '1';
            $clients->save();
        
            return redirect('master-clients')->with('Clientsuccess', "Client added successfully");
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                if (strpos($e->getMessage(), 'clients_email_unique') !== false) {
                    // Duplicate entry for 'clients_email_unique' key
                    return redirect()->back()->with('Clienterror', 'Email already exists.');
                }
            } else {
                // Handle other query exceptions
                return redirect()->back()->with('Clienterror', 'An error occurred while adding the client.');
            }
        }
    
    }
    public function editClientview(Request $request)
    {
        $id = $request->id;
        $clients =Client::where('id',$id)
                  ->select('id','name','name_arabic','email','phone','phone_code')
                  ->first();
                  return Response($clients);
    }
    
    public function clientedit(Request $request){
        $id = $request->input('hiddenid');
        $clients=Client::find($id);
        
        $clients->name=$request->input('clientnameedit');
        $clients->name_arabic=$request->input('arabic_nameedit');
        $clients->email=$request->input('email_edit');
        $clients->phone=$request->input('phone_edit');
        $clients->phone_code=$request->input('country_code_edit');
        $clients->update();
        return redirect("master-clients")->with('Clientsuccess', "Client updated successfully");
    }
    public function blockClient(Request $request,$id)
    {
         $clients = Client::find($id);
         $clients->status = '0';
         $clients->update();
         return redirect("master-clients")->with('Clientsuccess', "Client blocked successfully");
    }
    public function unblockClient(Request $request,$id)
    {   
         $clients= Client::find($id);
         $clients->status = '1';
         $clients->update();
         return redirect("master-clients")->with('Clientsuccess', "Client Unblocked successfully");
    }


}
