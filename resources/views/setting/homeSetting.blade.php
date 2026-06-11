@extends('layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('Settings'))

@section('header-title')
    <h3 class="title">{{ __('Home Settings') }}</h3>
@endsection

@section('content')
    <!-- ****Body-Section***** -->
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
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ __('Home Settings') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            {{-- content start here --}}

            <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row my-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h3 class="m-0 p-0 fw-bold text-primary">{{ __('Frontend Visibility') }}</h3>
                                        <p class="text-muted mb-0 mt-2">
                                            {{ __('Enable this to hide the public website and show a coming soon / under construction page instead.') }}
                                        </p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="frontend-visibility-toggle bg-light rounded p-3">
                                            <input type="hidden" name="frontend_coming_soon" value="0">
                                            <label class="switch switch-primary mb-0">
                                                <input type="checkbox" class="switch-input" name="frontend_coming_soon"
                                                    value="1" {{ $setting?->frontend_coming_soon ? 'checked' : '' }}>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="fa fa-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                    <i></i>
                                                </span>
                                                <p class="switch-label text-primary mb-0">
                                                    {{ __('Show Coming Soon / Under Construction Page') }}
                                                </p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="comingSoonTitle" class="form-label">{{ __('Coming Soon Title') }}</label>
                                        <input type="text" class="form-control" id="comingSoonTitle"
                                            name="coming_soon_title"
                                            value="{{ old('coming_soon_title', $setting?->coming_soon_title) }}"
                                            placeholder="{{ __('Under Construction') }}" />
                                        @error('coming_soon_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="comingSoonMessage" class="form-label">{{ __('Coming Soon Message') }}</label>
                                        <textarea class="form-control" id="comingSoonMessage" name="coming_soon_message"
                                            rows="3"
                                            placeholder="{{ __('Our website is currently under development. Please check back soon.') }}">{{ old('coming_soon_message', $setting?->coming_soon_message) }}</textarea>
                                        @error('coming_soon_message')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h3 class="m-0 p-0 fw-bold text-primary">{{ __('Site Logo Settings') }}</h3>
                                    </div>
                                    <div class="col-md-4 border-end mt-auto">
                                        <div class="mb-3">
                                            <img id="logoImagePreview"
                                                src="{{ $setting?->logoPath ?? 'https://placehold.jp/675x154.png' }}"
                                                class="w-100"
                                                style="max-height: 180px; border-radius:1rem; object-fit: contain">
                                        </div>
                                        <div>
                                            <h4 class="form-label">{{ __('System Logo') }} (JPG, JPEG, PNG)*</h4>
                                            <label for="formLogoImage" class="w-100 border rounded-3">
                                                <div class="d-flex justify-content-center align-items-center gap-2 p-3"
                                                    style="width: 160px; background-color: #EDEEF1">
                                                    <span>{{ __('Choose a file') }}</span>
                                                    <img src="/assets/images/media/file-plus.svg">
                                                </div>
                                            </label>
                                            <input name="logo" class="form-control form-control-lg" id="formLogoImage"
                                                type="file" hidden
                                                onchange="document.getElementById('logoImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                        </div>

                                        @error('logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 border-end mt-auto">
                                        <div class="mb-3">
                                            <img id="footerImagePreview"
                                                src="{{ $setting?->footerPath ?? 'https://placehold.jp/675x154.png' }}"
                                                class="w-100"
                                                style="max-height: 160px; border-radius:1rem; object-fit: contain">
                                        </div>
                                        <div>
                                            <h4 class="form-label">{{ __('System Footer Logo') }} (JPG, JPEG, PNG)*</h4>
                                            <label for="formFooterImage" class="w-100 border rounded-3">
                                                <div class="d-flex justify-content-center align-items-center gap-2 p-3"
                                                    style="width: 160px; background-color: #EDEEF1">
                                                    <span>{{ __('Choose a file') }}</span>
                                                    <img src="/assets/images/media/file-plus.svg">
                                                </div>
                                            </label>
                                            <input name="footerlogo" class="form-control form-control-lg"
                                                id="formFooterImage" type="file" hidden
                                                onchange="document.getElementById('footerImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                        </div>
                                        @error('footerlogo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 border-end mt-auto">
                                        <div class="mb-3">
                                            <img id="faviconImagePreview"
                                                src="{{ $setting?->faviconPath ?? 'https://placehold.jp/60x60.png' }}"
                                                class="w-100"
                                                style="max-height: 110px; border-radius:1rem; object-fit: contain">
                                        </div>
                                        <div>
                                            <h4 class="form-label">{{ __('Website Favicon') }} (JPG, JPEG, PNG)*</h4>
                                            <label for="formFaviconImage" class="w-100 border rounded-3">
                                                <div class="d-flex justify-content-center align-items-center gap-2 p-3"
                                                    style="width: 160px; background-color: #EDEEF1">
                                                    <span>{{ __('Choose a file') }}</span>
                                                    <img src="/assets/images/media/file-plus.svg">
                                                </div>
                                            </label>
                                            <input name="favicon" class="form-control form-control-lg" id="formFaviconImage"
                                                type="file" hidden
                                                onchange="document.getElementById('faviconImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                        </div>
                                        @error('favicon')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h3 class="m-0 p-0 fw-bold text-primary">{{ __('Images Settings') }}</h3>
                                    </div>
                                    <div class="col-md-4 border-end mt-auto">
                                        <div class="mb-3">
                                            <img id="heroImagePreview"
                                                src="{{ $setting?->heroPath ?? 'https://placehold.jp/1480x2052.png' }}"
                                                class="w-100"
                                                style="max-height: 145px; border-radius:1rem; object-fit: cover">
                                        </div>
                                        <div>
                                            <h4 class="form-label">{{ __('Hero Image') }} (JPG, JPEG, PNG)*</h4>
                                            <label for="formHeroImage" class="w-100 border rounded-3">
                                                <div class="d-flex justify-content-center align-items-center gap-2 p-3"
                                                    style="width: 160px; background-color: #EDEEF1">
                                                    <span>{{ __('Choose a file') }}</span>
                                                    <img src="/assets/images/media/file-plus.svg">
                                                </div>
                                            </label>
                                            <input name="hero_thumbnail" class="form-control form-control-lg"
                                                id="formHeroImage" type="file" hidden
                                                onchange="document.getElementById('heroImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                        </div>
                                        @error('hero_thumbnail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 border-end mt-auto">
                                        <div class="mb-3">
                                            <img id="aboutImagePreview"
                                                src="{{ $setting?->aboutPath ?? 'https://placehold.jp/1008x1116.png' }}"
                                                class="w-100"
                                                style="max-height: 145px; border-radius:1rem; object-fit: cover">
                                        </div>
                                        <div>
                                            <h4 class="form-label">{{ __('About Us Image') }} (JPG, JPEG, PNG)*</h4>
                                            <label for="footerImage" class="w-100 border rounded-3">
                                                <div class="d-flex justify-content-center align-items-center gap-2 p-3"
                                                    style="width: 160px; background-color: #EDEEF1">
                                                    <span>{{ __('Choose a file') }}</span>
                                                    <img src="/assets/images/media/file-plus.svg">
                                                </div>
                                            </label>
                                            <input name="about_thumbnail" class="form-control form-control-lg"
                                                id="footerImage" type="file" hidden
                                                onchange="document.getElementById('aboutImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                        </div>
                                        @error('about_thumbnail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 border-end mt-auto">
                                        <div class="mb-3">
                                            <img id="footerbgImagePreview"
                                                src="{{ $setting?->footerBGPath ?? 'https://placehold.jp/1440x420.png' }}"
                                                class="w-100"
                                                style="max-height: 145px; border-radius:1rem; object-fit: cover">
                                        </div>
                                        <div>
                                            <h4 class="form-label">{{ __('Footer Background Image') }} (JPG, JPEG, PNG)*
                                            </h4>
                                            <label for="formFooterBgImage" class="w-100 border rounded-3">
                                                <div class="d-flex justify-content-center align-items-center gap-2 p-3"
                                                    style="width: 160px; background-color: #EDEEF1">
                                                    <span>{{ __('Choose a file') }}</span>
                                                    <img src="/assets/images/media/file-plus.svg">
                                                </div>
                                            </label>
                                            <input name="footer_bg_thumbnail" class="form-control form-control-lg"
                                                id="formFooterBgImage" type="file" hidden
                                                onchange="document.getElementById('footerbgImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                        </div>
                                        @error('footer_bg_thumbnail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h3 class="fw-bold text-primary border-bottom border-2 pb-3 ">
                                            {{ __('Hero Information') }}</h3>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="courseTitle" class="form-label">{{ __('Hero Title') }} <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" class="form-control" id="courseTitle" name="hero_title"
                                            value="{{ $setting?->hero_title }}" placeholder="Enter Hero Title" />
                                        @error('hero_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="courseTitle" class="form-label">{{ __('Hero Subtitle') }} <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" class="form-control" id="courseTitle" name="hero_subtitle"
                                            value="{{ $setting?->hero_subtitle }}" placeholder="Enter Hero Subtitle" />
                                        @error('hero_subtitle')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="courseTitle" class="form-label">{{ __('Hero Description') }} <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" class="form-control" id="courseTitle"
                                            name="hero_description" value="{{ $setting?->hero_description }}"
                                            placeholder="Enter Hero Description" />
                                        @error('hero_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12 my-3">
                                        <h3 class="fw-bold text-primary border-bottom border-2 pb-3 ">
                                            {{ __('Downloadable Link') }}</h3>
                                    </div>

                                    <div class="col-md-4 mt-auto">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="play_store" class="form-label"> <i
                                                        class="bi bi-google-play fs-6"></i>
                                                    {{ __('Play Store') }}<span
                                                        class="text-danger fw-bold">*</span></label>
                                                <input type="text" class="form-control" id="play_store"
                                                    placeholder="{{ __('Play Store Link') }}" name="play_store_url"
                                                    value="{{ $setting->play_store_url }}">
                                                @error('play_store_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-auto">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="app_store" class="form-label"><i
                                                        class="bi bi-apple fs-6"></i>
                                                    {{ __('App Store') }}<span
                                                        class="text-danger fw-bold">*</span></label>
                                                <input type="text" class="form-control" id="app_store"
                                                    placeholder="{{ __('App Store Link') }}" name="app_store_url"
                                                    value="{{ $setting->app_store_url }}">
                                                @error('app_store_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 my-auto">
                                        <div class="mb-3 d-flex justify-content-center">
                                            <img id="scanerImagePreview" src="{{ $setting->scanerPath }}"
                                                style="width:100px; height:100px; border-radius:1rem; object-fit: contain">
                                        </div>
                                        <div>
                                            <h4 class="form-label">{{ __('Website QR Scaner') }}(JPG, JPEG, PNG)*
                                            </h4>
                                            <label for="formScanerImage" class="w-100 border rounded-3">
                                                <div class="d-flex justify-content-center align-items-center gap-2 p-3"
                                                    style="width: 160px; background-color: #EDEEF1">
                                                    <span>{{ __('Choose a file') }}</span>
                                                    <img src="/assets/images/media/file-plus.svg">
                                                </div>
                                            </label>
                                            <input name="scaner" class="form-control form-control-lg"
                                                id="formScanerImage" type="file" hidden
                                                onchange="document.getElementById('scanerImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-end">
                                <button type="submit" class="btn btn-lg btn-primary py-2 px-5">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            {{-- content end here --}}

        </div>
    </div>
    <!-- ****Body-Section***** -->
@endsection

@push('styles')
    <style>
        .frontend-visibility-toggle .switch {
            margin-right: .75rem;
            position: relative;
            vertical-align: middle;
            margin-bottom: 0;
            border-radius: 30rem;
            cursor: pointer;
            min-height: 1.35rem;
            font-size: .9375rem;
            line-height: 1.4;
            width: 100% !important;
            display: flex;
            align-items: center;
        }

        .frontend-visibility-toggle .switch-input {
            opacity: 0;
            position: absolute;
            padding: 0;
            margin: 0;
            z-index: -1;
        }

        .frontend-visibility-toggle .switch-primary.switch .switch-input:checked~.switch-toggle-slider,
        .frontend-visibility-toggle .switch-input:checked~.switch-toggle-slider {
            background: #7367f0;
            color: #fff;
            box-shadow: 0 2px 6px 0 rgba(115, 103, 240, .3);
        }

        .frontend-visibility-toggle .switch .switch-toggle-slider {
            width: 2.5rem;
            height: 1.35rem;
            font-size: .625rem;
            line-height: 1.35rem;
            border: 1px solid rgba(0, 0, 0, 0);
            top: 50%;
            transform: translateY(-50%);
        }

        .frontend-visibility-toggle .switch-toggle-slider {
            position: absolute;
            overflow: hidden;
            border-radius: 30rem;
            background: #eaeaec;
            color: rgba(47, 43, 61, .4);
            transition-duration: .2s;
            transition-property: left, right, background, box-shadow;
            cursor: pointer;
            user-select: none;
            box-shadow: 0 0 .25rem 0 rgba(0, 0, 0, .16) inset;
        }

        .frontend-visibility-toggle .switch-input:checked~.switch-toggle-slider .switch-on {
            left: 0;
        }

        .frontend-visibility-toggle .switch .switch-on {
            padding-left: .25rem;
            padding-right: 1.1rem;
        }

        .frontend-visibility-toggle .switch-on {
            left: -100%;
        }

        .frontend-visibility-toggle .switch-off,
        .frontend-visibility-toggle .switch-on {
            height: 100%;
            width: 100%;
            text-align: center;
            position: absolute;
            top: 0;
            transition-duration: .2s;
            transition-property: left, right;
        }

        .frontend-visibility-toggle .switch .switch-toggle-slider i {
            position: relative;
            font-size: .9375rem;
            top: -1.35px;
        }

        .frontend-visibility-toggle .switch-input:checked~.switch-toggle-slider .switch-off {
            left: 100%;
            color: rgba(0, 0, 0, 0);
        }

        .frontend-visibility-toggle .switch .switch-off {
            padding-left: 1.1rem;
            padding-right: .25rem;
        }

        .frontend-visibility-toggle .switch-off {
            left: 0;
        }

        .frontend-visibility-toggle .switch .switch-input~.switch-label {
            padding-left: 3rem;
        }

        .frontend-visibility-toggle .switch .switch-label {
            top: .01875rem;
        }

        .frontend-visibility-toggle .switch-label {
            display: inline-block;
            font-weight: 500;
            color: #444050;
            position: relative;
            cursor: pointer;
            white-space: normal;
            word-break: normal;
        }

        .frontend-visibility-toggle .switch .switch-input:checked~.switch-toggle-slider::after {
            left: 1.05rem;
        }

        .frontend-visibility-toggle .switch .switch-toggle-slider::after {
            margin-left: .25rem;
            width: 14px;
            height: 14px;
        }

        .frontend-visibility-toggle .switch-toggle-slider::after {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            display: block;
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 .0625rem .375rem 0 rgba(47, 43, 61, .1);
            transition-duration: .2s;
            transition-property: left, right, background;
        }
    </style>
@endpush
