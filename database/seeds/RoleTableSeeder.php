<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = new Role();
        $userRole->name = 'user';
        $userRole->description = 'A default user when registered';
        $userRole->save();

        $adminRole = new Role();
        $adminRole->name = 'admin';
        $adminRole->description = 'Admin user with super powers';
        $adminRole->save();
    }
}
