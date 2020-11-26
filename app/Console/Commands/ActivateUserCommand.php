<?php

namespace App\Console\Commands;

use App\Services\UserServiceInterface;
use Illuminate\Console\Command;

class ActivateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:activate {userId} {active}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activates or deactivates user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(UserServiceInterface $userService)
    {
        $userId = $this->argument('userId');
        $active = $this->argument('active');
        $active = $active === 'true';
        $userService->activation($userId, $active);

        if($active){
            $this->info('User was activated');
            return 0;
        }
        $this->info('User was deactivated');
        return 0;
    }
}
