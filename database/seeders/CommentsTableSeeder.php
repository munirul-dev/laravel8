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
        $users = User::all();

        if ($posts->count() === 0 || $users->count() === 0) {
            $this->command->error("There are no blog posts or users to seed comments to.");
            return;
        } else {
            $commentsCount = (int)$this->command->ask('How many comments do you want to generate?', 150);
            Comment::factory($commentsCount)->make()->each(function ($comment) use ($posts, $users) {
                $comment->commentable_id = $posts->random()->id;
                $comment->commentable_type = BlogPost::class;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
            Comment::factory($commentsCount)->make()->each(function ($comment) use ($users) {
                $comment->commentable_id = $users->random()->id;
                $comment->commentable_type = User::class;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
        }
    }
}
