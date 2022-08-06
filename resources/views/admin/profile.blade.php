@extends('layouts.admin')

@section('content')
<section class="content-header">
    <h1>{{ __('lang.Profile') }}</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <h4 class="box-title">&nbsp;</h4>
                    <form method="POST" action="{{ route('admin.profile') }}">
                        @csrf

                        <div class="form-group">
                            <label class="required">{{ __('lang.Name') }}</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>

                            @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>{{ __('lang.Mobile') }}</label>
                            <input type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}">

                            @if ($errors->has('mobile'))
                                <span class="help-block">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>{{ __('lang.Email') }}</label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <button class="btn btn-success btn-flat btn-block" type="submit">{{ __('lang.Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <h4 class="box-title">{{ __('lang.Update password') }}</h4>
                    <form method="POST" action="{{ route('admin.profile.password') }}">
                        @csrf

                        <div class="form-group">
                            <label class="required">{{ __('lang.Current Password') }}</label>
                            <input type="password" class="form-control" name="current_password" required>

                            @error('current_password')
                                <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required">{{ __('lang.Password') }}</label>
                            <input type="password" class="form-control" name="password" required>

                            @error('password')
                                <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required">{{ __('lang.Confirm Password') }}</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <button class="btn btn-success btn-flat btn-block" type="submit">{{ __('lang.Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
