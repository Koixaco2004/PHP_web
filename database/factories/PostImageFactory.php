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
        $unsplashImages = [
            'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1518186285589-2f7649de83e0?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1571171637578-41bc2dd41cd2?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
            'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&h=600&fit=crop&crop=center&auto=format&q=80',
        ];

        $imageUrl = fake()->randomElement($unsplashImages);

        return [
            'post_id' => Post::factory(),
            'image_url' => $imageUrl,
            'delete_url' => null,
            'alt_text' => fake()->randomElement([
                'Hình ảnh minh họa cho bài viết công nghệ',
                'Ảnh về lập trình và phát triển phần mềm',
                'Workspace của developer',
                'Công nghệ và innovation',
                'Team work và collaboration'
            ]),
            'caption' => fake()->optional(0.6)->randomElement([
                'Hình ảnh minh họa chủ đề bài viết',
                'Không gian làm việc hiện đại',
                'Công nghệ thay đổi cuộc sống',
                'Đội ngũ phát triển chuyên nghiệp',
                'Innovation và sáng tạo'
            ]),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_featured' => false,
            'file_size' => fake()->numberBetween(100000, 800000), // 100KB to 800KB
            'width' => 800,
            'height' => 600,
            'mime_type' => 'image/jpeg',
        ];
    }

    /**
     * Indicate that the image is featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
            'sort_order' => 0,
        ]);
    }

    /**
     * Create a small thumbnail image.
     */
    public function thumbnail(): static
    {
        return $this->state(fn(array $attributes) => [
            'width' => $this->faker->numberBetween(100, 300),
            'height' => $this->faker->numberBetween(100, 300),
            'file_size' => $this->faker->numberBetween(5000, 50000),
        ]);
    }
}
