@extends('layouts.admin_layout')

@section('title', __('Edit User'))

@section('content')
<div class="container mt-5 mb-5">
    <h2>{{ __('Edit User') }}</h2>

    <form action="{{ route('admin_users_update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }} ({{ __('Leave blank to keep current') }})</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Update User') }}</button>
    </form>
</div>
@endsection
