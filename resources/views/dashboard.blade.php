@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-dark">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-0 text-dark">
                {{ __("You're logged in!") }}
            </p>
        </div>
    </div>
@endsection
