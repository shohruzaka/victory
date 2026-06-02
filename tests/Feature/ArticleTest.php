<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_article_can_be_created(): void
    {
        $user = User::factory()->create();

        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'content' => 'This is a test article content.',
            'user_id' => $user->id,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
            'slug' => 'test-article',
            'user_id' => $user->id,
            'status' => 'published',
        ]);

        $this->assertInstanceOf(User::class, $article->user);
        $this->assertEquals($user->id, $article->user->id);
    }
}
