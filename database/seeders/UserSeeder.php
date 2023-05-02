<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Statement;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin10'),
            'birthdate' => Carbon::now()->subYears(rand(20, 50))->format('Y-m-d'),
            'role' => 'admin'
        ]);

        $clients = User::factory()->count(10)->create(['role' => 'client']);

        foreach ($clients as $client) {
            Statement::factory()->count(rand(1, 3))->create([
                'user_id' => $client->id,
            ]);
        }


    }
}
