<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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

        $vietnameseDescriptions = [
            'Danh mục chứa các bài viết về công nghệ và lập trình hiện đại.',
            'Chia sẻ kiến thức và kinh nghiệm trong lĩnh vực công nghệ thông tin.',
            'Hướng dẫn và tips cho developers và những người yêu thích công nghệ.',
            'Cập nhật xu hướng mới nhất trong ngành IT và phần mềm.',
            'Bài viết chuyên sâu về các công nghệ và framework phổ biến.'
        ];

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
     * Indicate that the category is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
