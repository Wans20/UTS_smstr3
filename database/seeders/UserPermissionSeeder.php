<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()  {
        $user = User::where('email','wans200102@gmail.com')->first();
        if ($user){
            $user->assignRole('admin');
        }
        $user = User::where('email','test@gmail.com')->first();
        if ($user){
            $user->assignRole('member');
        }
    }
}
