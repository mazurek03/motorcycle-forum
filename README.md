# PROJEKT APLIKACJE INTERNETOWE 2026

**Autor:** [Michał Mazurek]  
**Numer Indeksu:** [21265]

---

## 1. Tematyka i cel projektu
Głównym celem projektu było stworzenie nowoczesnego forum dyskusyjnego dla społeczności motocyklowej – **MotoForum**. Aplikacja umożliwia wymianę doświadczeń, zadawanie pytań technicznych oraz integrację użytkowników poprzez tworzenie wątków tematycznych.

![Strona Główna](FileHelp/[LOGO].PNG)

---

## 2. Funkcje dla użytkowników niezalogowanych
Osoby odwiedzające stronę bez konta mają możliwość:
* Przeglądania najnowszych dyskusji na stronie głównej.
* Korzystania z funkcji dostępności (WCAG) – zmiana kontrastu i powiększanie tekstu.
* Dostępu do formularzy rejestracji i logowania.

![Ekran Gościa](FileHelp/[PanelGlowny].PNG)

---

## 3. Funkcje dla użytkowników zalogowanych
Po uwierzytelnieniu użytkownik uzyskuje dostęp do:
* Tworzenia nowych tematów (postów) w wybranych kategoriach.
* Komentowania istniejących wątków.
* Edycji własnego profilu i zmiany danych osobowych.
* Panelu Dashboard z podsumowaniem aktywności.

![Panel Użytkownika](FileHelp/[nazwa_zdjecia].PNG)

---

## 4. Panel Zarządzania (Role i Uprawnienia)
Aplikacja posiada system ról (użytkownik, pracownik/moderator, administrator). Osoby z odpowiednimi uprawnieniami mają dostęp do specjalnego panelu, który pozwala na:
* Moderację treści (usuwanie postów/komentarzy).
* Zarządzanie kategoriami forum.
* Przegląd statystyk serwisu.
* Administrator może zmieniać role urzytkowników

![Panel Zarządzania](FileHelp/[nazwa_zdjecia].PNG)

---

## 5. Dostępność (WCAG 2.1)
Projekt został dostosowany do potrzeb osób słabowidzących poprzez:
* **Wysoki Kontrast:** Tryb czarno-żółty wymuszający czytelność elementów.
* **Skalowanie Tekstu:** Możliwość powiększenia czcionki o 35% bez rozbijania układu strony.
* **Trwałość ustawień:** Wykorzystanie `localStorage` do zapamiętywania preferencji użytkownika.

![Dostępność WCAG](FileHelp/[nazwa_zdjecia].PNG)

---

## 6. Wykorzystane technologie
* **Backend:** Laravel (PHP)
* **Frontend:** Blade, Tailwind CSS, JavaScript (Alpine.js)
* **Baza Danych:** MySQL / MariaDB
* **Narzędzia:** Vite, Composer, NPM

![Technologie](FileHelp/[nazwa_zdjecia].PNG)

---

## 7. Instrukcja uruchomienia projektu
1. Skopiuj repozytorium.
2. Wykonaj `composer install` oraz `npm install`.
3. Skonfiguruj plik `.env` (baza danych).
4. Wykonaj migracje: `php artisan migrate --seed`.
5. Uruchom serwer: `php artisan serve` oraz `npm run dev`.

![Instalacja](FileHelp/[nazwa_zdjecia].PNG)