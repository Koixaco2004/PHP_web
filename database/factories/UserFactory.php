<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('vi_VN');
        $vietnameseNames = [
            'Nguyễn Văn An',
            'Trần Thị Bình',
            'Lê Văn Cường',
            'Phạm Thị Dung',
            'Hoàng Văn Em',
            'Vũ Thị Giang',
            'Ngô Văn Hùng',
            'Đặng Thị Lan',
            'Bùi Văn Minh',
            'Lý Thị Nga',
            'Trương Văn Phúc',
            'Đinh Thị Quỳnh',
            'Đỗ Văn Sơn',
            'Phan Thị Tâm',
            'Mai Văn Ước',
            'Chu Thị Vân',
            'Tô Văn Xuân',
            'Lưu Thị Yến',
            'Cao Văn Bảo',
            'Hồ Thị Cúc'
        ];

        return [
            'name' => $faker->randomElement($vietnameseNames),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'user']),
            'google_id' => null,
            'avatar' => null,
            'bio' => $faker->optional(0.5)->randomElement([
                'Tôi là một lập trình viên đam mê công nghệ.',
                'Yêu thích học hỏi và chia sẻ kiến thức về lập trình.',
                'Chuyên gia về phát triển web và ứng dụng di động.',
                'Blogger công nghệ và reviewer sản phẩm IT.',
                'Freelancer với nhiều năm kinh nghiệm trong ngành.'
            ]),
            'location' => $faker->optional(0.4)->randomElement([
                'Hà Nội',
                'Thành phố Hồ Chí Minh',
                'Đà Nẵng',
                'Hải Phòng',
                'Cần Thơ',
                'Vũng Tàu',
                'Nha Trang',
                'Huế',
                'Vinh',
                'Quy Nhon'
            ]),
            'website' => fake()->optional(0.2)->url(),
            'phone' => fake()->optional(0.3)->phoneNumber(),
            'date_of_birth' => fake()->optional(0.6)->dateTimeBetween('-60 years', '-18 years')?->format('Y-m-d'),
            'profile_views' => fake()->numberBetween(0, 1000),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the user should be a regular user.
     */
    public function user(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'user',
        ]);
    }


    /**
     * Indicate that the user has Google login.
     */
    public function withGoogle(): static
    {
        return $this->state(fn(array $attributes) => [
            'google_id' => fake()->uuid(),
            'avatar' => null,
        ]);
    }
}