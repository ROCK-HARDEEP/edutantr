@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit Gallery Item'))
@section('header-title')<h3 class="title">{{ __('Edit Gallery Item') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('college-gallery.update', $item) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('college-gallery._form')
    <button type="submit" class="btn btn-primary mt-3">{{ __('Update') }}</button>
    <a href="{{ route('college-gallery.index') }}" class="btn btn-secondary mt-3">{{ __('Cancel') }}</a>
</form>
</div></div>
@endsection
