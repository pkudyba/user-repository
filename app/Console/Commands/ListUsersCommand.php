<?php

namespace App\Console\Commands;

use App\Services\UserServiceInterface;
use Illuminate\Console\Command;

class ListUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list {pageNumber} {--nameFilter=} {--emailFilter=} {--orderColumn=} {--orderDirection=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List users';

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
        $name = $this->option('nameFilter');
        $email = $this->option('emailFilter');
        $orderColumn = $this->option('orderColumn') ?? 'id';
        $orderDirection = $this->option('orderDirection') ?? 'asc';
        $pageNumber = $this->argument('pageNumber');
        $users = $userService->listUsers($name, $email, $orderColumn, $orderDirection, $pageNumber);

        $users = collect($users->items())->map(function($item){
           return $item->toArray();
        });
        $this->table(['id', 'name', 'email', 'pass', 'created_at', 'updated_at', 'is_active'],
            $users
        );
        return 0;
    }
}
