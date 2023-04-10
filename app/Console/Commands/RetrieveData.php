<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RetrieveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retrieve-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieving data from Open AI API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Prepare request data...');
        $url = 'https://api.openai.com/v1/chat/completions';
        $OPENAI_API_KEY = env('OPENAI_API_SECRET');
        $data = [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Напиши ми тренировъчна програма, за ниво напреднал, 
                            с тегло 80 кг, ръст 180 см, разделена на различни фази и с продължителност 3 месеца"
                    ]
                ]
        ];

        $response = Http::timeout(1060)
            ->acceptJson()
            ->withToken($OPENAI_API_KEY)
            ->post($url, $data)->body();

        $content = json_decode($response);
        $this->info('Request is done...');

        try {
            Log::info($content->choices[0]->message->content);
            Log::info('-------------------------------------');
        } catch (\Throwable $th) {
            Log::info('Something went wrong...');
        }
    }
}
