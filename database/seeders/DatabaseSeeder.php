<?php

namespace Database\Seeders;

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
        // إنشاء حساب الإدمن
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@erp.com',
            'password' => Hash::make('password123'), // كلمة المرور
            'role' => 'admin',
            'status' => 'active',
            'job_title' => 'System Administrator',
        ]);
    }
}
