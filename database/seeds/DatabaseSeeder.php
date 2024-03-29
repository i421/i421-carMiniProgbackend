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
        $this->call(OauthClientTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(AddressTableSeeder::class);
    }
}
