@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Persons</h2>

        @auth
        @if(auth()->user()->isAdmin())
        <a href="{{ route('persons.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Person
        </a>
        @endif
        @endauth

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
                        <th>DOB</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Zip</th>
                        <th>Email</th>
                        <th>Email Pass</th>
                        <th>FA Username</th>
                        <th>FA Pass</th>
                        <th>Backup Code</th>
                        <th>Security QA</th>
                        <th>Country</th>
                        <th>Description</th>
                        <th>SSN</th>
                        <th>CS</th>
                        <th>Price</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($persons as $p)
                    <tr>
                        <td>{{ $p->firstName }} {{ $p->lastName }}</td>
                        <td>{{ $p->dob ? \Carbon\Carbon::parse($p->dob)->year : '' }}</td>
                        <td>{{ $p->state }}</td>
                        <td>{{ $p->city }}</td>
                        <td>{{ $p->zip }}</td>

                        {{-- Masked fields with checkmark if value exists --}}
                        <td class="text-center">{!! $p->email ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->emailPass ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->faUname ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->faPass ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->backupCode ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->securityQa ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->country ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->description ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->ssn ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">{!! $p->cs ? '<i class="bi bi-check2"></i>' : '' !!}</td>
                        <td class="text-center">${{ $p->price }}</td>

                        {{-- Actions --}}
                        <td class="text-end" style="white-space: nowrap;">
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
                        <td colspan="17" class="text-center py-4 text-muted">No persons found.</td>
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
