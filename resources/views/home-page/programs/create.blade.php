@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Add Program'))
@section('header-title')<h3 class="title">{{ __('Add Hero Program') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('home-program.store') }}" method="POST" enctype="multipart/form-data">@csrf
@include('home-page.programs._form')
<div class="text-end mt-3"><button type="submit" class="btn btn-primary">{{ __('Create') }}</button></div>
</form>
</div></div>
@endsection
