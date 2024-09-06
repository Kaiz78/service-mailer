<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class EmailController extends Controller
{
    public function sendEmailToQueue(Request $request)
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'), 
            env('RABBITMQ_PORT'), 
            env('RABBITMQ_USER'), 
            env('RABBITMQ_PASSWORD')
        );
        $channel = $connection->channel();


        $channel->queue_declare('email_queue', false, true, false, false);

        $data = json_encode($request->all());
        $msg = new AMQPMessage($data, array('delivery_mode' => 2));

        $channel->basic_publish($msg, '', 'email_queue');

        $channel->close();
        $connection->close();

        return response()->json(['message' => 'Email request sent to queue']);
    }


    // Test performance email queue
    public function sendEmailToQueuePerformance(Request $request)
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'), 
            env('RABBITMQ_PORT'), 
            env('RABBITMQ_USER'), 
            env('RABBITMQ_PASSWORD')
        );

        $channel = $connection->channel();
        $channel->queue_declare('email_queue', false, true, false, false);

        
        // créer 1 datas
        $data = json_encode($request->all());

        $msg = new AMQPMessage($data, array('delivery_mode' => 2));
        $channel->basic_publish($msg, '', 'email_queue');
    
        $channel->close();
        $connection->close();

        return response()->json(['message' => 'Email request sent to queue']);
    }


    public function getEmails()
    {

        $emails = Email::all();

        return response()->json($emails);
    }
}
