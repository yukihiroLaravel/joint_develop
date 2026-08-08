<?php

namespace App\Notifications;

use App\Post;
use App\Reaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReactionReceived extends Notification
{
    use Queueable;

    protected $post;
    protected $reactedBy;
    protected $reactionType;

    public function __construct(Post $post, User $reactedBy, $reactionType)
    {
        $this->post = $post;
        $this->reactedBy = $reactedBy;
        $this->reactionType = $reactionType;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('あなたの投稿にリアクションが届きました')
            ->greeting($notifiable->name . 'さんへ')
            ->line($this->reactedBy->name . 'さんが、あなたの投稿に「' . $this->reactionLabel() . '」でリアクションしました。')
            ->action('投稿を確認する', route('post.show', $this->post->id))
            ->line('Positive Oops');
    }

    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'reacted_by_name' => $this->reactedBy->name,
            'reaction_type' => $this->reactionType,
            'reaction_label' => $this->reactionLabel(),
            'url' => route('post.show', $this->post->id),
        ];
    }

    private function reactionLabel()
    {
        return Reaction::TYPES[$this->reactionType] ?? $this->reactionType;
    }
}