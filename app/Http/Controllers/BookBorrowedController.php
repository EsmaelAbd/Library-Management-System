<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

class BookBorrowedController extends Controller
{
    public function send(Request $request)
    {
        $email['to'] = $request->to;
        $email['name'] = $request->name;
        $email['subject'] = $request->subject;
        $email['message'] = $request->message;

        SendEmailJob::dispatch($email);
    }
}
