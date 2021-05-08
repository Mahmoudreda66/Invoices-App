<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Mahmoud Reda',
            'email' => 'mahmodreda219@gmail.com',
            'password' => bcrypt('01093668025'),
            'image' => '',
            'status' => 1
        ]);
    }
}
