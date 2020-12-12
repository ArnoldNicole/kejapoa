<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudinary;
use App\Http\Resources\User as UserResource;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user();
        return view('profile.userProfile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->file);
        $data = $this->validate($request, [
            'file'=>['required','image']
        ]);
        //dd($data);
        $imageName = time().'.'.$request->file->extension();
        // $request->file->move(public_path('profiles'), $imageName);
        $uploadedFileUrl = Cloudinary::upload($request->file('file')->getRealPath())->getSecurePath();
        auth()->user()->profile_image = $uploadedFileUrl; //'/profiles/'.$imageName;
        auth()->user()->save();       
        return $uploadedFileUrl;
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function location(Request $request)
    {

        $lat= -1.2713984;
         //$request->lat;
        $long = 36.85744640000001;
        //$request->long;
        //return $lat;
            $service_url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&key={AIzaSyBn5MgwK80_rI1D8TL1u272jEkCvQHdNeY}';
             $curl = curl_init($service_url);
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($curl, CURLOPT_POST, false);
             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
             $curl_response = curl_exec($curl);
             curl_close($curl);
             return $json_object=json_decode($curl_response);
            //return  $json_objekat;
    }

    public function user(){
        return new UserResource(auth()->user());
    }
}
