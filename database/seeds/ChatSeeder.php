<?php

use App\ChatMessage;
use App\ChatRoom;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(ChatRoom::class)->create()->messages()->saveMany(
    		factory(ChatMessage::class)->times(10)->make()
    	);
    }
}
