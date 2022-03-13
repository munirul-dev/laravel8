@forelse ($comments as $comment)
    <p class="mb-0">{{ $comment->content }}</p>
    <x-updated :date="$comment->created_at->diffForHumans()" :name="$comment->user->name" :userId="$comment->user->id">Commented</x-updated>
@empty
    <p>No comments yet.</p>
@endforelse
