<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CheckUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users and their password hashing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        
        $this->info('=== USER LIST ===');
        foreach ($users as $user) {
            $this->line("ID: {$user->id}");
            $this->line("Name: {$user->name}");
            $this->line("Email: {$user->email}");
            $this->line("Role: {$user->role}");
            $this->line("Password starts with: " . substr($user->password, 0, 10) . "...");
            $this->line("Is Bcrypt: " . (Hash::needsRehash($user->password) ? 'NO' : 'YES'));
            $this->line("Test password 'password': " . (Hash::check('password', $user->password) ? 'MATCH' : 'NO MATCH'));
            $this->line("---");
        }
        
        return 0;
    }
}
