<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\House;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;

class GuestController extends Controller
{
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

}

