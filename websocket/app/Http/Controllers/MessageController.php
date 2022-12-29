<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class MessageController extends Controller
{
    public function messageList($id, Request $request){
        $user_id = $request->user_id;
        $messages = Message::where(function($q) use($id, $user_id){
            $q->where('user_id', $user_id)->where('listener', $id);
        })->orWhere(function($q) use($id, $user_id){
            $q->where('user_id', $id)->where('listener', $user_id);
        })->get();
        return response()->json($messages);
    }

    public function messageStore($id, Request $request){
        $message = Message::create([
            'message' => $request->message,
            'user_id' => $request->user_id,
            'listener' => $id,
        ]);
        Event(new NewMessage($message));
        $user_id = $request->user_id;
        $messages = Message::where(function($q) use($id, $user_id){
            $q->where('user_id', $user_id)->where('listener', $id);
        })->orWhere(function($q) use($id, $user_id){
            $q->where('user_id', $id)->where('listener', $user_id);
        })->get();
        return response()->json($messages);
    }
}
