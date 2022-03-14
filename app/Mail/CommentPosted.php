<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Comment was posted on your {$this->comment->commentable->title}";
        return $this
            // First example with full path
            // ->attach(
            //     storage_path('app/public/') . $this->comment->user->image->path,
            //     [
            //         'as' => 'profile_picture.jpeg',
            //         'mime' => 'image/jpeg',
            //     ]
            // )

            // Second example with relative path
            // ->attachFromStorage($this->comment->user->image->path, 'profile_picture.jpeg', ['mime' => 'image/jpeg'])

            // Third example with custom storage disk
            // ->attachFromStorageDisk('public', $this->comment->user->image->path, 'profile_picture.jpeg', ['mime' => 'image/jpeg'])

            // Fourth example with file from cache
            // ->attachData(Storage::get($this->comment->user->image->path), 'profile_picture.jpeg', ['mime' => 'image/jpeg'])

            ->subject($subject)
            ->view('emails.posts.commented');
    }
}
