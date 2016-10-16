<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function basic_email(){    	
      $data = array('name'=>"Virat Gandhi");
   
      Mail::send('mail.mails.welcome', $data, function($message) {
         $message->to('brinthamohanan17@gmail.com', 'Tutorials Point')->subject
            ('Confirmation Mail');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Basic Email Sent. Check your inbox.";
   }
}
