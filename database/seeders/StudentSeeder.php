<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Student::create([
            'name' => 'student1',
            'email' => 'student1@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'gender'=>'1',
            'status'=>'1',
            'age'=>'25',
            'phone'=>'0965845854',
            'created_by' => '1'
        ]);

        Student::create([
            'name' => 'student2',
            'email' => 'student2@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'gender'=>'0',
            'status'=>'0',
            'age'=>'20',
            'phone'=>'096566854',
            'created_by' => '1'
        ]);
    }
}
