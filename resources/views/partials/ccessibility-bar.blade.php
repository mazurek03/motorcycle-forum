<div class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-3">
    <button onclick="toggleContrast()" title="Wysoki kontrast" class="bg-black border-2 border-yellow-400 text-yellow-400 w-14 h-14 rounded-full flex items-center justify-center font-black text-xl shadow-2xl hover:scale-110 transition-transform active:scale-95">
        👁️
    </button>
    <button onclick="toggleFontSize()" title="Powiększ tekst" class="bg-blue-600 border-2 border-white text-white w-14 h-14 rounded-full flex items-center justify-center font-black text-xl shadow-2xl hover:scale-110 transition-transform active:scale-95">
        A+
    </button>
</div>

<style>
    /* Zapobieganie nachodzeniu elementów przy powiększaniu */
    body.large-text {
        font-size: 1.25rem !important;
    }
    .large-text p, .large-text span, .large-text h1, .large-text h2, .large-text h3, 
    .large-text label, .large-text input, .large-text button, .large-text div {
        font-size: 1.1em !important;
        line-height: 1.7 !important; /* Większy odstęp między liniami */
    }
    .large-text .max-w-7xl, .large-text .container {
        max-width: 95% !important;
        width: 95% !important;
    }
    .large-text nav, .large-text header {
        height: auto !important;
        min-height: 70px;
    }

    /* Wysoki kontrast */
    body.high-contrast {
        background-color: #000000 !important;
        color: #ffff00 !important;
    }
    .high-contrast * {
        background-color: #000000 !important;
        color: #ffff00 !important;
        border-color: #ffff00 !important;
        box-shadow: none !important;
    }
    .high-contrast a {
        text-decoration: underline !important;
        color: #00ffff !important;
    }
</style>

<script>
    function toggleContrast() {
        document.body.classList.toggle('high-contrast');
        localStorage.setItem('high-contrast', document.body.classList.contains('high-contrast'));
    }

    function toggleFontSize() {
        document.body.classList.toggle('large-text');
        localStorage.setItem('large-text', document.body.classList.contains('large-text'));
    }

    // Aplikowanie zapisanych ustawień przy starcie
    if (localStorage.getItem('high-contrast') === 'true') document.body.classList.add('high-contrast');
    if (localStorage.getItem('large-text') === 'true') document.body.classList.add('large-text');
</script>