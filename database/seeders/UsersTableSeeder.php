<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = max((int)$this->command->ask('How many users do you want to generate?', 20), 1);
        User::factory()->custom()->create();
        User::factory($usersCount - 1)->create();
    }
}
