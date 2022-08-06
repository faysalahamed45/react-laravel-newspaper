<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'Sudip',
            'mobile' => '01712960833',
            'email' => 'palash.sudip@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'status' => 'Active',
        ]);

        $admin->assignRole('Super Admin');
    }
}
