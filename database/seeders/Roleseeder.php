<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles=['admin','pharmacist','driver','doctor','student','non student'];
        $create_date=date('Y-m-d H:i:s');
        foreach($roles as $role):
            DB::table('roles')->insert([
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => $create_date,
                'updated_at' => $create_date,
            ]);    endforeach;
    }
}
