@extends('layouts.admin-auth')

@section('content')
<div class="login-box-body">
    <p class="login-box-msg">{{ __('lang.Reset password') }}</p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}">
        @csrf

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.Email') }}" required>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-custom btn-block btn-flat">
                    {{ __('lang.Send password reset link') }}
                </button>
            </div>

            <div class="col-xs-12 text-center pt-15">
                <a href="{{ route('admin.login') }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i> {{ __('lang.Back to login') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection
