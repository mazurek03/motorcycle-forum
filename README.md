# 🏍️ Motorcycle Forum - System Zarządzania Społecznością

Profesjonalne forum dyskusyjne dla pasjonatów motocykli, zbudowane w oparciu o framework **Laravel 12**. Projekt implementuje zaawansowany system uprawnień (RBAC), moderację treści oraz mechanizmy bezpieczeństwa.

## 🚀 Główne Funkcjonalności

### 👤 System Użytkowników i Uprawnień (RBAC)
Aplikacja rozróżnia trzy poziomy uprawnień:
* **Administrator (Rola 1):** Pełna kontrola nad systemem. Zarządza kadrą (nadaje/odbiera rolę Workera) oraz ma dostęp do wszystkich narzędzi moderacyjnych.
* **Worker/Moderator (Rola 2):** Odpowiada za porządek na forum. Może usuwać dowolne posty i komentarze oraz nakładać czasowe blokady (bany) na użytkowników.
* **Klient (Rola 3):** Standardowy użytkownik. Może przeglądać treści, tworzyć własne posty oraz komentować wpisy innych.

### 🚫 System Banowania i Bezpieczeństwa
* **Middleware `CheckBanned`:** Autorski mechanizm ochronny, który przy każdym żądaniu sprawdza status użytkownika. Zbanowani użytkownicy są natychmiast wylogowywani z systemu.
* **Blokady Czasowe:** Możliwość nałożenia bana na 1, 7 lub 30 dni bezpośrednio z panelu pracownika.
* **Integracja z Carbon:** Precyzyjne wyliczanie czasu blokady i automatyczne przywracanie dostępu po wygaśnięciu kary.

### 🛠️ Panel Zarządzania (Worker Panel)
Dedykowany interfejs dla administracji (`/worker/panel`), oferujący:
* Statystyki bazy danych w czasie rzeczywistym.
* Tabelę moderacji wpisów z szybkim usuwaniem.
* Moduł zarządzania użytkownikami z dynamicznym statusem "Aktywny/Zablokowany".

## 💻 Technologia
* **Backend:** PHP 8.2+ / Laravel 12.45
* **Frontend:** Tailwind CSS / Blade Templates
* **Baza danych:** MySQL (XAMPP)
* **Zarządzanie czasem:** Carbon Library
* **Autentykacja:** Laravel Breeze (modyfikowany)

## 🔧 Instalacja i Uruchomienie

1. **Klonowanie repozytorium:**
   ```bash
   git clone [https://github.com/TwojUser/motorcycle-forum.git](https://github.com/TwojUser/motorcycle-forum.git)
   cd motorcycle-forum
