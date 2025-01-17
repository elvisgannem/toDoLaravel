<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'email' => 'admin@example.com',
                'password' => '123',
                'isAdmin' => true,
            ]);
        }

        User::factory(3)->create();
    }
}
