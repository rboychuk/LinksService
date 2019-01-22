<?php

namespace App\Console\Commands;

use App\Link;
use App\Services\AhrefParserService;
use App\Services\MozLinkApiService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class UpdateAhrefs extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:ahrefs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $moz_service;

    protected $ahref_service;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->ahref_service = app(AhrefParserService::class);
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
                $this->ahref_service->parse($link->name, $link->link, $link->target_url, true);
            } catch (\Exception $e) {
            }
            $progress->advance();
        });
    }
}
