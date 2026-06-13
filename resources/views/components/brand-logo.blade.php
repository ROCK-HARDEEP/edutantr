@props([
    'href' => null,
    'logo' => null,
    'alt' => null,
    'variant' => 'default',
    'size' => 'md',
    'centered' => false,
    'iconOnly' => false,
])

@php
    $tag = $href ? 'a' : 'span';
    $logoSrc = $logo ?? ($app_setting['logo'] ?? null);
    $logoAlt = $alt ?? ($app_setting['name'] ?? 'Home');
    $classes = trim(implode(' ', array_filter([
        'brand-logo',
        'brand-logo--' . $size,
        'brand-logo--' . $variant,
        $centered ? 'brand-logo--centered' : '',
        $logoSrc ? 'brand-logo--has-image' : '',
    ])));
@endphp

<{{ $tag }} @if ($href) href="{{ $href }}" @endif {{ $attributes->merge(['class' => $classes, 'aria-label' => $logoAlt]) }}>
    @if ($logoSrc)
        <img
            src="{{ $logoSrc }}"
            alt="{{ $logoAlt }}"
            class="brand-logo__image{{ $iconOnly ? ' brand-logo__image--icon-only' : '' }}"
        />
    @else
        <span class="brand-logo__icon" aria-hidden="true">
            <i class="bi bi-mortarboard-fill"></i>
        </span>
        @unless ($iconOnly)
            <span class="brand-logo__wordmark">
                <span class="brand-logo__edu">Edu</span><span class="brand-logo__tantr">tantr</span>
            </span>
        @endunless
    @endif
</{{ $tag }}>
