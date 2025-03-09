<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class InactiveUsersDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:delete_inactive_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleting the inactive users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Are you sure you want to delete all inactive users?')) {
            $deletedCount = User::where('active', '0')->delete();

            if ($deletedCount > 0) {
                $this->info("$deletedCount inactive users deleted successfully.");
            } else {
                $this->warn('No inactive users found.');
            }
        } else {
            $this->error('Operation canceled.');
        }
    }

}
