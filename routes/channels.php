<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Message;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('messenger.{id}', function ($user, $id) {
//     return $user->id===Message::find($id)->to_user; 
// });
Broadcast::channel('chat', function ($user) {
  return Auth::check();
});
Broadcast::channel('post.{id}', function ($user, $id) {
    return true;
});

