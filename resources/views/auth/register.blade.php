@extends('layouts.guest')

@section('content')
<div class="main-login">
    <div class="header-container">
        @include('partials.selection_lang')
    </div>
    <div class="main-login__bg">
        <img src="images/bg_login.jpg" alt="">
    </div>
    <main>
        <div class="container">
            <form method="POST" action="{{ route('register') }}" class="login">
                @csrf
                <div class="login__title">{{ __('auth.Register') }}</div>
                <div class="login__desc">Заповніть форму для створення нового облікового запису</div>

                <!-- Name -->
                <div class="input-wrap">
                    <label class="input-container">
                        <input id="name" type="text" name="name" class="input dark-theme" placeholder="Name" value="{{ old('name') }}" required autofocus autocomplete="name">
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG icon for name -->
                        </svg>
                    </label>
                    @if ($errors->has('name'))
                        <div class="text-danger mt-1">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="input-wrap">
                    <label class="input-container">
                        <input id="email" type="email" name="email" class="input dark-theme" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG icon for email -->
                        </svg>
                    </label>
                    @if ($errors->has('email'))
                        <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Password -->
                <div class="input-wrap input-wrap--password">
                    <label class="input-container">
                        <input id="password" type="password" name="password" class="input dark-theme" placeholder="Password" required autocomplete="new-password">
                        <svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG icon for password -->
                        </svg>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
                        @endif
                    </label>
                </div>

                <!-- Confirm Password -->
                <div class="input-wrap input-wrap--password">
                    <label class="input-container">
                        <input id="password_confirmation" type="password" name="password_confirmation" class="input dark-theme" placeholder="Confirm Password" required autocomplete="new-password">
                        <svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG icon for confirm password -->
                        </svg>
                        @if ($errors->has('password_confirmation'))
                            <div class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </label>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a class="text-sm text-primary" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <button type="submit" class="btn login-btn">
                        Зареєструватися
                        <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG icon for button -->
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

@endsection
