<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {firstName : First name} {secondName : Second name} {email : Unique email} {password : Password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = new User();
        $user->username = $this->argument('firstName');
        $user->first_name = $this->argument('firstName');
        $user->second_name = $this->argument('secondName');
        $user->role_id = Role::where('name', 'admin')->first()->id;
        $user->email = $this->argument('email');
        $user->password = Hash::make($this->argument('password'));
        $user->save();
    }
}
