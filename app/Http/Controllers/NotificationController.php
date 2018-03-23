<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationController extends Controller
{
    
	public function index()
	{
		$notif 	= Notification::myNotif(Auth::id());
		Notification::watched(Auth::id());
		$oper 	= [
			'notif'	=> $notif,
		];
		return view('notifications.index', $oper);
	}

}
