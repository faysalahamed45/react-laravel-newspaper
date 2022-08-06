@extends('layouts.app')

@section('content')
<div class="auth-body">
    <div class="col-md-5 mx-auto">
        <div class="auth-form">
            <div class="logo mb-3">
                <div class="col-md-12 text-center">
                    <h1 style="font-size: 6.25rem;">
                        <span class="auth-link font-italic">4</span>0<span class="auth-link font-italic">4</span>
                    </h1>
                </div>
            </div>

            <div class="alert alert-warning fade show text-center" role="alert">
                <h4 class="m-3">{{ __('lang.Message404') }}</h4>
            </div>
        </div>
    </div>
</div>
@endsection
