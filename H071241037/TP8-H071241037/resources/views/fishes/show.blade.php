@extends('layouts.app')

@section('title', 'Fish Details')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2>Fish Details: {{ $fish->name }}</h2>
    <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Back to List</a>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Information</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="30%">ID</th>
                <td>{{ $fish->id }}</td>
            </tr>
            <tr>
                <th>Fish Name</th>
                <td><strong>{{ $fish->name }}</strong></td>
            </tr>
            <tr>
                <th>Rarity</th>
                <td><span class="badge bg-info">{{ $fish->rarity }}</span></td>
            </tr>
            <tr>
                <th>Weight Range</th>
                <td>{{ $fish->formatted_weight_range }}</td>
            </tr>
            <tr>
                <th>Sell Price</th>
                <td>{{ $fish->formatted_price }}</td>
            </tr>
            <tr>
                <th>Catch Probability</th>
                <td>{{ $fish->formatted_probability }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $fish->description ?? '-' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $fish->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $fish->updated_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
        
        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
            <form method="POST" action="{{ route('fishes.destroy', $fish) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection