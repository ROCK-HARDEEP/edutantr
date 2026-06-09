@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Add Placement'))
@section('header-title')<h3 class="title">{{ __('Add Placement') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('home-placement.store') }}" method="POST" enctype="multipart/form-data">@csrf @include('home-page.placements._form')
<button type="submit" class="btn btn-primary mt-3">{{ __('Create') }}</button></form>
</div></div>
@endsection
