<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Rules\Adult;

class AgentController extends Controller
{

    public function __construct(){
        $this->middleware(['auth','landlord']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data=$this->validate($request, [
                'username'=>['required','string','exists:users','unique:agents'],
                'email'=>['required','string','email','exists:users','unique:agents'],
                'gender'=>['required','string'],
                'dateOfBirth'=>['required','date','before:today', 'before:-18 years'],
                'salary'=>['required','numeric','min:1000', 'max:100000'],
        ]);
        if ($data['email'] == auth()->user()->email || $data['username'] == auth()->user()->username) {
            return "You cant exist as both a landlord and an agent";
        }
        auth()->user()->agents()->create($data);
        return auth()->user()->agents;

        
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
    public function show()
    {
        return auth()->user()->agents;
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
    public function update(Request $request, $id)
    {
        //
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
}
