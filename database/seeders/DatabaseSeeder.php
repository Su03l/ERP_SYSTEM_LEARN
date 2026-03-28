<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import Str facade for UUID

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء حساب الإدمن أولاً
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@erp.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
            'job_title' => 'System Administrator',
        ]);

        $this->command->info('تم إنشاء حساب الإدمن بنجاح.');

        // 2. إعدادات التوليد الضخم
        $chunkSize = 1000; // نولد 1000 موظف في كل دفعة عشان ما نقتل الرام
        $totalEmployees = 200000; // إجمالي الموظفين
        $employeesWithLeaves = 50000; // اللي عندهم إجازات

        $loops = $totalEmployees / $chunkSize; // المجموع 200 دفعة (200000 / 1000)

        $this->command->info('جاري توليد 650,000 سجل (موظفين، تذاكر، إجازات)...');
        $this->command->getOutput()->progressStart($loops); // تشغيل شريط التحميل

        // إيقاف تسجيل الاستعلامات في الذاكرة لتسريع العملية بشكل جنوني
        DB::disableQueryLog();

        for ($i = 0; $i < $loops; $i++) {
            // توليد 1000 موظف
            $employees = User::factory($chunkSize)->create([
                'role' => 'employee',
                'status' => 'active',
            ]);

            $ticketsData = [];
            $leavesData = [];

            // تجهيز التذاكر والإجازات في مصفوفات (Arrays) لعمل Bulk Insert
            foreach ($employees as $employee) {
                // كل موظف له تذكرتين
                $ticketsData[] = [
                    'user_id' => $employee->id,
                    'ticket_number' => 'TKT-' . Str::random(8), // Added ticket_number
                    'subject' => 'طلب دعم فني - ' . rand(100, 999),
                    'description' => 'وصف المشكلة التقنية هنا...',
                    'status' => rand(0, 1) ? 'open' : 'closed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $ticketsData[] = [
                    'user_id' => $employee->id,
                    'ticket_number' => 'TKT-' . Str::random(8), // Added ticket_number
                    'subject' => 'استفسار عن النظام - ' . rand(100, 999),
                    'description' => 'وصف الاستفسار هنا...',
                    'status' => rand(0, 1) ? 'open' : 'closed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // أول 50 ألف موظف فقط نعطيهم طلب إجازة واحد
                // (بما أن كل لفة فيها 1000، يعني أول 50 لفة فقط)
                if ($i < ($employeesWithLeaves / $chunkSize)) {
                    $leavesData[] = [
                        'user_id' => $employee->id,
                        'type' => 'annual', // عدل النوع حسب اللي عندك في الداتا بيس
                        'status' => 'pending',
                        'start_date' => now()->addDays(rand(1, 10)),
                        'end_date' => now()->addDays(rand(11, 20)),
                        'reason' => 'إجازة سنوية',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // إدخال التذاكر بدفعة واحدة (أسرع بـ 100 مرة من create العادية)
            foreach (array_chunk($ticketsData, 1000) as $chunk) {
                Ticket::insert($chunk);
            }

            // إدخال الإجازات بدفعة واحدة
            if (!empty($leavesData)) {
                foreach (array_chunk($leavesData, 1000) as $chunk) {
                    LeaveRequest::insert($chunk);
                }
            }

            // تحديث شريط التحميل
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info("\nتم تدمير الداتا بيس بنجاح بـ 650,000 سجل! 🚀");
    }
}
