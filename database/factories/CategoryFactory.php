<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * CategoryFactory - Tạo dữ liệu giả cho mô hình Category
 * 
 * Lớp này tạo ra các bản ghi danh mục với dữ liệu tiếng Việt, bao gồm tên,
 * mô tả, màu sắc và trạng thái kích hoạt ngẫu nhiên để sử dụng trong testing.
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Định nghĩa trạng thái mặc định của mô hình
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Danh sách các chủ đề danh mục tiếng Việt
        $vietnameseCategories = [
            'Công nghệ blockchain',
            'Phát triển game',
            'Marketing số',
            'An toàn thông tin',
            'Internet of Things',
            'Cloud Computing',
            'Big Data',
            'Kỹ thuật phần mềm',
            'Thương mại điện tử',
            'Fintech'
        ];

        // Danh sách các mô tả danh mục tiếng Việt
        $vietnameseDescriptions = [
            'Danh mục chứa các bài viết về công nghệ và lập trình hiện đại.',
            'Chia sẻ kiến thức và kinh nghiệm trong lĩnh vực công nghệ thông tin.',
            'Hướng dẫn và tips cho developers và những người yêu thích công nghệ.',
            'Cập nhật xu hướng mới nhất trong ngành IT và phần mềm.',
            'Bài viết chuyên sâu về các công nghệ và framework phổ biến.'
        ];

        // Tạo tên danh mục bằng cách kết hợp chủ đề với số ngẫu nhiên để đảm bảo tính đa dạng
        $name = $this->faker->randomElement($vietnameseCategories) . ' ' . $this->faker->numberBetween(1, 100);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 1000),
            'description' => $this->faker->randomElement($vietnameseDescriptions),
            'color' => $this->faker->hexColor(),
            'is_active' => $this->faker->boolean(80),
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Đặt trạng thái danh mục thành kích hoạt
     * 
     * @return static
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Đặt trạng thái danh mục thành không kích hoạt
     * 
     * @return static
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
