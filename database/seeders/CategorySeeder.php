<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Công nghệ',
                'description' => 'Tin tức về công nghệ mới nhất',
            ],
            [
                'name' => 'Thể thao',
                'description' => 'Tin tức thể thao trong nước và quốc tế',
            ],
            [
                'name' => 'Giải trí',
                'description' => 'Tin tức giải trí, phim ảnh, âm nhạc',
            ],
            [
                'name' => 'Kinh tế',
                'description' => 'Tin tức kinh tế, tài chính, doanh nghiệp',
            ],
            [
                'name' => 'Giáo dục',
                'description' => 'Tin tức giáo dục, học tập, nghiên cứu',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}
