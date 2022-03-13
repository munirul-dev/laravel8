<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostWhenNotingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No posts found.');
    }

    public function testSeeOneBlogPostWhenThereIsOneWithNoComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('Test title');
        $response->assertSeeText('No comments yet');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);
    }

    public function testSeeOneBlogPostWhenThereIsOneWithComments()
    {
        // Arrange
        $user = $this->user();
        $post = $this->createDummyBlogPost();
        $numberOfComments = 4;
        Comment::factory()->count($numberOfComments)->create([
            'commentable_id' => $post->id,
            'commentable_type' => BlogPost::class,
            'user_id' => $user->id
        ]);

        // Act
        $response = $this->get('/posts');
        $response->assertSeeText(`${numberOfComments} comments`);

        // Assert
        // $response->assertSeeText('Test title');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail()
    {

        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ]);
    }

    public function testDelete()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');

        // $this->assertDatabaseMissing('blog_posts', [
        //     'title' => 'Test title',
        //     'content' => 'Test content'
        // ]);

        $this->assertSoftDeleted('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);
    }

    private function createDummyBlogPost($userId = null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'Test title';
        // $post->content = 'Test content';
        // $post->save();
        return BlogPost::factory()->custom()->create([
            'user_id' => $userId ?? $this->user()->id
        ]);
        // return $post;
    }
}
