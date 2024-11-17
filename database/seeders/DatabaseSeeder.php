<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Emoji;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Post::factory()->create([
            'title' => 'The Simplest Method to Create a Vue.js Component Library',
            'slug' => 'the-simplest-method-to-create-a-vue-js-component-library',
        ]);

        Emoji::factory()->create([
            'name' => 'thumbs up',
            'emoji' => '👍',
        ]);

        Emoji::factory()->create([
            'name' => 'thumbs down',
            'emoji' => '👎',
        ]);
    }
}
