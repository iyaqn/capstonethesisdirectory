<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@ust.edu.com',
                'user_type' => 'admin',
                'studentNumber' => 'None',
                'user_course' => 'None',
                'password' => bcrypt('Adminpassword123')
            ],

            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane.doe@ust.edu.com',
                'user_type' => 'faculty',
                'user_course' => 'CS',
                'studentNumber' => 'None',
                'user_course' => 'None',
                'password' => bcrypt('Facultypassword123')
            ],
            [
                'first_name' => 'Janet',
                'last_name' => 'Doe',
                'email' => 'janet.doe@ust.edu.com',
                'user_type' => 'faculty',
                'user_course' => 'IT',
                'studentNumber' => 'None',
                'user_course' => 'None',
                'password' => bcrypt('Facultypassword123')
            ],
            [
                'first_name' => 'Janice',
                'last_name' => 'Doe',
                'email' => 'janice.doe@ust.edu.com',
                'user_type' => 'faculty',
                'user_course' => 'IS',
                'studentNumber' => 'None',
                'user_course' => 'None',
                'password' => bcrypt('Facultypassword123')
            ],

            [
                'first_name' => 'Joe',
                'last_name' => 'Doe',
                'email' => 'joe.doe.cics@ust.edu.com',
                'user_type' => 'student',
                'user_course' => 'CS',
                'studentNumber' => '2021000001',
                'password' => bcrypt('Studentpassword123')
            ],
            [
                'first_name' => 'Joel',
                'last_name' => 'Doe',
                'email' => 'joel.doe.cics@ust.edu.com',
                'user_type' => 'student',
                'user_course' => 'IT',
                'studentNumber' => '2021000002',
                'password' => bcrypt('Studentpassword123')
            ],
            [
                'first_name' => 'Josh',
                'last_name' => 'Doe',
                'email' => 'josh.doe.cics@ust.edu.com',
                'user_type' => 'student',
                'user_course' => 'IS',
                'studentNumber' => '2021000003',
                'password' => bcrypt('Studentpassword123')
            ],


        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
