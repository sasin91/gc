<?php

use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ForumPost::class)
        ->times(5)->create()
        ->each(function ($post) {
            $post->photos()->save(factory(App\Photo::class)->make());
            $post->tags()->saveMany(factory(App\Tag::class)->times(5)->make());
        });
    }
}
