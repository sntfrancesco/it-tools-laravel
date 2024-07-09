<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OtherUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $otherUser = User::factory()->create([
            //'email' => 'user@backend.com',
            'password' => bcrypt('SecurePassword')
        ]);
        $otherUser->assignRole('user_backend');
    }
}
