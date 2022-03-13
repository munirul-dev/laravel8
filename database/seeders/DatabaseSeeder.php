<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to refresh the database?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed.');
        }

        Cache::tags(['blog-post'])->flush();
        $this->clearStorage();
        $this->call([
            UsersTableSeeder::class,
            BlogPostTableSeeder::class,
            CommentsTableSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class,
        ]);
    }

    public function clearStorage()
    {
        Storage::delete(Storage::allFiles('avatars'));
        Storage::delete(Storage::allFiles('thumbnails'));
    }
}
