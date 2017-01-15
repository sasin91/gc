<?php

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\News::class)->times(10)->create()->each(function (App\News $news) {
        	$news->articles()
                 ->saveMany(factory(App\NewsArticle::class)->times(10)->make())
                 ->each(function (App\NewsArticle $article) {
                    $article->tags()->saveMany(factory(App\Tag::class)->times(5)->make());
                    $article->photos()->saveMany(factory(App\Photo::class)->times(2)->make());
                    $article->videos()->save(factory(App\Video::class)->make());
                });
            
        });

    }
}
