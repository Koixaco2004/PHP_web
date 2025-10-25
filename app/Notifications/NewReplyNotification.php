<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;
use App\Models\Post;

class NewReplyNotification extends Notification
{
    use Queueable;

    public $comment;
    public $post;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment, Post $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Có reply mới cho bình luận của bạn.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'parent_comment_id' => $this->comment->parent_id,
            'user_id' => $this->comment->user->id,
            'user_name' => $this->comment->user->name,
            'type' => 'reply',
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Có reply mới cho bình luận của bạn.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'parent_comment_id' => $this->comment->parent_id,
            'user_id' => $this->comment->user->id,
            'user_name' => $this->comment->user->name,
            'type' => 'reply',
        ];
    }
}