@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit Placement'))
@section('header-title')<h3 class="title">{{ __('Edit Placement') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('home-placement.update', $placement) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT') @include('home-page.placements._form', ['placement' => $placement])
<button type="submit" class="btn btn-primary mt-3">{{ __('Update') }}</button></form>
</div></div>
@endsection
