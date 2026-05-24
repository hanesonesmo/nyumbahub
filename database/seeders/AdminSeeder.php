<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Only create if doesn't exist
        Admin::firstOrCreate(
            ['email' => 'admin@nyumbahub.com'],
            [
                'name'     => 'NyumbaHub Admin',
                'email'    => 'admin@nyumbahub.com',
                'password' => Hash::make('Admin@1234'),
            ]
        );

        $this->command->info('✅ Default admin created: admin@nyumbahub.com / Admin@1234');
    }
}
