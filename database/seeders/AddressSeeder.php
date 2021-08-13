<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function($user) {
            Address::factory(2)->create(['user_id' => $user->id]);
        });
    }
}
