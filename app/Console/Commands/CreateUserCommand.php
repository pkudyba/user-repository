<?php

namespace App\Console\Commands;

use App\Services\UserServiceInterface;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates user';

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
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->secret('Please enter user password.');
        $userService->createUser($name, $email, $password);

        $this->info('User was created');
        return 0;
    }
}
