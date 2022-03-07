<div class="row mb-4">
    <div class="card w-100">
        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>
            <h6 class="card-subtitle text-muted">{{ $subtitle }}</h6>
        </div>
        <ul class="list-group list-group-flush">
            @if (is_a($items, 'Illuminate\Support\Collection'))
                @forelse ($items as $item)
                    <li class="list-group-item">
                        {{ $item }}
                    </li>
                @empty
                    <li class="list-group-item">No list found.</li>
                @endforelse
            @else
                {{ $items }}
            @endif
        </ul>
    </div>
</div>
