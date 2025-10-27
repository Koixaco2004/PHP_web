<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Khởi tạo dữ liệu ban đầu cho cơ sở dữ liệu.
     * 
     * Tạo người dùng admin, người dùng test, danh mục, bài viết, hình ảnh và bình luận
     * để chuẩn bị môi trường phát triển và kiểm thử.
     */
    public function run(): void
    {
        // Tạo tài khoản admin
        $admin = User::factory()->create([
            'name' => 'Quản trị viên',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Tạo tài khoản người dùng thử nghiệm
        $testUser = User::factory()->create([
            'name' => 'Người dùng thử nghiệm',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Tạo 28 người dùng ngẫu nhiên (20 + 5 + 3)
        User::factory()->count(20)->create();
        User::factory()->count(5)->create();
        User::factory()->count(3)->withGoogle()->create();

        // Danh sách danh mục được định nghĩa sẵn với màu sắc tương ứng
        $categories = [
            ['name' => 'Phát triển Web', 'color' => '#22c55e'],
            ['name' => 'Phát triển Mobile', 'color' => '#16a34a'],
            ['name' => 'Thiết kế UI/UX', 'color' => '#15803d'],
            ['name' => 'Khoa học dữ liệu', 'color' => '#166534'],
            ['name' => 'DevOps', 'color' => '#14532d'],
            ['name' => 'Trí tuệ nhân tạo', 'color' => '#22c55e'],
        ];

        // Tạo các danh mục được định nghĩa sẵn với slug, thứ tự và trạng thái
        foreach ($categories as $index => $categoryData) {
            Category::factory()->create(array_merge($categoryData, [
                'slug' => Str::slug($categoryData['name']),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]));
        }

        // Tạo 4 danh mục ngẫu nhiên bổ sung
        Category::factory()->count(4)->create();

        $categories = Category::all();
        $users = User::all();

        // Tạo bài viết, hình ảnh và bình luận cho từng danh mục
        foreach ($categories as $category) {
            $postCount = rand(5, 10);

            for ($i = 0; $i < $postCount; $i++) {
                // Tạo bài viết và gán cho danh mục và người dùng ngẫu nhiên
                $post = Post::factory()->create([
                    'category_id' => $category->id,
                    'user_id' => $users->random()->id,
                ]);

                // Tạo từ 1-3 hình ảnh cho mỗi bài viết
                $imageCount = rand(1, 3);
                $postImages = [];
                for ($j = 0; $j < $imageCount; $j++) {
                    $postImages[] = PostImage::factory()->create([
                        'post_id' => $post->id,
                        'is_featured' => $j === 0,
                        'sort_order' => $j,
                    ]);
                }

                // Thay thế placeholder trong nội dung bài viết bằng HTML hình ảnh thực tế
                $content = $post->content;
                foreach ($postImages as $index => $image) {
                    $placeholder = '{{POST_IMAGE_' . $index . '}}';
                    $imageHtml = '<figure class="my-6">';
                    $imageHtml .= '<img src="' . $image->image_url . '" alt="' . ($image->alt_text ?? 'Hình ảnh minh họa') . '" class="w-full rounded-lg shadow-lg">';
                    $imageHtml .= '<figcaption class="text-center text-sm text-gray-600 mt-2">' . ($image->caption ?? 'Hình ảnh minh họa cho nội dung bài viết') . '</figcaption>';
                    $imageHtml .= '</figure>';

                    $content = str_replace($placeholder, $imageHtml, $content);
                }

                // Xóa các placeholder chưa được thay thế
                $content = preg_replace('/\{\{POST_IMAGE_\d+\}\}/', '', $content);

                $post->update(['content' => $content]);

                // Tạo 0-10 bình luận cho mỗi bài viết, và 30% bình luận có câu trả lời
                $commentCount = rand(0, 10);
                for ($k = 0; $k < $commentCount; $k++) {
                    $comment = Comment::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $users->random()->id,
                    ]);

                    if (rand(1, 100) <= 30) {
                        Comment::factory()->create([
                            'post_id' => $post->id,
                            'user_id' => $users->random()->id,
                            'parent_id' => $comment->id,
                        ]);
                    }
                }

                // Cập nhật số lượng bình luận của bài viết
                $post->update(['comment_count' => $post->comments()->count()]);
            }
        }

        // Đánh dấu 5 bài viết đã được phê duyệt gần đây làm nổi bật
        Post::published()->inRandomOrder()->limit(5)->update(['is_featured' => true]);
    }
}
