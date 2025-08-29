<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();

        $posts = [
            [
                'title' => 'Laravel 11: Những tính năng mới đáng chú ý',
                'content' => 'Laravel 11 đã được phát hành với nhiều tính năng mới thú vị. Framework này tiếp tục cải thiện hiệu suất và trải nghiệm phát triển cho các developer...',
                'excerpt' => 'Khám phá những tính năng mới trong Laravel 11',
                'category_id' => 1, // Công nghệ
            ],
            [
                'title' => 'Việt Nam giành huy chương vàng SEA Games',
                'content' => 'Đội tuyển Việt Nam đã xuất sắc giành được huy chương vàng tại SEA Games với những màn trình diễn ấn tượng...',
                'excerpt' => 'Thành tích mới của thể thao Việt Nam',
                'category_id' => 2, // Thể thao
            ],
            [
                'title' => 'Phim mới của Marvel thu hút hàng triệu khán giả',
                'content' => 'Bộ phim mới nhất của Marvel Studios đã thu hút được sự chú ý của hàng triệu khán giả trên toàn thế giới...',
                'excerpt' => 'Thành công mới của Marvel Cinematic Universe',
                'category_id' => 3, // Giải trí
            ],
            [
                'title' => 'Thị trường chứng khoán Việt Nam tăng trưởng mạnh',
                'content' => 'Chỉ số VN-Index đã tăng trưởng mạnh trong quý vừa qua, thể hiện sự phục hồi tích cực của nền kinh tế...',
                'excerpt' => 'Tín hiệu tích cực từ thị trường tài chính',
                'category_id' => 4, // Kinh tế
            ],
            [
                'title' => 'Công nghệ AI trong giáo dục: Xu hướng tương lai',
                'content' => 'Trí tuệ nhân tạo đang thay đổi cách thức giáo dục trên toàn thế giới. Các ứng dụng AI giúp cá nhân hóa việc học tập...',
                'excerpt' => 'Tương lai của giáo dục với AI',
                'category_id' => 5, // Giáo dục
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => $post['content'],
                'excerpt' => $post['excerpt'],
                'status' => 'published',
                'category_id' => $post['category_id'],
                'user_id' => $users->random()->id,
                'view_count' => rand(100, 1000),
            ]);
        }

        // Tạo thêm một số bài viết mẫu
        Post::factory(10)->create([
            'status' => 'published',
            'category_id' => $categories->random()->id,
            'user_id' => $users->random()->id,
        ]);
    }
}
