<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
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
     
       $admin_info= [

            'name' => 'admin',
            'email' => 'admin@babcock.com',
            'phone' => '08169677397',
            'password' => Hash::make('password'),
            'email_verified_at'=>$create_date
       ];
        $user = User::create($admin_info);

       //assign role to user
       $user->assignRole('admin');
    }
}
