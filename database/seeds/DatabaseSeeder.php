<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('lh_users')->insert([
            'name' => 'xianfan',
            'email' => '1730249825@qq.com',
            'password' => '$2y$10$PvFMVxyswsoXI/JI0HH6cONNGxT18h/Wep.sdsbVynChEfLtX6y0S',
            'phone' => '18614006045',
            'sex' => '1',
            'auth' => '1',
            'pic'=>'/uploads/7d8d29a75e4002130b5a49d2549056b2.jpg'
        ]);
    }
}
