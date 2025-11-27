@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh; background-color: #f5f7fa;">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold">{{ $person->firstName }} {{ $person->lastName }}</h2>
            </div>

            <!-- Card Wrapper -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-info text-white fw-semibold">
                    Personal Information
                </div>
                <div class="card-body">
                    <p><strong>Gender:</strong> {{ $person->gender }}</p>
                    <p><strong>Date of Birth:</strong> {{ $person->dob }}</p>
                    <p><strong>Address:</strong> {{ $person->address }}</p>
                    <p><strong>Country:</strong> {{ $person->country }}</p>
                    <p><strong>State:</strong> {{ $person->state }}</p>
                    <p><strong>City:</strong> {{ $person->city }}</p>
                    <p><strong>ZIP:</strong> {{ $person->zip }}</p>
                    <p><strong>CS:</strong> {{ $person->cs }}</p>
                    <p><strong>Purchase Date:</strong> {{ $person->purchaseDate }}</p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-secondary text-white fw-semibold">
                    Account & Credentials
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $person->email }}</p>
                    <p><strong>Email Password:</strong> {{ $person->emailPass }}</p>
                    <p><strong>2FA Username:</strong> {{ $person->faUname }}</p>
                    <p><strong>2FA Password:</strong> {{ $person->faPass }}</p>
                    <p><strong>Backup Code:</strong> {{ $person->backupCode }}</p>
                    <p><strong>Security Q&A:</strong> {{ $person->securityQa }}</p>
                    <p><strong>SSN:</strong> {{ $person->ssn }}</p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light fw-semibold">
                    Description
                </div>
                <div class="card-body">
                    <p>{{ $person->description }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-end">
                <a href="{{ route('persons.edit', $person) }}" class="btn btn-warning px-4">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
