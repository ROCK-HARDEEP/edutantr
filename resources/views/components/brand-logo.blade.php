@props([
    'href' => null,
    'variant' => 'default',
    'size' => 'md',
    'centered' => false,
    'iconOnly' => false,
])

@php
    $tag = $href ? 'a' : 'span';
    $classes = trim(implode(' ', array_filter([
        'brand-logo',
        'brand-logo--' . $size,
        'brand-logo--' . $variant,
        $centered ? 'brand-logo--centered' : '',
    ])));
@endphp

<{{ $tag }} @if ($href) href="{{ $href }}" @endif {{ $attributes->merge(['class' => $classes, 'aria-label' => 'Edutantr Home']) }}>
    <span class="brand-logo__icon" aria-hidden="true">
        <i class="bi bi-mortarboard-fill"></i>
    </span>
    @unless ($iconOnly)
        <span class="brand-logo__wordmark">
            <span class="brand-logo__edu">Edu</span><span class="brand-logo__tantr">tantr</span>
        </span>
    @endunless
</{{ $tag }}>
