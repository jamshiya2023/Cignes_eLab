<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use DB;
use Illuminate\Http\Request;
use Hash;
//use Mail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
  
   public function postforgotpassword33(Request $request)
    {
       $request->validate([
        'email' => 'required|email',
    ],
    [
     'email.required'=> 'Please enter your email address', 
     'email.email'=> 'Invalid email addresss! Please re-enter'
    ]
 );
 $email = $request->email;

 //$users = DB::table('users')->select('username','email')->where('email',$email)->get();
// $countQry = Admin::where('email','=',$email)->get();
 
$countQry = Admin::where('email','=',$request->email)->get();
$count = count($countQry);
 
if($count>0){
    $emailquery = Admin::select('username','email','password')->where('email','=',$request->email)->first();
    $usename = $emailquery->username;
    $dbemail = $emailquery->email;

 $pass = $emailquery->password;
   
} else {

   $dbemail ="null";
}
//$sdf =  Crypt::decrypt($pass); 
 //$sdf = Hash::decode($pass);
  // dd($dbemail);die();
 //$tomail = $dbemail;
    $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message){
         $message->to('kcsmithesh@gmail.com','Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('smithcignes@gmail.com','Virat Gandhi');
      });
	 // dd($dbemail);die();
	   echo "HTML Email Sent. Check your inbox.";
  
 if($dbemail == $email)
{
 
return redirect('confirm-password')->with('foremail',$request->email);



} else {

     
    return redirect("/")->withError('You do not have access');
}
 
    }
  
  
   public function postforgotpassword(Request $request) 
    {
       
    $request->validate([
        'email' => 'required|email',
    ],
    [
     'email.required'=> 'Please enter your email address', 
     'email.email'=> 'Invalid email addresss! Please re-enter'
    ]
 );
 $email = $request->email;

  
 
$countQry = Admin::where('email','=',$request->email)->get();
$count = count($countQry);
 
if($count>0){
    $emailquery = Admin::select('username','email')->where('email','=',$request->email)->first();
    $usename = $emailquery->username;
    $dbemail = $emailquery->email;


   
} else {

   $dbemail ="null";
}
 
 if($dbemail == $email)
{
  
return redirect('confirm-password')->with('foremail',$request->email);



} else {

    
 
    return redirect("/")->withError('You do not have access');
}
 
    }
    public function viewforgotpassword()
    {
        return view('forgotpassword');
    }

    public function postforgotpassword2(Request $request)
    {
      
    $request->validate([
        'useemail' => 'required|email',
    ],
    [
     'useemail.required'=> 'Please enter your email address', 
     'useemail.email'=> 'Invalid email addresss! Please re-enter'
    ]
 );

 
 

// dd($emailquery->username);
// 

$countQry = Admin::where('email','=',$request->useemail)->get();
$count = count($countQry);
//echo $count;
//exit();
//condotion
if($count>0){
    $emailquery = Admin::select('username')->where('email','=',$request->useemail)->first();
    $usename = $emailquery->username;
} else {
    $usename = '';

}



 if($usename ==='superadmin')
{
     //echo 'uesrname->'.$emailquery->username; exit();


//  return redirect()->intended('confirm-password');
return redirect('confirm-password')->with('foremail',$request->useemail);



} else {

    //echo "not worjking "; exit();
 
    return redirect("/")->withError('You do not have access');
}



 //$wordCount = count($emailquery);


// dd($emailquery);
// dd($username);



    //  dd($request->emailaddress);
    }

    public function viewconfirmpassword()
    {
        return view('confirmpassword');
    }

    
    public function updatepassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        ]);
        
        
         $useremail = $request->foremail;
         $userid = $request->userid;
         $confirmpass = $request->password;
         $newpassword = Hash::make($confirmpass);

         Admin::where('email', $useremail)
              ->where('id',$userid)
              ->update(['password' => $newpassword]);

             return redirect('/')->withSuccess('Your password updated successfully');


    }
    
    public function sendOtpEmail(Request $request)
{

     $request->validate([
        'email' => 'required',
    ],
    [
     'email.required'=> 'Please enter your email address',
    ]
    );
    
    $email = $request->input('email');
    
    $countQry = Admin::where('email','=',$email)->get();
    $count = count($countQry);
    //dd($countQry);
    if($count>0)
    {
        $emailquery = Admin::select('id')->where('email','=',$email)->first();
        $user_id = $emailquery->id;
        
        $otp = $this->generateOtp(); 
        $user = Admin::find($user_id);
        $user->otp = $otp; // Set the new name
        $user->save();
        // Replace with your OTP generation logic
        
        
        Mail::to($email)->send(new OtpMail($otp));
        
        return redirect("verify_otp")->withSuccess('OTP number sent successfully!');
        //return response()->json(['message' => 'OTP number sent successfully!']);
    }
    else
    {
         return redirect("forgot-password")->withError('Invalid email addresss! Please re-enter');
    }
}
private function generateOtp()
    {
        return rand(100000, 999999);
    }
    
    public function verify_otp()
    {
        return view('validate_otp');
    }

    public function verify_otp_num(Request $request)
    {
        
      $request->validate([
        'otp' => 'required',
    ],
    [
     'otp.required'=> 'Please enter a valid otp number',
    ]
    );
    
    $otp_num = $request->input('otp');
    $countQry = Admin::where('otp','=',$otp_num)->get();
    $count = count($countQry);
    //dd($countQry);
    if($count>0)
    {
        $emailquery = Admin::select('id','email')->where('otp','=',$otp_num)->first();
        $user_id = $emailquery->id;
        $email =  $emailquery->email;
        //dd($email);
         //return view('confirmpassword', ['user_id' => $user_id,'email'=>$email]);
        return redirect("confirm-password")->with(['user_id' => $user_id,'email'=>$email])->withSuccess('OTP number sent successfully!');
    }
    else
    {
        return redirect("verify_otp")->withError('Invalid OTP number! Please re-enter');
    }
    
    }
    
}
