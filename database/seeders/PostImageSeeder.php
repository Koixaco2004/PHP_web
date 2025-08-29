<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách URL hình ảnh ngẫu nhiên từ Unsplash (miễn phí)
        $imageUrls = [
            'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1444653614773-995cb1ef9efa?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1585776245991-cf89dd7fc73a?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1504711331083-9c895941bf81?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1588345921523-c2dcdb7f1dcd?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1611348586804-61bf6c080437?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1585776245991-cf89dd7fc73a?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=600&fit=crop'
        ];

        // Lấy tất cả các bài viết chưa có hình ảnh
        $posts = Post::whereNull('featured_image')->orWhere('featured_image', '')->get();

        foreach ($posts as $post) {
            // Chọn ngẫu nhiên một URL hình ảnh
            $randomImageUrl = $imageUrls[array_rand($imageUrls)];
            
            // Cập nhật bài viết với URL hình ảnh
            $post->update([
                'featured_image' => $randomImageUrl
            ]);
        }

        $this->command->info('Đã thêm hình ảnh cho ' . $posts->count() . ' bài viết.');
    }
}
