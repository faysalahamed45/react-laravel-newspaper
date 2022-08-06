@extends('layouts.admin-auth')

@section('content')
<div class="login-box-body">
  <p class="login-box-msg">{{ __('lang.Register') }}</p>
    <form method="POST" action="{{ route('admin.register') }}">
        @csrf

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ __('lang.Name') }}" required>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="{{ __('lang.Mobile') }}">

            @if ($errors->has('mobile'))
                <span class="help-block">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.Email') }}" required>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="{{ __('lang.Password') }}" required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('lang.Confirm Password') }}">

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-custom btn-block btn-flat">{{ __('lang.Submit') }}</button>
            </div>

            <div class="col-xs-12 text-center pt-15">
                <a href="{{ route('admin.login') }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i> {{ __('lang.Back to login') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection
