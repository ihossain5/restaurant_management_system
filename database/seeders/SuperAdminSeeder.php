<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'       => 'super admin',
            'email'      => 'superadmin@email.com',
            'password'   => 12345678,
            'is_super_admin' => 1,
        ]);
    }
}
