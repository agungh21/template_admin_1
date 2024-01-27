<?php

namespace App\Console\Commands;

use App\Models\CampaignTarget;
use Illuminate\Console\Command;

class InitBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init_broadcast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim Broadcast';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CampaignTarget::sendBroadcast();
    }
}
