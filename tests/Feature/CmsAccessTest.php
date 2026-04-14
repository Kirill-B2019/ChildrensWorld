<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_email_can_open_cms_routes(): void
    {
        $admin = User::factory()->create(['email' => env('ADMIN_EMAIL', 'test@test.com')]);
        $user = User::factory()->create(['email' => 'user@example.com']);

        $this->actingAs($admin)->get('/dashboard/content/pages')->assertOk();
        $this->actingAs($user)->get('/dashboard/content/pages')->assertForbidden();
    }

    public function test_blog_page_uses_database_posts_when_available(): void
    {
        $post = Post::create([
            'slug' => 'db-post',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $post->translations()->createMany([
            ['locale' => 'en', 'title' => 'DB Post Title', 'excerpt' => 'DB excerpt'],
            ['locale' => 'ru', 'title' => 'RU title', 'excerpt' => 'RU excerpt'],
            ['locale' => 'kg', 'title' => 'KG title', 'excerpt' => 'KG excerpt'],
        ]);

        $this->get('/')->assertOk();
        $this->get('/en/blog')->assertOk()->assertSee('DB Post Title');
    }
}
