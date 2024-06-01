<?php

namespace App\Console\Commands;

use App\Models\RegisterLink;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOverdueRegisterLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:overdue-register-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete overdue registration link';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $twoDaysAgo = Carbon::now()->subDays(2);
        RegisterLink::where('created_at', '<', $twoDaysAgo)->delete();
        $this->info('Overdue data deleted successfully.');
        return 0;
    }
}
