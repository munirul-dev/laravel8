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
        $post = $this->createDummyBlogPost();
        $numberOfComments = 4;
        Comment::factory()->count($numberOfComments)->create(['blog_post_id' => $post->id]);

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

        $this->post('/posts', $params)
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

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ];

        $this->put("/posts/{$post->id}", $params)
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
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content'
        ]);
    }

    private function createDummyBlogPost(): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'Test title';
        // $post->content = 'Test content';
        // $post->save();
        return BlogPost::factory()->custom()->create();
        // return $post;
    }
}
