<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostImage>
 */
class PostImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'image_url' => $this->faker->imageUrl(800, 600, 'business'),
            'delete_url' => null, // Usually set by external service
            'alt_text' => $this->faker->sentence(4),
            'caption' => $this->faker->optional(0.6)->paragraph(1),
            'sort_order' => $this->faker->numberBetween(0, 10),
            'is_featured' => false, // Will be set specifically
            'file_size' => $this->faker->numberBetween(50000, 2000000), // 50KB to 2MB
            'width' => $this->faker->numberBetween(400, 1920),
            'height' => $this->faker->numberBetween(300, 1080),
            'mime_type' => $this->faker->randomElement(['image/jpeg', 'image/png', 'image/webp']),
        ];
    }

    /**
     * Indicate that the image is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'sort_order' => 0,
        ]);
    }

    /**
     * Create a small thumbnail image.
     */
    public function thumbnail(): static
    {
        return $this->state(fn (array $attributes) => [
            'width' => $this->faker->numberBetween(100, 300),
            'height' => $this->faker->numberBetween(100, 300),
            'file_size' => $this->faker->numberBetween(5000, 50000),
        ]);
    }
}
