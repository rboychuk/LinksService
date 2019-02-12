<?php

namespace App\Console\Commands;

use App\Domain;
use App\Http\Controllers\LinkController;
use App\Link;
use Illuminate\Console\Command;
use App\User;

class UpdateUniqueDomains extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:domains';

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

        Domain::truncate();

        $links = Link::orderBy('created_at')->get();

        $link_c = app(LinkController::class);

        foreach ($links as $link) {

            $user = User::where('email', $link->creator)->first();

            $d = $link_c->updateDomains([
                'search_url' => $link->link,
                'site_id'    => $link->site_id,
                'user_id'    => $user->id
            ]);

            $link->domain_id = $d->id;

            if ($d->dublicate) {
                $link->dublicate_domain = true;
            }

            $link->save();

        }

    }
}
