<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project\Project;
use Faker;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Admin',
            'email' => 'holomiadev@holomia.com',
            'password' => bcrypt('Acdb1234')
        ]);
        $user1->assignRole('administrator');
    }
}
