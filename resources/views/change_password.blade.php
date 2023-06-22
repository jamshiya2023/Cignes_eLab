@extends('layout.maintemplate')
@section('content')
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">{{ __('Change Password') }}</h6>
                    </div>
            
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PATCH')
                            
                            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                   
                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autofocus>

                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                         
                    
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                   
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                   
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                   
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                    
                </div>

                <div class="form-group">
                   
                        <button type="submit" class="btn btn-primary my-xl-2">
                            {{ __('Change Password') }}
                        </button>
                    
                </div>
                </div>
                <div class="col-md-6" style="color: #fb5959;">
                    <p>
                        <b>Password should contain:</b>
                        <p>1. Contain at least one letter (uppercase or lowercase).</p>
                        <p>2. Contain at least one number</p>
                        <p>3. Contain at least one special character (in this case, one of @$!%*#?&)are at least 8 characters long</p>
                    </p>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>
    <script src="{!! asset('/assets/bundles/libscripts.bundle.js') !!}"></script>
@endsection