@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit Logo'))
@section('header-title')<h3 class="title">{{ __('Edit Partner Logo') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('partner-logo.update', $logo) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT') @include('home-page.logos._form', ['logo' => $logo])
<button type="submit" class="btn btn-primary mt-3">{{ __('Update') }}</button></form>
</div></div>
@endsection
