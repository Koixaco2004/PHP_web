<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        $isPublished = $this->faker->boolean(70); // 70% published
        
        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(8, true),
            'excerpt' => $this->faker->paragraph(3),
            'status' => $isPublished ? 'published' : 'draft',
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'view_count' => $this->faker->numberBetween(0, 5000),
            'like_count' => $this->faker->numberBetween(0, 500),
            'comment_count' => $this->faker->numberBetween(0, 50),
            'is_featured' => $this->faker->boolean(15), // 15% featured
            'allow_comments' => $this->faker->boolean(90), // 90% allow comments
            'meta_data' => [
                'seo_title' => $this->faker->sentence(4),
                'seo_description' => $this->faker->paragraph(2),
                'keywords' => $this->faker->words(5),
            ],
            'published_at' => $isPublished ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
        ];
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the post is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the post is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the post is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
        ]);
    }
}
