<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('departments')->insert([
            'id' => 1,
            'name' => 'Administrator',
            'en_name' => 'Administrator',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);

        \DB::table('admins')->insert([
            'id' => 1,
            'department_id' => 1,
            'name' => 'Laravel',
            'username' => 'admin@demo.com',
            'email' => 'admin@demo.com',
            'dial_code' => '91',
            'mobile' => '9999999999',
            'password' => \Hash::make("123456"),
            'status' => 1,
            'locale' => 'en',
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' =>  date('Y-m-d H:i:s')
        ]);
    }
}
