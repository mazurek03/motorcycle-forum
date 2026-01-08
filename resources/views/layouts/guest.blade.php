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
<body class="font-sans text-gray-900 antialiased">
    <div style="position: absolute; top: 20px; right: 20px; z-index: 1000; display: flex; gap: 10px;">
        <button onclick="toggleAccessibility('contrast')" style="background: white; color: black; border: 2px solid black; padding: 8px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            👁️ KONTRAST
        </button>
        <button onclick="toggleAccessibility('font')" style="background: white; color: black; border: 2px solid black; padding: 8px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            A+ TEKST
        </button>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>

    <script>
        function updateAccessibilityStyles() {
            const isContrast = localStorage.getItem('hc') === 'true';
            const isFont = localStorage.getItem('lt') === 'true';
            const styleTag = document.getElementById('accessibility-css');
            let css = '';
            if (isContrast) {
                css += `
                    html, body, div, form, input, button, label { background-color: #000 !important; color: #ff0 !important; border-color: #ff0 !important; }
                    input { background: #000 !important; border: 2px solid #ff0 !important; }
                `;
            }
            if (isFont) {
                css += `html { font-size: 130% !important; }`;
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