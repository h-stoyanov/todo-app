<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('name', 'user')->first();
        $adminRole = Role::where('name', 'admin')->first();

        $user = new User();
        $user->name = 'User';
        $user->email = 'user@user.com';
        $user->password = Hash::make('password');
        $user->save();
        $user->roles()->attach($userRole);

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('toornimda');
        $admin->save();
        $admin->roles()->attach($adminRole);
        $admin->roles()->attach($userRole);
    }
}
