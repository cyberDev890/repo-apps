<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'IT Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::updateOrCreate(['email' => 'viewer@example.com'], [
            'name' => 'Staff Viewer',
            'password' => Hash::make('password'),
            'role' => 'viewer',
        ]);

        $this->call([
            CategorySeeder::class,
            WorkUnitSeeder::class,
        ]);
    }
}
