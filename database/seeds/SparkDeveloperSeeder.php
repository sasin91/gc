<?php

use Illuminate\Database\Seeder;
use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Spark;

class SparkDeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Spark::$developers as $developer) {
            if (forward_static_call_array([\App\User::class, 'where'], ['email', $developer])->get()->isEmpty()) {
                $credentials = factory(Spark::userModel())->make(['email' => $developer])->toArray();
                $credentials['password'] = 'secret';
	
	            resolve(UserRepository::class)->create($credentials);
            }
        }
    }
}