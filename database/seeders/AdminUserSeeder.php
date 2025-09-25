<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Angélica Alessio',
            'username' => 'angelica.alessio',
            'password' => \Hash::make('compras@acdrt'),
            'is_admin' => true
        ]);
    }
}
