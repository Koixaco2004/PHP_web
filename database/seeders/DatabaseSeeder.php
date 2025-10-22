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

        // Create categories with predefined data
        $categories = [
            ['name' => 'Phát triển Web', 'color' => '#3B82F6', 'icon' => 'fas fa-laptop-code'],
            ['name' => 'Phát triển Mobile', 'color' => '#10B981', 'icon' => 'fas fa-mobile-alt'],
            ['name' => 'Thiết kế UI/UX', 'color' => '#F59E0B', 'icon' => 'fas fa-palette'],
            ['name' => 'Khoa học dữ liệu', 'color' => '#8B5CF6', 'icon' => 'fas fa-chart-line'],
            ['name' => 'DevOps', 'color' => '#EF4444', 'icon' => 'fas fa-cogs'],
            ['name' => 'Trí tuệ nhân tạo', 'color' => '#06B6D4', 'icon' => 'fas fa-lightbulb'],
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
                for ($j = 0; $j < $imageCount; $j++) {
                    PostImage::factory()->create([
                        'post_id' => $post->id,
                        'is_featured' => $j === 0, // First image is featured
                        'sort_order' => $j,
                    ]);
                }

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