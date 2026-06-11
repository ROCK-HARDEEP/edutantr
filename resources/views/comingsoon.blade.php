<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting?->coming_soon_title ?? __('Coming Soon') }} | Edutantr</title>
    <link rel="shortcut icon" href="{{ $setting?->faviconPath ?? asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-dark: #0f4d2a;
            --green-mid: #1a7a45;
            --green-brand: #22c55e;
            --green-light: #4ade80;
            --green-glow: rgba(34, 197, 94, 0.35);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        body {
            min-height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: linear-gradient(135deg, #052e16 0%, #14532d 28%, #16a34a 58%, #22c55e 82%, #4ade80 100%);
            position: relative;
        }

        .bg-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.45;
            pointer-events: none;
            animation: float 8s ease-in-out infinite;
        }

        .bg-orb--1 {
            width: 320px;
            height: 320px;
            background: #86efac;
            top: -80px;
            left: -60px;
        }

        .bg-orb--2 {
            width: 280px;
            height: 280px;
            background: #15803d;
            bottom: -60px;
            right: -40px;
            animation-delay: -3s;
        }

        .bg-orb--3 {
            width: 200px;
            height: 200px;
            background: #bbf7d0;
            top: 40%;
            right: 12%;
            animation-delay: -5s;
        }

        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
            pointer-events: none;
        }

        .coming-soon-wrap {
            width: 100%;
            max-width: 680px;
            position: relative;
            z-index: 1;
            animation: rise 0.8s ease-out both;
        }

        .coming-soon-card {
            text-align: center;
            padding: 56px 40px 48px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow:
                0 24px 64px rgba(0, 0, 0, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.35);
        }

        .brand-logo {
            display: inline-block;
            font-size: clamp(2.4rem, 6vw, 3.4rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 28px;
            color: #ffffff;
            text-shadow: 0 2px 16px rgba(0, 0, 0, 0.15);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            margin-bottom: 24px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #ecfdf5;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green-light);
            box-shadow: 0 0 0 0 var(--green-glow);
            animation: pulse 2s infinite;
        }

        .coming-soon-card h1 {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 700;
            line-height: 1.2;
            color: #ffffff;
            margin: 0 0 16px;
            letter-spacing: -0.02em;
        }

        .coming-soon-card p {
            font-size: clamp(1rem, 2.2vw, 1.125rem);
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.82);
            margin: 0 auto 32px;
            max-width: 520px;
        }

        .progress-bar {
            width: 100%;
            max-width: 280px;
            height: 4px;
            margin: 0 auto;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.15);
            overflow: hidden;
        }

        .progress-bar span {
            display: block;
            height: 100%;
            width: 65%;
            border-radius: inherit;
            background: linear-gradient(90deg, #4ade80, #ffffff);
            animation: shimmer 2.4s ease-in-out infinite;
        }

        .footer-note {
            margin-top: 28px;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.55);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-24px) scale(1.05); }
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 var(--green-glow); }
            70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        @keyframes shimmer {
            0%, 100% { transform: translateX(-10%); opacity: 0.7; }
            50% { transform: translateX(60%); opacity: 1; }
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(28px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .coming-soon-card {
                padding: 40px 24px 36px;
                border-radius: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-orb bg-orb--1"></div>
    <div class="bg-orb bg-orb--2"></div>
    <div class="bg-orb bg-orb--3"></div>
    <div class="grid-overlay"></div>

    <div class="coming-soon-wrap">
        <div class="coming-soon-card">
            <div class="brand-logo">Edutantr</div>

            <div class="status-pill">
                <span class="status-dot"></span>
                {{ __('Coming Soon') }}
            </div>

            <h1>{{ $setting?->coming_soon_title ?? __('Under Construction') }}</h1>
            <p>{{ $setting?->coming_soon_message ?? __('Our website is currently under development. We are working hard to bring you an exciting new experience. Please check back soon.') }}</p>

            <div class="progress-bar" aria-hidden="true">
                <span></span>
            </div>

            <p class="footer-note">&copy; {{ date('Y') }} Edutantr. {{ __('All rights reserved.') }}</p>
        </div>
    </div>
</body>

</html>
