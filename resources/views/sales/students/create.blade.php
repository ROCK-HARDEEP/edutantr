@extends('sales.layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('Add Student'))

@section('header-title')
    <h3 class="title">{{ __('Add Student') }}</h3>
@endsection

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="card mx-auto" style="max-width: 800px;">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales.students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <img id="preview" src="/assets/images/profile/demo-profile.png"
                                class="rounded-circle border" width="120" height="120" style="object-fit: cover">
                            <div class="mt-2">
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="form-control">
                                <small class="text-muted">{{ __('Optional profile photo') }}</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Full Name') }} *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Email') }} *</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Phone') }} *</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Password') }} *</label>
                                <input type="password" name="password" class="form-control" required minlength="8">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Confirm Password') }} *</label>
                                <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('Create Student') }}</button>
                            <a href="{{ route('sales.students.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('profile_picture')?.addEventListener('change', function() {
            if (this.files[0]) {
                document.getElementById('preview').src = URL.createObjectURL(this.files[0]);
            }
        });
    </script>
@endpush
