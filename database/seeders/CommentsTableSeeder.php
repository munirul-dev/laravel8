<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();
        if ($posts->count() === 0) {
            $this->command->error("There are no blog posts to seed comments to.");
            return;
        } else {
            $commentsCount = (int)$this->command->ask('How many comments do you want to generate?', 150);
            $users = User::all();
            Comment::factory($commentsCount)->make()->each(function ($comment) use ($posts, $users) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
        }
    }
}
