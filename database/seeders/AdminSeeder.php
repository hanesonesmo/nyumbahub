<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@nyumbahub.com'],
            [
                'name'     => 'NyumbaHub Admin',
                'email'    => 'admin@nyumbahub.com',
                'password' => Hash::make('Admin1234'),
            ]
        );

        $this->command->info('✅ Default admin created: admin@nyumbahub.com / Admin1234');
    }
}
