<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $tags = Tag::all();

        $post = Post::factory()->create([
            'id' => Str::Uuid(),
            'user_id' => $user->id,
        ]);

        $randomTags = $tags
            ->random(rand(1, min(3, $tags->count())))
            ->pluck('id')
            ->toArray();

        $post->tags()->sync($randomTags);
    }
}
