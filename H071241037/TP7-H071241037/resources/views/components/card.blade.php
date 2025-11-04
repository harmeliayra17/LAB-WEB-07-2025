@props(['image', 'title', 'description'])

<div class="card">
    <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}">
    <div class="card-content">
        <h3>{{ $title }}</h3>
        <p>{{ $description }}</p>
    </div>
</div>