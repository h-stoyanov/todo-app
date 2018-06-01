<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // We should create the Roles first, so we can use them in user creation
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
