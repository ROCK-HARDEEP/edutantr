@extends('sales.layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('Profile'))

@section('header-title')
    <h3 class="title">{{ __('My Profile') }}</h3>
@endsection

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="position-relative mx-auto mb-3" style="width:120px;height:120px;">
                                <img src="{{ $user->profilePicturePath }}" alt="profile"
                                    class="rounded-circle w-100 h-100 object-fit-cover border">
                                <form action="{{ route('sales.profile.image.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="profile_picture" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle">
                                        <i class="fa fa-camera"></i>
                                    </label>
                                    <input type="file" name="profile_picture" id="profile_picture" hidden accept="image/*"
                                        onchange="this.form.submit()">
                                </form>
                            </div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-2">{{ $user->email }}</p>
                            <span class="badge bg-primary">{{ __('Sales Counselor') }}</span>
                            @if ($member->is_leader)
                                <span class="badge bg-success">{{ __('Team Leader') }}</span>
                            @endif
                            <p class="mt-3 mb-0"><strong>{{ __('Team') }}:</strong> {{ $member->team?->name ?? '-' }}</p>
                            <p class="mb-0"><strong>{{ __('Team Code') }}:</strong> {{ $member->team?->code ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">{{ __('Update Profile') }}</h5>
                            <form action="{{ route('sales.profile.update') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                    <small class="text-muted">{{ __('Contact admin to change login email') }}</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('New Password') }}</label>
                                    <input type="password" name="password" class="form-control" minlength="6">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control" minlength="6">
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
