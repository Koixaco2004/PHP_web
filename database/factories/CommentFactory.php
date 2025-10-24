<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vietnameseComments = [
            'Bài viết rất hay và bổ ích! Cảm ơn tác giả đã chia sẻ.',
            'Tôi đã học được rất nhiều điều từ bài viết này.',
            'Hướng dẫn rất chi tiết và dễ hiểu. Tôi sẽ áp dụng ngay.',
            'Có thể chia sẻ thêm về phần này được không?',
            'Cảm ơn bạn đã giải thích rất rõ ràng.',
            'Mình có thử làm theo nhưng gặp lỗi này, bạn có thể giúp không?',
            'Bài viết chất lượng, đáng để bookmark.',
            'Rất hữu ích cho người mới bắt đầu như mình.',
            'Bạn có thể làm thêm video hướng dẫn không?',
            'Thanks bạn nhiều, đã giải quyết được vấn đề của mình.',
            'Nội dung hay, trình bày dễ hiểu.',
            'Mình đã share bài viết này cho team dev.',
            'Có source code mẫu không bạn?',
            'Bài viết đúng thời điểm mình cần.',
            'Chờ bài viết tiếp theo của bạn.'
        ];

        return [
            'content' => $this->faker->randomElement($vietnameseComments),
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'parent_id' => null,
        ];
    }

    /**
     * Create a reply comment.
     */
    public function reply(): static
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => Comment::factory(),
            'content' => $this->faker->paragraph(2), // Shorter replies
        ]);
    }
}
