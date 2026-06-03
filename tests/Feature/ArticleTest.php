<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Subject;
use App\Models\Topic;
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

    public function test_an_article_can_belong_to_a_topic(): void
    {
        $user = User::factory()->create();
        $subject = Subject::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $topic = Topic::create([
            'subject_id' => $subject->id,
            'name' => 'Eloquent',
            'slug' => 'eloquent',
        ]);

        $article = Article::create([
            'title' => 'Eloquent Basics',
            'slug' => 'eloquent-basics',
            'content' => 'Learn basic eloquent queries.',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('articles', [
            'title' => 'Eloquent Basics',
            'topic_id' => $topic->id,
        ]);

        $this->assertInstanceOf(Topic::class, $article->topic);
        $this->assertEquals($topic->id, $article->topic->id);
        $this->assertTrue($topic->articles->contains($article));
    }
}
