@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit Statistic'))
@section('header-title')<h3 class="title">{{ __('Edit Statistic') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('home-statistic.update', $statistic) }}" method="POST">@csrf @method('PUT') @include('home-page.statistics._form', ['statistic' => $statistic])
<button type="submit" class="btn btn-primary mt-3">{{ __('Update') }}</button></form>
</div></div>
@endsection
