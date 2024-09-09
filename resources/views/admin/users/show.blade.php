@extends('layouts.admin_layout')

@section('title', __('View User'))

@section('content')
<div class="container mt-5 mb-5">
    <h2>{{ __('View User') }}</h2>

    <div class="card">
        <div class="card-header">
            {{ __('User Details') }}
        </div>
        <div class="card-body">
            <p><strong>{{ __('Name') }}:</strong> {{ $user->name }}</p>
            <p><strong>{{ __('Email') }}:</strong> {{ $user->email }}</p>
            @if($user->volunteer)
                <h3>{{ __('Volunteer Details') }}</h3>
                <p><strong>{{ __('Full Name') }}:</strong> {{ $user->volunteer->first_name }} {{ $user->volunteer->middle_name }} {{ $user->volunteer->last_name }}</p>
                <p><strong>{{ __('Phone') }}:</strong> {{ $user->volunteer->phone }}</p>
                <p><strong>{{ __('Address') }}:</strong> {{ $user->volunteer->address }}</p>
                <p><strong>{{ __('Photo') }}:</strong> <img src="{{ asset('storage/' . $user->volunteer->photo) }}" alt="Photo" style="width: 100px;"></p>
            @else
                <p>{{ __('No volunteer details available.') }}</p>
            @endif
            <a href="{{ route('admin_users_index') }}" class="btn btn-secondary">{{ __('Back to Users') }}</a>
        </div>
    </div>
</div>
@endsection
