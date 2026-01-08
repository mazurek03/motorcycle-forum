<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* STYLE DLA OSÓB NIEPEŁNOSPRAWNYCH (WCAG) */
            .high-contrast {
                background-color: #000000 !important;
                color: #ffff00 !important;
            }
            .high-contrast * {
                background-color: #000000 !important;
                color: #ffff00 !important;
                border-color: #ffff00 !important;
            }
            .high-contrast a, .high-contrast button {
                text-decoration: underline !important;
                font-weight: bold !important;
            }
            .high-contrast img {
                filter: grayscale(100%) contrast(150%);
            }
            
            .large-text {
                font-size: 1.25rem !important;
            }
            .large-text p, .large-text span, .large-text a, .large-text div {
                font-size: 1.1em !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            // Skrypt zarządzający ustawieniami dostępności
            document.addEventListener('DOMContentLoaded', function() {
                const body = document.body;
                
                // Ładowanie zapisanych preferencji
                if (localStorage.getItem('high-contrast') === 'true') {
                    body.classList.add('high-contrast');
                }
                if (localStorage.getItem('large-text') === 'true') {
                    body.classList.add('large-text');
                }
            });

            function toggleContrast() {
                document.body.classList.toggle('high-contrast');
                localStorage.setItem('high-contrast', document.body.classList.contains('high-contrast'));
            }

            function toggleFontSize() {
                document.body.classList.toggle('large-text');
                localStorage.setItem('large-text', document.body.classList.contains('large-text'));
            }
        </script>
    </body>
</html>