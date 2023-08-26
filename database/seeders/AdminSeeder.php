<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'email'=> 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
        ]);
    }
}
