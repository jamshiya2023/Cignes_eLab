@extends('layout.maintemplate')
@section('content')
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-3 py-1 mt-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="card-title m-0">{{ __('Edit Your Profile') }}</h6>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="form-group">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" name="name" required autofocus>
                                    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" name="email" autocomplete="email">
                                    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary my-xl-3">
                                    {{ __('Save Changes') }}
                                </button>
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