<?php

namespace App\Console\Commands;

use App\Link;
use App\Services\AhrefParserService;
use App\Services\MozLinkApiService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class UpdateMetrics extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:metrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $moz_service;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->moz_service = app(MozLinkApiService::class);
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $links = Link::join('sites', 'sites.id', '=', 'site_id')->get();

        $progress = new ProgressBar($this->output, $links->count());

        $links->map(function ($link) use ($progress) {
            try {
                $this->moz_service->getMetrics($link->link, true);
            } catch (\Exception $e) {
            }
            $progress->advance();
        });
    }
}
