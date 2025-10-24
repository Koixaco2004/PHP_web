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
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Quản trị viên',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create test user
        $testUser = User::factory()->create([
            'name' => 'Người dùng thử nghiệm',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create additional users
        User::factory()->count(20)->create();
        User::factory()->count(5)->create();
        User::factory()->count(3)->withGoogle()->create();

        // Create categories with predefined data using primary color shades
        $categories = [
            ['name' => 'Phát triển Web', 'color' => '#22c55e', 'icon' => 'fas fa-laptop-code'], // primary-500
            ['name' => 'Phát triển Mobile', 'color' => '#16a34a', 'icon' => 'fas fa-mobile-alt'], // primary-600
            ['name' => 'Thiết kế UI/UX', 'color' => '#15803d', 'icon' => 'fas fa-palette'], // primary-700
            ['name' => 'Khoa học dữ liệu', 'color' => '#166534', 'icon' => 'fas fa-chart-line'], // primary-800
            ['name' => 'DevOps', 'color' => '#14532d', 'icon' => 'fas fa-cogs'], // primary-900
            ['name' => 'Trí tuệ nhân tạo', 'color' => '#22c55e', 'icon' => 'fas fa-lightbulb'], // primary-500
        ];

        foreach ($categories as $index => $categoryData) {
            Category::factory()->create(array_merge($categoryData, [
                'slug' => Str::slug($categoryData['name']),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]));
        }

        // Create additional random categories
        Category::factory()->count(4)->create();

        // Create posts
        $categories = Category::all();
        $users = User::all();

        foreach ($categories as $category) {
            // Create 5-10 posts per category
            $postCount = rand(5, 10);

            for ($i = 0; $i < $postCount; $i++) {
                $post = Post::factory()->create([
                    'category_id' => $category->id,
                    'user_id' => $users->random()->id,
                ]);

                // Add 1-3 images per post
                $imageCount = rand(1, 3);
                $postImages = [];
                for ($j = 0; $j < $imageCount; $j++) {
                    $postImages[] = PostImage::factory()->create([
                        'post_id' => $post->id,
                        'is_featured' => $j === 0, // First image is featured
                        'sort_order' => $j,
                    ]);
                }

                // Replace image placeholders in content with actual post images
                $content = $post->content;
                foreach ($postImages as $index => $image) {
                    $placeholder = '{{POST_IMAGE_' . $index . '}}';
                    $imageHtml = '<figure class="my-6">';
                    $imageHtml .= '<img src="' . $image->image_url . '" alt="' . ($image->alt_text ?? 'Hình ảnh minh họa') . '" class="w-full rounded-lg shadow-lg">';
                    $imageHtml .= '<figcaption class="text-center text-sm text-gray-600 mt-2">' . ($image->caption ?? 'Hình ảnh minh họa cho nội dung bài viết') . '</figcaption>';
                    $imageHtml .= '</figure>';

                    $content = str_replace($placeholder, $imageHtml, $content);
                }

                // Remove any remaining placeholders that don't have corresponding images
                $content = preg_replace('/\{\{POST_IMAGE_\d+\}\}/', '', $content);

                // Update post content with actual images
                $post->update(['content' => $content]);

                // Add 0-10 comments per post
                $commentCount = rand(0, 10);
                for ($k = 0; $k < $commentCount; $k++) {
                    $comment = Comment::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $users->random()->id,
                    ]);

                    // 30% chance of having a reply
                    if (rand(1, 100) <= 30) {
                        Comment::factory()->create([
                            'post_id' => $post->id,
                            'user_id' => $users->random()->id,
                            'parent_id' => $comment->id,
                        ]);
                    }
                }

                // Update post comment count
                $post->update(['comment_count' => $post->comments()->count()]);
            }
        }

        // Create some featured posts
        Post::published()->inRandomOrder()->limit(5)->update(['is_featured' => true]);

        echo "Khởi tạo dữ liệu thành công!\n";
        echo "Tài khoản quản trị: admin@example.com / password\n";
        echo "Tài khoản thử nghiệm: test@example.com / password\n";
        echo "Đã tạo " . User::count() . " người dùng\n";
        echo "Đã tạo " . Category::count() . " danh mục\n";
        echo "Đã tạo " . Post::count() . " bài viết\n";
        echo "Đã tạo " . PostImage::count() . " hình ảnh bài viết\n";
        echo "Đã tạo " . Comment::count() . " bình luận\n";
    }
}