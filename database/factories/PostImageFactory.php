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
     * Định nghĩa trạng thái mặc định của model PostImage.
     * Tạo dữ liệu giả với hình ảnh từ Unsplash và thông tin liên quan.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Danh sách các URL hình ảnh từ Unsplash với kích thước và chất lượng được tối ưu hóa
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
            // Caption được tạo với xác suất 60% để tạo dữ liệu đa dạng
            'caption' => fake()->optional(0.6)->randomElement([
                'Hình ảnh minh họa chủ đề bài viết',
                'Không gian làm việc hiện đại',
                'Công nghệ thay đổi cuộc sống',
                'Đội ngũ phát triển chuyên nghiệp',
                'Innovation và sáng tạo'
            ]),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_featured' => false,
        ];
    }

    /**
     * Đánh dấu hình ảnh là ảnh nổi bật.
     * Đặt thứ tự hiển thị cao nhất (0) để ưu tiên trong danh sách.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
            'sort_order' => 0,
        ]);
    }

    /**
     * Tạo cấu hình cho hình ảnh thumbnail.
     * Được sử dụng khi cần phiên bản thu nhỏ của hình ảnh gốc.
     */
    public function thumbnail(): static
    {
        return $this->state(fn(array $attributes) => []);
    }
}
