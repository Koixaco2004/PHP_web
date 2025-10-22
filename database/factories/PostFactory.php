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
        $vietnameseTitles = [
            'Hướng dẫn học lập trình từ cơ bản đến nâng cao',
            'Các công nghệ mới nhất trong phát triển web',
            'Tips và tricks để tối ưu hóa website',
            'Kinh nghiệm làm việc với framework Laravel',
            'Cách xây dựng ứng dụng mobile hiệu quả',
            'Thiết kế UI/UX thân thiện với người dùng',
            'Tìm hiểu về trí tuệ nhân tạo và machine learning',
            'DevOps và việc triển khai ứng dụng tự động',
            'Bảo mật thông tin trong phát triển phần mềm',
            'Xu hướng công nghệ năm 2025',
            'Cách tối ưu hóa SEO cho website',
            'Phân tích dữ liệu với Python và R',
            'Xây dựng API RESTful chuyên nghiệp',
            'Microservices và kiến trúc phần mềm hiện đại',
            'Cloud computing và các dịch vụ AWS'
        ];
        
        $vietnameseContent = [
            'Trong thời đại công nghệ số hiện nay, việc nắm vững các kỹ năng lập trình trở nên vô cùng quan trọng.',
            'Để trở thành một lập trình viên giỏi, bạn cần không ngừng học hỏi và cập nhật kiến thức mới.',
            'Framework Laravel đã trở thành một trong những công cụ phổ biến nhất cho phát triển web PHP.',
            'Thiết kế giao diện người dùng đóng vai trò then chốt trong thành công của một ứng dụng.',
            'Việc tối ưu hóa hiệu suất website giúp cải thiện trải nghiệm người dùng đáng kể.',
            'Trí tuệ nhân tạo đang thay đổi cách chúng ta làm việc và sinh hoạt hàng ngày.',
            'DevOps giúp tăng tốc độ phát triển và triển khai phần mềm một cách hiệu quả.',
            'Bảo mật thông tin là ưu tiên hàng đầu trong mọi dự án phát triển phần mềm.',
        ];
        
        $title = $this->faker->randomElement($vietnameseTitles) . ' ' . $this->faker->numberBetween(1, 1000);
        $isPublished = $this->faker->boolean(70); // 70% published
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'content' => implode("\n\n", $this->faker->randomElements($vietnameseContent, $this->faker->numberBetween(3, 6))),
            'excerpt' => $this->faker->randomElement($vietnameseContent),
            'status' => $isPublished ? 'published' : 'draft',
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'view_count' => $this->faker->numberBetween(0, 5000),
            'comment_count' => $this->faker->numberBetween(0, 50),
            'is_featured' => $this->faker->boolean(15), // 15% featured
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
}
