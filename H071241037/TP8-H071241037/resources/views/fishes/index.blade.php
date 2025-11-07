@extends('layouts.app')

@section('title', 'Fish Praktikum 8')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Fish Praktikum 8</h2>
    <a href="{{ route('fishes.create') }}" class="btn btn-primary">Add New Fish</a>
</div>

<div class_row mb-3>
    <form method="GET">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary">Search</button>
                </div>
            </div>
            <div class="col-md-4">
                <select name="rarity" class="form-select" onchange="this.form.submit()">
                    <option value="">All Rarities</option>
                    @foreach($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                            {{ $rarity }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Rarity</th>
                        <th>Weight Range</th>
                        <th>Sell Price</th>
                        <th>Probability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fishes as $fish)
                        <tr>
                            <td>{{ $fish->id }}</td>
                            <td><strong>{{ $fish->name }}</strong></td>
                            <td>{{ $fish->rarity }}</td>
                            <td>{{ $fish->formatted_weight_range }}</td>
                            <td>{{ $fish->formatted_price }}</td>
                            <td>{{ $fish->formatted_probability }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('fishes.show', $fish) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('fishes.destroy', $fish) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No fish found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $fishes->appends(request()->query())->links() }}
</div>
@endsection