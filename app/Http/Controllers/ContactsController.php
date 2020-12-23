<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Resources\Contact;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return auth()->user()->contact()->toggle($user->contact);
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
    public function show()
    {        
         
          return response()->json(auth()->user()->contact->followers);        
     
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
    public function updateNotice(Request $request)
    {
       $notice = auth()->user()->notifications->where('id',$request->id)->first();
       $notice->markAsRead();
       return;
    }

    /**
     * get the notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notice()
    {
        return auth()->user()->unreadNotifications;
    }
     public function loadAllNotifications(){
        return auth()->user()->notifications;
     }
}
