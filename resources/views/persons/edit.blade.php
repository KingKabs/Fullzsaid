@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh; background-color: #f5f7fa;">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card Wrapper -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold">
                    Edit Person
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('persons.update', $person) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('persons._form')
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
