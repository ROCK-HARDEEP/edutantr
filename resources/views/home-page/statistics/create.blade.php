@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Add Statistic'))
@section('header-title')<h3 class="title">{{ __('Add Statistic') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('home-statistic.store') }}" method="POST">@csrf @include('home-page.statistics._form')
<button type="submit" class="btn btn-primary mt-3">{{ __('Create') }}</button></form>
</div></div>
@endsection
