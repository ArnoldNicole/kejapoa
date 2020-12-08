<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function contact_page(Request $request){
		//return $request;
		//dd($request);
    	return view('contact.contact');
    }

}

