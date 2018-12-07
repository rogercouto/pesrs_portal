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
            'name' => 'Cláucia',
            'email' => 'clauciapessoa@gmail.com',
            'password' => bcrypt('uab4778'),
        ]);
        /*
        $this->call(PostTableSeeder::class);
        $this->call(MessageSeeder::class);
         */
    }
}
