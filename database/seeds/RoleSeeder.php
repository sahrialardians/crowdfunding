<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'id'=> Str::uuid(),
                'name'=> 'admin',
            ],
            [
                'id'=> Str::uuid(),
                'name'=> 'user',
            ],
        ]);
    }
}
