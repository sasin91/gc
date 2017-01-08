<?php

use Illuminate\Database\Seeder;
use Laravel\Spark\Contracts\Interactions\Settings\Teams\CreateTeam;
use Laravel\Spark\Spark;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['name' => 'staff', 'slug' => 'staff'],
            //
        ];
        // First developer
        $user = collect(Spark::$developers)->flatMap(function ($email) {
            return \App\User::where('email', $email)->get();
        })->first();

        foreach ($teams as $team) {
            if (Spark::team()->all()->isEmpty()) {
                Spark::interact(CreateTeam::class, [
                    $user,
                    $team
                ]);
            }
        }
    }
}