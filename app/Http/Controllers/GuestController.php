<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\House;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\HelpMessage;

class GuestController extends Controller
{
    public function index(){
        $featuredHouses = House::orderBy('created_at','DESC')->with('images')->get();
        return view('welcome', compact('featuredHouses'));
    }
    public function contact_page(Request $request){
		//return $request;
		//dd($request);
    	return view('contact.contact');
    }

    public function newLandlord(){
    	if (Auth::check()) {
    		return redirect('/profile');
    	}
    	return view('guest.newLandlord');
    }

    public function create_Landlord(Request $request){
        $data = $this->validate($request, [
            'name'=>['required', 'string', 'max:255'],
            'username'=>['required', 'string', 'max:255','unique:users'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],               
            'password'=>['required', 'string', 'min:8', 'confirmed'],
            'krapin'=>['required', 'string', 'max:255','unique:users'],            
        ]);

       $user =  User::create([
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'is_landlord'=>1,
                    'krapin'=>$data['krapin'],
                    'profile_image'=>'/img/default.png',
                    'password' => Hash::make($data['password']),
                    
        ]);

       $credentials = $request->only('email', 'password');
       Auth::attempt($credentials);
       $request->session()->regenerate();
       return redirect()->intended('/profile');
    }

    public function find(Request $request){      
    $query= $this->validate($request, [
        'query'=>['required']
    ]);
    //dd($query['query']);  
    $houses = House::search($query['query'])->get();
    return $houses;

    }

    public function viewHouse (House $house){
        $house=$house;
        //dd($house);
        return view('guest.houseTour', compact('house'));
    }

    public function explore(Image $image){
         return view('guest.show', compact('image'));
    }

    public function assitant(Request $request){
        //get the vallue of the chat_session cookie
        $value = $request->cookie('chat_session');        
        if ($value!='') { 
        //if cookie is available
           $data = $this->validate($request,[
                'message'=>'required|string|min:10',
            ]);
           //get the name and email from the cookie
           $details = json_decode($value);           
           //return $details;
           $message = HelpMessage::create([
            'name'=>$details->name,
            'email'=>$details->email,
            'message'=>$data['message'],
           ]);

           return $message;

        }else{
            //if cookie is missing, just create a new one
            $data = $this->validate($request,[
                'name'=>'required|string|min:3',
                'email'=>'required|string|min:5',
                'message'=>'required|string|min:10',
            ]);
            //store the message
            $message = HelpMessage::create([
             'name'=>$data['name'],
             'email'=>$data['email'],
             'message'=>$data['message'],
            ]);
            //create a cookie
            $response = new Response('Message Sent');
            $json = json_encode([
                'name'=>$data['name'],
                'email'=>$data['email'],
            ]);
            $response->withCookie(cookie('chat_session', $json, 20));
            return $response;          
        }       
    }

}

