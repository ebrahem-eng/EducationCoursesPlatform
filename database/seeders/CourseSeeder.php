<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Course::create([
            'name' => 'Java Script',
            'code' => 'qweJ',
            'status' => '1',
            'status_publish' => '1',
            'change_status_by'=> '1',
            'rejected_cause' => 'something to try'
        ]);

        Course::create([
            'name' => 'C++',
            'code' => 'qweC+',
            'status' => '0',
            'status_publish' => '0',
            'change_status_by'=> '1',
            'rejected_cause' => 'something to try'
        ]);

        Course::create([
            'name' => 'Node.JS',
            'code' => 'qweJS',
            'status' => '1',
            'status_publish' => '0',
            'change_status_by'=> '1',
            'rejected_cause' => 'something to try'
        ]);

        Course::create([
            'name' => 'PHP',
            'code' => 'qweP',
            'status' => '0',
            'status_publish' => '0',
            'change_status_by'=> '1',
            'rejected_cause' => 'something to try'
        ]);
    }
}
