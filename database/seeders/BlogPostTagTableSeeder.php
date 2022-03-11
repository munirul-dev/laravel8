<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $posts = BlogPost::all();
        $tagCount = Tag::all()->count();

        if ($tagCount == 0) {
            $this->command->warn("There are no tags found to be tagged to a blog post. Skipping seeding.");
            return;
        } else {
            $howManyMin = (int)$this->command->ask('What is the minimum number of tags you want to assign to a single blog post?', 0);
            $howManyMax = min((int)$this->command->ask('What is the maximum number of tags you want to assign to a single blog post?', $tagCount), $tagCount);
            BlogPost::all()->each(function (BlogPost $post) use ($howManyMin, $howManyMax) {
                $take = random_int($howManyMin, $howManyMax);
                $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
                $post->tags()->sync($tags);
            });
        }
    }
}
