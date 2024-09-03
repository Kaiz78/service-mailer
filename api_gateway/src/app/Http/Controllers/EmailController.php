<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $response = Http::post(env('MAILER_SERVICE_URL') . 'api/send-email', $request->all());
        return response()->json(['message' => 'Email request sent', 'response' => $response->json()]);
    }

    public function getEmails()
    {        
        $response = Http::get(env('MAILER_SERVICE_URL'). 'api/emails');
        return response()->json($response->json());
    }
}