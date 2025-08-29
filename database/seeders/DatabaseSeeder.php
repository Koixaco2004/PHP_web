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
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create test user
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create additional users
        User::factory()->count(20)->create();
        User::factory()->count(5)->subscriber()->create();
        User::factory()->count(3)->withGoogle()->create();

        // Create categories with predefined data
        $categories = [
            ['name' => 'Web Development', 'color' => '#3B82F6', 'icon' => 'fas fa-laptop-code'],
            ['name' => 'Mobile Development', 'color' => '#10B981', 'icon' => 'fas fa-mobile-alt'],
            ['name' => 'UI/UX Design', 'color' => '#F59E0B', 'icon' => 'fas fa-palette'],
            ['name' => 'Data Science', 'color' => '#8B5CF6', 'icon' => 'fas fa-chart-line'],
            ['name' => 'DevOps', 'color' => '#EF4444', 'icon' => 'fas fa-cogs'],
            ['name' => 'Artificial Intelligence', 'color' => '#06B6D4', 'icon' => 'fas fa-lightbulb'],
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
        $users = User::where('role', '!=', 'subscriber')->get();

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
                $post->updateCommentCount();
            }
        }

        // Create some featured posts
        Post::published()->inRandomOrder()->limit(5)->update(['is_featured' => true]);

        echo "Database seeded successfully!\n";
        echo "Admin user: admin@example.com / password\n";
        echo "Test user: test@example.com / password\n";
        echo "Created " . User::count() . " users\n";
        echo "Created " . Category::count() . " categories\n";
        echo "Created " . Post::count() . " posts\n";
        echo "Created " . PostImage::count() . " post images\n";
        echo "Created " . Comment::count() . " comments\n";
    }
}
