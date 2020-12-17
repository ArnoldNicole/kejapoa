<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Auth;
use App\Events\NewMessage;



class ChatController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.userProfile');
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
            $data=request()->validate([           
           'message'=>['required','string'],
           'user_id'=>['required'],
           ]);
             //dd($data);
               $receiver=User::findorfail($data['user_id']);
               $chat=new Message;
               
               $chat->to_user=$receiver->id;
               $chat->from_user=auth()->user()->id;
               //$chat->status='Unread';
               $chat->content=$data['message'];

               $chat->save();

             broadcast(new NewMessage($chat));//->toOthers();
               

            return $chat->toJson();

           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        $messages = Message::where(function($query) use ($user) {
                    $query->where('from_user', Auth::user()->id)->where('to_user', $user->id);
                })->orWhere(function ($query) use ($user) {
                    $query->where('from_user', $user->id)->where('to_user', Auth::user()->id);
                })->orderBy('created_at', 'ASC')->limit(50)->get();

              //  dd($messages);
        if ($user->id==auth()->user()->id) {
           $error=['message'=>'You can`t chat alone'];
           return response()->json($error);
        }

       

        foreach ($messages as $message ) {
            $message=[
                   'content'=>$message->content,
                   'from'=>$message->from_user,
                   'to'=>$message->to_user,
                   'created_at'=>$message->created_at->diffForHumans(),
            ];        
        }
        


        return response()->json($messages); //view('chats.chat', compact('messages','user'));
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
