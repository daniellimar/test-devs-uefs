<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->tag = Tag::factory()->create();
    }

    public function test_can_list_posts(): void
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $post->id]);
    }

    public function test_can_create_post(): void
    {
        $payload = [
            'user_id' => $this->user->id,
            'title' => 'Novo Post',
            'content' => 'Conteúdo do post',
            'tags' => [$this->tag->id],
        ];

        $response = $this->postJson('/api/posts', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Novo Post']);
        $this->assertDatabaseHas('posts', ['title' => 'Novo Post']);
    }

    public function test_can_update_post(): void
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $payload = [
            'title' => 'Post Atualizado',
            'content' => 'Conteúdo atualizado',
            'tags' => [$this->tag->id],
        ];

        $response = $this->putJson("/api/posts/{$post->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Post Atualizado']);
        $this->assertDatabaseHas('posts', ['title' => 'Post Atualizado']);
    }

    public function test_can_delete_post(): void
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
