@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Add Gallery Item'))
@section('header-title')<h3 class="title">{{ __('Add Gallery Item') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('college-gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('college-gallery._form')
    <button type="submit" class="btn btn-primary mt-3">{{ __('Create') }}</button>
    <a href="{{ route('college-gallery.index') }}" class="btn btn-secondary mt-3">{{ __('Cancel') }}</a>
</form>
</div></div>
@endsection
