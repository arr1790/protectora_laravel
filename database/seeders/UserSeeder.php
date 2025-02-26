<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // Usuario ADMINISTRADOR
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@softui.com',
            'email_verified_at' => now(),
            'location'=> 'Lima',
            'phone' => '123456789',
            'password' => Hash::make('secret'),
             'type' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

         // Usuario NORMAL
         DB::table('users')->insert([
            'id' => 13,
            'name' => 'user',
            'email' => 'user@softui.com',
            'email_verified_at' => now(),
            'phone' => '685565235',
            'location'=> 'Lima',
            'password' => Hash::make('user'),
            'type' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::factory(10)->create();
    

    DB::table('users')->insert([
        'id' => 3,
        'name' => 'ana',
        'email' => 'ana@softui.com',
        'email_verified_at' => now(),
        'location'=> 'Lima',
        'phone' => '123456789',
        'password' => Hash::make('secret1'),
         'type' => 0,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    }
}
