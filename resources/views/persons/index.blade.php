@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Persons</h2>
        <a href="{{ route('persons.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Person
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Search Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('persons.index') }}">
                <div class="input-group">
                    <input type="text" name="search"
                           class="form-control"
                           placeholder="Search persons..."
                           value="{{ request('search') }}">
                    <button class="btn btn-dark px-4">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Persons Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">
            Persons List
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Purchase Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($persons as $p)
                    <tr>
                        <td>{{ $p->firstName }} {{ $p->lastName }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->country }}</td>
                        <td>{{ $p->city }}</td>
                        <td>{{ $p->purchaseDate }}</td>
                        <td class="text-end">
                            <div class="btn-group" role="group" aria-label="Actions">
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('persons.show', $p) }}" class="btn btn-sm btn-outline-info"> <i class="bi bi-eye"></i></a>
                                <a href="{{ route('persons.edit', $p) }}" class="btn btn-sm btn-outline-warning"> <i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('persons.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete this entry?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @else
                                @if(isset(session('cart')[$p->id]))
                                <button class="btn btn-sm btn-secondary" disabled>Added <i class="bi bi-check2"></i></button>
                                @else
                                <form action="{{ route('cart.add', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">Add <i class="bi bi-cart-plus"></i></button>
                                </form>
                                @endif

                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No persons found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $persons->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
