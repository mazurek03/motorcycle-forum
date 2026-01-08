<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style id="accessibility-css"></style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{{ $header }}</div>
            </header>
        @endisset
        <main>{{ $slot }}</main>
    </div>

    <script>
        function updateAccessibilityStyles() {
            const isContrast = localStorage.getItem('hc') === 'true';
            const isFont = localStorage.getItem('lt') === 'true';
            const styleTag = document.getElementById('accessibility-css');
            let css = '';
            if (isContrast) {
                css += `
                    html, body, div, nav, main, header, section, table, td, tr, th { background-color: #000 !important; color: #ff0 !important; border-color: #ff0 !important; background-image: none !important; }
                    a, button { color: #ff0 !important; text-decoration: underline !important; border: 1px solid #ff0 !important; }
                    svg { fill: #ff0 !important; }
                    input, textarea, select { background-color: #000 !important; color: #ff0 !important; border: 2px solid #ff0 !important; }
                `;
            }
            if (isFont) {
                css += `html { font-size: 130% !important; } body, p, span, a, div, input, button { line-height: 1.7 !important; }`;
            }
            styleTag.innerHTML = css;
        }

        function toggleAccessibility(type) {
            if (type === 'contrast') {
                localStorage.setItem('hc', localStorage.getItem('hc') === 'true' ? 'false' : 'true');
            } else {
                localStorage.setItem('lt', localStorage.getItem('lt') === 'true' ? 'false' : 'true');
            }
            updateAccessibilityStyles();
        }
        document.addEventListener('DOMContentLoaded', updateAccessibilityStyles);
    </script>
</body>
</html>