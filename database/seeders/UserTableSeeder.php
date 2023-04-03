<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::create([
            'name' => 'test',
            'lastname' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'number_document' => '12345678',
            'type_document' => 'DNI',
            'birth_date' => Carbon::now()->format('Y-m-d'),
            'role' => 'admin'
        ]);
    }
}
