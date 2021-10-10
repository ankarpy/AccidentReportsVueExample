<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Report;


class UsersReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create()->each(function($u) {
        $u->reports()
            ->saveMany(
                Report::factory(rand(1,5))->make()
            );

    });
    }
}
