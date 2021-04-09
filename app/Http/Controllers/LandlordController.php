<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;


class LandlordController extends Controller
{
    public function __construct()
    {
    	return $this->middleware('landlord');
    }
    public function getHouses(){
    	return auth()->user()->houses;
    }
    public function create(Request $request){
		$this->validate($request, [
			'house_name'=>['required','string','unique:houses'],
			'geo_location'=>['required','string'],
			'status'=>['required','string'],
			'rooms'=>['required','string'],
			'condition'=>['required','string'],
			'description'=>['required','string','min:30'],
			'rent_amount'=>['required','string'],
            'iconImage'=>['required','string'],
		]);

    	$house =  auth()->user()->houses()->create([
    		'house_name'=>$request->house_name,
    		'geo_location'=>$request->geo_location,
    		'status'=>$request->status,
    		'rooms'=>$request->rooms,
    		'condition'=>$request->condition,
    		'description'=>$request->description,
    		'rent_amount'=>$request->rent_amount,
            'iconImage'=>$request->iconImage,
    	]);
    	return $house;
    }

        public function editHouse(Request $request){
        	$this->validate($request, [
        		'house_name'=>['required'],
        		//'geo_location'=>$request->geo_location,
        		//'status'=>$request->status,
        		'rooms'=>['required'],
        		'condition'=>['required'],
        		'description'=>['required'],
        		'rent_amount'=>['required']
        	]);
    		return House::where('id', $request->id)->update([
    		'house_name'=>$request->house_name,
    		//'geo_location'=>$request->geo_location,
    		//'status'=>$request->status,
    		'rooms'=>$request->rooms,
    		'condition'=>$request->condition,
    		'description'=>$request->description,
    		'rent_amount'=>$request->rent_amount
    		]);
    }
    public function update(Request $request){
            $data = $this->validate($request, [                
                'phone_number'=>['required','numeric','digits:10','starts_with:07,01,08'],
                'postal_box'=>['required','string','numeric'],
                'postal_code'=>['required','string','numeric'],
                'town'=>['required','string','min:3'],
            ]);
             auth()->user()->contact()->update($data);
            return $data;

    }
}
