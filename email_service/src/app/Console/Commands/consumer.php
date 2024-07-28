<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class consumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            getenv('RABBITMQ_HOST'), 
            getenv('RABBITMQ_PORT'), 
            getenv('RABBITMQ_USER'), 
            getenv('RABBITMQ_PASSWORD')
        );
        $channel = $connection->channel();
        
        $channel->queue_declare('email_queue', false, true, false, false);
        
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        
        
        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            // Traitement du message et envoi de l'email
            Email::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'message' => $data['message'],
            ]);
        
        echo '<pre>';
        print_r($data);
            echo ' [x] Message processed ', "\n";
        };
        
        $channel->basic_consume('email_queue', '', false, true, false, false, $callback);
        
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        
        $channel->close();
        $connection->close();
        
    }
}
