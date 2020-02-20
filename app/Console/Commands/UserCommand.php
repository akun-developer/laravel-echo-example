<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email}';

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
        try {
            $name = explode('@', $this->argument('email'));
            User::create(['name' => $name[0], 'email' => $this->argument('email'), 'password' => bcrypt('test')]);
            $this->info($this->argument('email') . ' created');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }

    }
}
