<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $create_date=date('Y-m-d H:i:s');
     
       //create admin
        $admin = User::create([

            'name' => 'admin',
            'email' => 'admin@babcock.com',
            'phone' => '08169677397',
            'password' => Hash::make('password'),
            'email_verified_at'=>$create_date
       ]);

       //assign admin role to user
       $admin->assignRole('admin');


       //create doctor
       $doctor = User::create([

        'name' => 'doctor',
        'email' => 'doctor@babcock.com',
        'phone' => '08157879845',
        'password' => Hash::make('password'),
        'email_verified_at'=>$create_date
   ]);

   //assign doctor role to user
   $doctor->assignRole('doctor');

   //create pharmacy
   $pharmacy = User::create([

    'name' => 'pharmacy',
    'email' => 'pharmacy@babcock.com',
    'phone' => '08197879835',
    'password' => Hash::make('password'),
    'email_verified_at'=>$create_date
]);

//assign pharmacist role to user
$pharmacy->assignRole('pharmacist');

  
   //create driver
   $driver = User::create([
    'name' => 'driver',
    'email' => 'driver@babcock.com',
    'phone' => '08107879831',
    'password' => Hash::make('password'),
    'email_verified_at'=>$create_date
]);

//assign driver role to user
$driver->assignRole('driver');

 //create student patient
 $student = User::create([
    'name' => 'student',
    'email' => 'student@babcock.com',
    'phone' => '08177879832',
    'patient_no'=>'Buth'.str_shuffle('0123456').mt_rand(99,999),
    'password' => Hash::make('password'),
    'email_verified_at'=>$create_date
]);

//assign student role to user
$student->assignRole('student');

 //create non student patient
 $nonstudent = User::create([
    'name' => 'Non Student',
    'email' => 'nonstudent@babcock.com',
    'phone' => '08157871834',
    'patient_no'=>'Buth'.str_shuffle('0123456').mt_rand(99,999),
    'password' => Hash::make('password'),
    'email_verified_at'=>$create_date
]);

//assign non student role to user
$nonstudent->assignRole('non student');

    }


}
