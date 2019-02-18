<?php

namespace App\Console\Commands;

use App\Link;
use App\Notifications\SlackNotification;
use App\Site;
use App\User;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class CheckExpensiveLinks extends Command
{

    use Notifiable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expensive_links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $client;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }


    public function routeNotificationForSlack()
    {
        return config('services.slack.webhook');
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $links = Link::where('price', '>', 5)->get();

        $broken = $this->brokenLinks($links);

        if ($broken) {

            $broken->filter(function ($link) {
                $site = Site::find($link->site_id)->first();
                $this->notify(new SlackNotification($site->name, $link->link));
            });

        }
    }


    protected function brokenLinks(Collection $links)
    {

        $links = $links->filter(function ($link) {

            $status_code = $this->client->head($link->link)->getStatusCode();

            return $status_code != 200;

        });

        return $links->count() ? $links : false;

    }
}
