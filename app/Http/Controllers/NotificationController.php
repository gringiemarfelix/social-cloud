<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        return view('notifications', [
            'notifications' => auth()->user()->notifications()->latest()->paginate(10)
        ]);
    }
}
