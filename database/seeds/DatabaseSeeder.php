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
    	$this->call(SparkDeveloperSeeder::class);
    	$this->call(TeamsTableSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(ForumSeeder::class);
        $this->call(ChatSeeder::class);
    }
}
