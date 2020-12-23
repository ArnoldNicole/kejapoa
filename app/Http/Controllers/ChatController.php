<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Auth;
use App\Events\NewMessage;
use App\Http\Resources\User as UserResource;
use App\Notifications\NewContact;


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
    public function index(User $user)
    {
        $recipient = new UserResource($user); 
        $sender = new UserResource(auth()->user());      
        return view('profile.chat' , compact('recipient','sender'));
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
    //dd($request->user_id)   ;
            $data=request()->validate([           
           'message'=>['required','string'],
           'user_id'=>['required'],
           ]);
             //dd($data);
               if (User::find($data['user_id'])) {
               
              $message =  auth()->user()->messages()->create([
              	'from_user'=>auth()->user()->id,
              	'to_user'=>$data['user_id'],
              	'content'=>$data['message']
              ]);
              //dd($message->id);
             broadcast(new NewMessage($message))->toOthers();
               

            return $message->toJson();
               }else{
               	 abort(401,'The user you are trying to chat with doesn`t exist');
               }
               

           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //check if the user foloows the authenticated user, if false force follow
       $following = auth()->user()->contact->followers->contains($user);
      // dd( $following);
      if ($following==false) {
          $user->following()->toggle(auth()->user()->contact);
          $user->notify(new NewContact(auth()->user()));
              }      
      if ($user->id==auth()->user()->id) {
               abort(401,'You cant chat alone');
            }
       

    	if ($user) {    		
    		$messages = Message::where(function($query) use ($user) {
    		            $query->where('from_user', Auth::user()->id)->where('to_user', $user->id);
    		        })->orWhere(function ($query) use ($user) {
    		            $query->where('from_user', $user->id)->where('to_user', Auth::user()->id);
    		        })->orderBy('created_at', 'ASC')->limit(15)->get();

    		      //  dd($messages);
    		

    		

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
    	else{
    		abort(404,' The user you requested could not be found in our server.');
    	}
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

    public function findRecipient(User $user){
         return new UserResource($user);
    }
}
