<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('uabre4778ti'),
        ]);
        /*
        $this->call(PostTableSeeder::class);
        $this->call(MessageSeeder::class);
         */
    }
}
