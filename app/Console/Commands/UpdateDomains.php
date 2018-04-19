<?php

namespace App\Console\Commands;

use Faker\Provider\DateTime;
use Illuminate\Console\Command;
use App\Site;
use App\Domain;

class UpdateDomains extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:domain {site}';

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
        $site_name = $this->argument('site');

        $site = Site::where('name', $site_name)->first();

        try {
            $csv = array_map('str_getcsv', file(public_path($site_name . '.csv')));
        } catch (\Exception $e) {
            $this->info($e);
        }

        if (count($csv)) {
            if (is_null($site)) {
                $site       = new Site();
                $site->name = $site_name;
                $site->save();
            }
            foreach ($csv as $item) {
                if (is_null(Domain::where('domain', $item[0])->first())) {
                    $domain             = new Domain();
                    $domain->site_id    = $site->id;
                    $domain->domain     = array_shift($item);
                    $date               = strtotime(array_pop($item));
                    $domain->created_at = date('Y-m-d H:i:s', $date);
                    $domain->save();
                }
            }
        }


    }
}
