<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Auth;
use Session; 
use Validator; 
use Carbon\Carbon; 
use App\User;

class LoginController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;            
    }
	
		/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getRegister()
    {
       $user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
			return redirect()->intended('/');
		}
		$signals = $this->helpers->signals;
    	return view('register',compact(['user','signals']));
    }

    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getLogin(Request $request)
    {
       $user = null;
       $req = $request->all();
       $return = isset($req['return']) ? $req['return'] : '/';
		
		if(Auth::check())
		{
			$user = Auth::user();
			return redirect()->intended($return);
		}
		$signals = $this->helpers->signals;
    	return view('login',compact(['user','return','signals']));
    }


	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postLogin(Request $request)
    {
        $req = $request->all();
        #dd($req);
        
        $validator = Validator::make($req, [
                             'pass' => 'required|min:6',
                             'id' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             //return redirect()->back()->withInput()->with('errors',$messages);
             return redirect()->intended('login')->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			
         	$remember = true; 
             $return = isset($req['return']) ? $req['return'] : '/';
             
         	//authenticate this login
            if(Auth::attempt(['email' => $req['id'],'password' => $req['pass'],'status'=> "enabled"],$remember) || Auth::attempt(['phone' => $req['id'],'password' => $req['pass'],'status'=> "enabled"],$remember))
            {
            	//Login successful               
               $user = Auth::user();          
               # dd($user); 
				              
                  return redirect()->intended($return);
            }
			
			else
			{
				session()->flash("login-status","error");
				return redirect()->intended('login');
			}
         }        
    }


    
 
	
    public function postRegister(Request $request)
    {
        $req = $request->all();
        #dd($req);
        
        $validator = Validator::make($req, [
                             'pass' => 'required|confirmed',
                             'email' => 'required|email',                            
                             'phone' => 'required|numeric',
                             'fname' => 'required',
                             'lname' => 'required',
                             #'g-recaptcha-response' => 'required',
                           # 'terms' => 'accepted',
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             //dd($messages);
             
             return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
			 #dd($req);
            $req['role'] = "user";    
            $req['status'] = "enabled";           
            $req['verified'] = "user";  			
            
                       #dd($req);            

            $user =  $this->helpers->createUser($req); 
            #dd($user);
			
                                                    
             //after creating the user, send back to the registration view with a success message
             #$this->helpers->sendEmail($user->email,'Welcome To Disenado!',['name' => $user->fname, 'id' => $user->id],'emails.welcome','view');
             session()->flash("signup-status", "success");
             return redirect()->intended('/');
          }
    }

    
    public function getLogout()
    {
        if(Auth::check())
        {  
           Auth::logout();       	
        }
        
        return redirect()->intended('/');
    }

}