<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vietnameseTitles = [
            'Hướng dẫn học lập trình từ cơ bản đến nâng cao',
            'Các công nghệ mới nhất trong phát triển web',
            'Tips và tricks để tối ưu hóa website',
            'Kinh nghiệm làm việc với framework Laravel',
            'Cách xây dựng ứng dụng mobile hiệu quả',
            'Thiết kế UI/UX thân thiện với người dùng',
            'Tìm hiểu về trí tuệ nhân tạo và machine learning',
            'DevOps và việc triển khai ứng dụng tự động',
            'Bảo mật thông tin trong phát triển phần mềm',
            'Xu hướng công nghệ năm 2025',
            'Cách tối ưu hóa SEO cho website',
            'Phân tích dữ liệu với Python và R',
            'Xây dựng API RESTful chuyên nghiệp',
            'Microservices và kiến trúc phần mềm hiện đại',
            'Cloud computing và các dịch vụ AWS'
        ];

        $title = $this->faker->randomElement($vietnameseTitles) . ' ' . $this->faker->numberBetween(1, 1000);
        $isPublished = $this->faker->boolean(70);

        $approvalStatus = 'pending';
        if ($isPublished) {
            $approvalStatus = $this->faker->boolean(80) ? 'approved' : 'pending';
        }

        $htmlContent = $this->generateHtmlContent();

        $excerpt = $this->generateExcerpt();

        $userId = User::factory();
        $createdAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $approvedAt = ($approvalStatus === 'approved' && $isPublished)
            ? $this->faker->dateTimeBetween($createdAt, 'now')
            : null;

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'content' => $htmlContent,
            'excerpt' => $excerpt,
            'status' => $isPublished ? 'published' : 'draft',
            'approval_status' => $approvalStatus,
            'category_id' => Category::factory(),
            'user_id' => $userId,
            'created_by' => $userId,
            'updated_by' => $userId,
            'approved_by' => ($approvalStatus === 'approved') ? User::where('role', 'admin')->inRandomOrder()->first()?->id : null,
            'approved_at' => $approvedAt,
            'view_count' => $this->faker->numberBetween(0, 5000),
            'comment_count' => $this->faker->numberBetween(0, 50),
            'is_featured' => $this->faker->boolean(15),
            'published_at' => $isPublished ? $createdAt : null,
            'created_at' => $createdAt,
        ];
    }

    /**
     * Generate HTML content for the post
     */
    private function generateHtmlContent(): string
    {
        $paragraphs = [
            'Trong thời đại công nghệ số hiện nay, việc nắm vững các kỹ năng lập trình trở nên vô cùng quan trọng. Lập trình không chỉ là một nghề nghiệp mà còn là một nghệ thuật, đòi hỏi sự sáng tạo, logic và kiên nhẫn. Để trở thành một lập trình viên giỏi, bạn cần không ngừng học hỏi và cập nhật kiến thức mới.',
            'Framework Laravel đã trở thành một trong những công cụ phổ biến nhất cho phát triển web PHP. Với cú pháp rõ ràng, tài liệu phong phú và cộng đồng hỗ trợ mạnh mẽ, Laravel giúp các developer xây dựng ứng dụng web nhanh chóng và hiệu quả hơn bao giờ hết.',
            'Thiết kế giao diện người dùng đóng vai trò then chốt trong thành công của một ứng dụng. Một UI/UX tốt không chỉ đẹp mắt mà còn phải trực quan, dễ sử dụng và mang lại trải nghiệm tuyệt vời cho người dùng. Việc tối ưu hóa hiệu suất website cũng giúp cải thiện trải nghiệm người dùng đáng kể.',
            'Trí tuệ nhân tạo đang thay đổi cách chúng ta làm việc và sinh hoạt hàng ngày. Từ chatbot, hệ thống gợi ý, đến xe tự lái, AI đang dần thâm nhập vào mọi lĩnh vực của cuộc sống. Việc học và ứng dụng AI không còn là xa xỉ mà đã trở thành một kỹ năng cần thiết.',
            'DevOps giúp tăng tốc độ phát triển và triển khai phần mềm một cách hiệu quả. Bằng cách tự động hóa các quy trình, DevOps giúp giảm thiểu lỗi, tăng tốc độ phát hành và cải thiện sự hợp tác giữa các team. CI/CD pipeline là một phần không thể thiếu trong quy trình DevOps hiện đại.',
            'Bảo mật thông tin là ưu tiên hàng đầu trong mọi dự án phát triển phần mềm. Với sự gia tăng của các cuộc tấn công mạng, việc bảo vệ dữ liệu người dùng và hệ thống trở nên quan trọng hơn bao giờ hết. Các developer cần nắm vững các nguyên tắc bảo mật cơ bản và luôn cập nhật các threat mới.',
            'Cloud computing đã thay đổi cách chúng ta triển khai và quản lý ứng dụng. AWS, Azure, Google Cloud cung cấp các dịch vụ đa dạng giúp doanh nghiệp tiết kiệm chi phí và tăng khả năng mở rộng. Kiến thức về cloud computing đang trở thành một yêu cầu bắt buộc cho các developer.',
            'Microservices architecture cho phép xây dựng các hệ thống phức tạp bằng cách chia nhỏ thành các service độc lập. Mỗi service có thể được phát triển, triển khai và mở rộng độc lập, giúp tăng tính linh hoạt và khả năng bảo trì của hệ thống.',
        ];

        $headings = [
            'Giới thiệu',
            'Tầm quan trọng',
            'Các khái niệm cơ bản',
            'Best Practices',
            'Ứng dụng thực tế',
            'Kinh nghiệm thực chiến',
            'Công nghệ và công cụ',
            'Tương lai và xu hướng',
        ];

        $listItems = [
            ['Hiểu rõ các khái niệm cơ bản và nền tảng', 'Thực hành thường xuyên với các dự án thực tế', 'Tham gia cộng đồng và học hỏi từ người khác'],
            ['Tối ưu hóa hiệu suất và tốc độ tải trang', 'Đảm bảo tính bảo mật cho người dùng', 'Thiết kế responsive trên mọi thiết bị'],
            ['Sử dụng version control (Git) hiệu quả', 'Viết code sạch và dễ bảo trì', 'Áp dụng các design patterns phù hợp'],
            ['Continuous learning và cập nhật kiến thức mới', 'Networking với các developer khác', 'Xây dựng portfolio ấn tượng'],
        ];

        $quotes = [
            'Thành công không phải là chìa khóa của hạnh phúc. Hạnh phúc mới là chìa khóa của thành công. Nếu bạn yêu thích công việc mình đang làm, bạn sẽ thành công.',
            'Học tập không bao giờ là đủ. Hãy thực hành những gì bạn đã học để trở nên thành thạo.',
            'Code chỉ đẹp khi nó dễ đọc, dễ hiểu và dễ bảo trì. Hãy viết code cho con người, không phải cho máy móc.',
            'Sự khác biệt giữa một developer giỏi và một developer tuyệt vời nằm ở khả năng giao tiếp và làm việc nhóm.',
            'Không có bug nào là quá nhỏ để bỏ qua, và không có tính năng nào là quá lớn để không thể chia nhỏ.',
        ];

        $html = '';
        $sectionCount = $this->faker->numberBetween(4, 7);
        $imageIndex = 0;

        for ($i = 0; $i < $sectionCount; $i++) {
            if ($i > 0) {
                $html .= '<h2 class="text-2xl font-bold mt-8 mb-4 text-gray-900 dark:text-gray-100">' . $this->faker->randomElement($headings) . '</h2>';
            }

            $html .= '<p class="mb-4 leading-relaxed text-gray-900 dark:text-gray-100">' . $this->faker->randomElement($paragraphs) . '</p>';

            if ($this->faker->boolean(40)) {
                $html .= '{{POST_IMAGE_' . $imageIndex . '}}';
                $imageIndex++;
            }

            $html .= '<p class="mb-4 leading-relaxed text-gray-900 dark:text-gray-100">' . $this->faker->randomElement($paragraphs) . '</p>';

            if ($this->faker->boolean(30)) {
                $items = $this->faker->randomElement($listItems);
                $html .= '<ul class="list-disc list-inside mb-6 space-y-2 ml-4">';
                foreach ($items as $item) {
                    $html .= '<li class="text-gray-900 dark:text-gray-100">' . $item . '</li>';
                }
                $html .= '</ul>';
            }

            if ($this->faker->boolean(25)) {
                $html .= '<blockquote class="border-l-4 border-blue-500 dark:border-blue-400 pl-6 py-4 my-6 italic bg-gray-50 dark:bg-gray-800 rounded-r-lg">';
                $html .= '<p class="text-gray-700 dark:text-gray-300">"' . $this->faker->randomElement($quotes) . '"</p>';
                $html .= '</blockquote>';
            }
        }

        // Add conclusion
        $html .= '<h2 class="text-2xl font-bold mt-8 mb-4 text-gray-900 dark:text-gray-100">Kết luận</h2>';
        $html .= '<p class="mb-4 leading-relaxed text-gray-900 dark:text-gray-100">' . $this->faker->randomElement($paragraphs) . '</p>';

        $html .= '<blockquote class="border-l-4 border-blue-500 dark:border-blue-400 pl-6 py-4 my-6 italic bg-gray-50 dark:bg-gray-800 rounded-r-lg">';
        $html .= '<p class="text-gray-700 dark:text-gray-300">"' . $this->faker->randomElement($quotes) . '"</p>';
        $html .= '</blockquote>';

        return $html;
    }

    /**
     * Generate excerpt for the post
     */
    private function generateExcerpt(): string
    {
        $excerpts = [
            'Trong thời đại công nghệ số hiện nay, việc nắm vững các kỹ năng lập trình trở nên vô cùng quan trọng.',
            'Để trở thành một lập trình viên giỏi, bạn cần không ngừng học hỏi và cập nhật kiến thức mới.',
            'Framework Laravel đã trở thành một trong những công cụ phổ biến nhất cho phát triển web PHP.',
            'Thiết kế giao diện người dùng đóng vai trò then chốt trong thành công của một ứng dụng.',
            'Việc tối ưu hóa hiệu suất website giúp cải thiện trải nghiệm người dùng đáng kể.',
            'Trí tuệ nhân tạo đang thay đổi cách chúng ta làm việc và sinh hoạt hàng ngày.',
            'DevOps giúp tăng tốc độ phát triển và triển khai phần mềm một cách hiệu quả.',
            'Bảo mật thông tin là ưu tiên hàng đầu trong mọi dự án phát triển phần mềm.',
        ];

        return $this->faker->randomElement($excerpts);
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the post is draft.
     */
    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the post is featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
