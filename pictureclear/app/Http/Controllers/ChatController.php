<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Course;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;



class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'BelongsToChat']);
    }
    
    public function showChat(Request $request, $id){
        $chat = DB::select("SELECT * FROM chats WHERE id =".$id);
        $senderId=0;
        if($senderId==$chat[0]->teacher_id) $senderId = $chat[0]->student_id;
        else $senderId = $chat[0]->teacher_id;

        $sentMessages = DB::select("SELECT * from Messages WHERE chat_id = ?", [$id]);
        $sender = DB::select("SELECT * FROM users WHERE id = ?", [$senderId]);

        return view('chat', [
            'user' => Auth::user(),
            'chatId' => $chat,
            'presentChatId' => $id,
            'sentMessages' => $sentMessages,
            'sender' => $sender[0]]
        );
    }

    public function messageSent(Request $request, $id){
        

        $request->validate([
                        
        ]);
        Message::insert(array(
            'user_id' => Auth::user()->id,
            'chat_id' => $id,
            'message' => $request['message'],
            'sentOn' => now(),
        ));

        


        return back();
    }

    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

   
}