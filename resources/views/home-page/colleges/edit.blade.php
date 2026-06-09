@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit College'))
@section('header-title')<h3 class="title">{{ __('Edit Partner College') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('partner-college.update', $college) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT') @include('home-page.colleges._form', ['college' => $college])
<button type="submit" class="btn btn-primary mt-3">{{ __('Update') }}</button></form>
</div></div>
@endsection
