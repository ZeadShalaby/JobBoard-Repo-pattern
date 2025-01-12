<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $defAdmin = User::factory()->create([
            'name' => 'Admin',
            'username' => 'Admin Login',
            'gmail' => 'Admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);


        // ? todo add one customer //
        $defCustomer = User::factory()->create([
            'name' => 'Customer',
            'gmail' => 'customer@gmail.com',
            'password' => Hash::make('customer'),
        ]);

        // ? todo add user admin //
        $admins = User::factory()
            ->count(4)
            ->create();
        $admins->push($defAdmin);


        // ? todo add user customer //
        $customer = User::factory()
            ->count(19)
            ->create();
        $customer->push($defCustomer);

        // ? todo add job //
        Job::factory(10)->create();
    }
}
