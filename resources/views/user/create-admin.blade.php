@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . $pageTitle)

@section('header-title')
    <h3 class="title">{{ $pageTitle }}</h3>
@endsection

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <nav aria-label="breadcrumb" class="modern-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-house"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ $listRoute }}">{{ $listTitle }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('Create') }}
                        </li>
                    </ol>
                </nav>
                <a href="{{ $listRoute }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="fa-solid fa-arrow-left me-1"></i> {{ __('Back to List') }}
                </a>
            </div>

            <form action="{{ $storeRoute }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf

                <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">
                    <div class="card-body p-5">
                        <div class="alert alert-info">
                            {{ $adminType === 'super'
                                ? __('This employee will be created as a Super Admin with full root access.')
                                : __('This employee will be created as an Associate Admin. Assign permissions from Role & Permission after creation.') }}
                        </div>

                        <div class="row g-5 align-items-start">
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle overflow-hidden border border-3 border-primary shadow-sm"
                                        style="width: 160px; height: 160px;">
                                        <img id="courseImagePreview" src="/assets/images/profile/demo-profile.png"
                                            class="w-100 h-100" style="object-fit: cover">
                                    </div>
                                    <label for="formFileImage"
                                        class="btn btn-sm btn-primary shadow position-absolute d-flex justify-content-center align-items-center"
                                        style="bottom: 8px; right:8px; width:40px; height:40px; border-radius:50%; font-size:14px;">
                                        <i class="fa fa-camera"></i>
                                    </label>
                                    <input name="profile_picture" id="formFileImage" type="file" class="d-none"
                                        onchange="document.getElementById('courseImagePreview').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                <small class="d-block mt-2 text-muted">{{ __('JPG, JPEG, PNG up to 2MB') }}</small>
                                @error('profile_picture')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">{{ __('Full Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control rounded-3"
                                            placeholder="{{ __('Enter full name') }}" value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Login Email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control rounded-3"
                                            placeholder="{{ __('Enter email') }}" value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control rounded-3"
                                            placeholder="{{ __('Enter phone number') }}" value="{{ old('phone') }}">
                                        @error('phone')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Password') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control rounded-3"
                                            placeholder="{{ __('Enter password') }}">
                                        @error('password')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
                                        <input type="password" name="password_confirmation" class="form-control rounded-3"
                                            placeholder="{{ __('Re-enter password') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h6 class="fw-bold mb-3">{{ __('Account Settings') }}</h6>
                            <div class="form-check">
                                <input id="activeInput" name="is_active" class="form-check-input" type="checkbox" checked>
                                <label for="activeInput" class="form-check-label">
                                    {{ __('Verify Account by Default') }}
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">
                                {{ __('Employee can log in at') }} <code>/admin/login</code>
                            </small>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 px-5">
                                <i class="fa fa-plus"></i> {{ __('Create Employee') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
