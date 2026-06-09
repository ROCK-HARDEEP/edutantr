@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit Program'))
@section('header-title')<h3 class="title">{{ __('Edit Hero Program') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('home-program.update', $program) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
@include('home-page.programs._form', ['program' => $program])
<div class="text-end mt-3"><button type="submit" class="btn btn-primary">{{ __('Update') }}</button></div>
</form>
</div></div>
@endsection
