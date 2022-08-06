@extends('layouts.admin-auth')

@section('content')
<div class="login-box-body">
    <p class="login-box-msg">{{ __('lang.Login') }}</p>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('lang.Email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" required placeholder="{{ __('lang.Password') }}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label> <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('lang.Remember me') }}</label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-custom btn-block btn-flat">{{ __('lang.Login') }}</button>
            </div>
        </div>
    </form>

    <a class="btn-link" href="{{ route('admin.password.request') }}">{{ __('lang.Forgot your password') }}</a>
</div>
@endsection
