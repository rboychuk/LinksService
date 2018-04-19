<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Link;
use App\Site;

class MailReporter extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $sites = Site::get();
        $date  = date('Y-m-d');
        $links = [];

        foreach ($sites as $site) {
            $link = Link::where('site_id', $site->id)->whereDate('created_at', '=', $date)->get();
            if ($link->count()) {
                $links[$site->name] = $link->groupBy('creator');
            }
        }

        Mail::send('emails.reports', compact('links'), function ($message) use ($date) {
            $message->from('support@rental24h.com', 'Service');
            $message->subject('Report about new links for ' . $date);

            $message->to('alex101ki@gmail.com')->cc('alex_ki@ukr.net');
        });

    }
}
