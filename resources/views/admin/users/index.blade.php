@extends('layouts.admin_layout')

@section('title', __('Users'))

@section('content')
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ __('Users') }}</h2>
        <a href="{{ route('admin_users_create') }}" class="btn btn-primary">{{ __('Add New User') }}</a>
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Roles') }}</th>
                <th>{{ __('Volunteering') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{ $user->roles->pluck('name')->implode(', ') }}
                    </td>
                    <td>
                        @if($user->isVolunteer())
                            <a href="{{ route('admin_volunteer_show', ['id' => $user->volunteer->id]) }}" class="btn btn-success btn-sm">{{ __('View Volunteer') }}</a>
                        @else
                            <a href="{{ route('admin_volunteer_create', ['user_id' => $user->id]) }}" class="btn btn-primary btn-sm">{{ __('Make Volunteer') }}</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin_users_edit', ['id' => $user->id]) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                        <form action="{{ route('admin_users_destroy') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}');">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('No users found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Пагинация -->
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
