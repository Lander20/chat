<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return Message::with('user')->get();
    }

    public function store(){
        $user = Auth::user();

        if(isset(request()->file)){
            $path = str_replace('public/','',request()->file->store('public/files'));
        }

        $message = $user->messages()->create([
            'message' => request()->message,
            'file' => $path ?? '',
            'type' => request()->type
        ]);



        broadcast(new MessageSent($user, $message));
    }

}
