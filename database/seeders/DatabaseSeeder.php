<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enums\LeaveStatus;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء حساب الإدمن
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@erp-system.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'status' => 'active',
            'employee_number' => 'EMP-001',
            'job_title' => 'System Administrator',
            'department' => 'الإدارة العليا',
            'phone' => '0500000000',
            'national_id' => '1000000000',
            'gender' => 'male',
        ]);
        $this->command->info('تم إنشاء حساب الإدمن بنجاح.');

        $departmentsList = [
            'الموارد البشرية',
            'تقنية المعلومات',
            'المبيعات',
            'التسويق',
            'المالية والمحاسبة',
            'العمليات التشغيلية',
            'خدمة العملاء',
            'المشتريات والمخازن',
            'الشؤون القانونية',
            'الإدارة العامة'
        ];

        // 2. إنشاء 10 مشرفين
        User::factory(10)->create([
            'role' => 'supervisor',
            'department' => fn() => fake()->randomElement($departmentsList),
        ]);
        $this->command->info('تم إنشاء حسابات المشرفين بنجاح.');

        // 3. إعدادات التوليد الضخم للموظفين
        $totalEmployees = 1000;
        $chunkSize = 500;
        $loops = $totalEmployees / $chunkSize;

        $this->command->info("جاري توليد $totalEmployees موظف و 5000 تذكرة و 2500 إجازة...");
        $this->command->getOutput()->progressStart($loops);

        DB::disableQueryLog();

        for ($i = 0; $i < $loops; $i++) {
            $employees = User::factory($chunkSize)->create([
                'role' => 'employee',
                'department' => fn() => fake()->randomElement($departmentsList),
            ]);

            $ticketsData = [];
            $leavesData = [];

            foreach ($employees as $employee) {
                // 5 تذاكر لكل موظف
                for ($t = 0; $t < 5; $t++) {
                    $ticketsData[] = [
                        'user_id' => $employee->id,
                        'ticket_number' => 'REQ-' . Str::random(8),
                        'subject' => 'طلب دعم فني - ' . fake()->sentence(3),
                        'description' => fake()->paragraph(2),
                        'status' => fake()->randomElement(['open', 'in_progress', 'closed']),
                        'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                        'updated_at' => now(),
                    ];
                }

                // 2.5 إجازة لكل موظف (معدل) -> بعضهم 2 وبعضهم 3 عشان نوصل 2500
                $leaveCount = rand(2, 3);
                for ($l = 0; $l < $leaveCount; $l++) {
                    $startDate = fake()->dateTimeBetween('-1 year', '+1 month');
                    $endDate = (clone $startDate)->modify('+' . rand(1, 14) . ' days');

                    $leavesData[] = [
                        'user_id' => $employee->id,
                        'type' => fake()->randomElement(['annual', 'sick', 'emergency', 'unpaid']),
                        'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'reason' => fake()->sentence(4),
                        'created_at' => $startDate, // محاكاة لإنشاء الطلب في نفس وقت بدايته تقريباً
                        'updated_at' => now(),
                    ];
                }
            }

            // إدخال البيانات دفعات
            foreach (array_chunk($ticketsData, 1000) as $chunk) {
                Ticket::insert($chunk);
            }

            foreach (array_chunk($leavesData, 1000) as $chunk) {
                LeaveRequest::insert($chunk);
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info("\nتم توليد البيانات بنجاح! 🎉");
    }
}
