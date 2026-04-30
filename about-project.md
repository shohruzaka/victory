# 🎮 QuizArena - Gamifikatsiyalashgan Ta'lim Platformasi

QuizArena — bu universitet talabalari o'rtasida o'quv jarayonini (xususan C++ va boshqa dasturlash fanlari bo'yicha) qiziqarli musobaqaga aylantirish uchun mo'ljallangan interaktiv test platformasi. Loyihaning asosiy maqsadi talabalarni zerikarli testlardan qutqarib, bilimni mustahkamlashni qiziqarli o'yin (gamification) orqali amalga oshirishdir.

## 🛠 Texnologik Stek (TALL Stack + MySQL)

Platforma to'liq zamonaviy va tezkor ishlashi uchun quyidagi arxitektura asosida qurilgan:

* **Backend:** Laravel (PHP) - Xavfsizlik, biznes-mantiq va ma'lumotlarni qayta ishlash.
* **Ma'lumotlar Bazasi:** MySQL - Relyatsion ma'lumotlar va murakkab aloqalarni saqlash uchun.
* **Frontend (Reaktivlik):** Laravel Livewire & Alpine.js - Sahifani yangilamasdan tezkor ishlash (SPA hissi) va frontend mantiqi uchun.
* **UI/UX Dizayn:** Tailwind CSS & DaisyUI - "Dark Mode" va kiberpank (neon) elementlariga ega o'yin muhitini yaratish.
* **Real-time (Jonli muloqot):** Laravel Reverb - Talabalar o'rtasidagi duel va jonli reytinglar uchun.

## 🚀 Asosiy Imkoniyatlar (O'yin Rejimlari)

Platforma an'anaviy yondashuvdan voz kechib, 4 xil dinamik rejimni taklif etadi:

1. **📚 Classic (Klassik):** Vaqt chegarasisiz, erkin tartibda savollarga javob berish va mavzularni o'zlashtirish (masalan, OOP prinsiplari yoki ko'rsatkichlar bo'yicha tayyorgarlik).
2. **⏱️ Speed Run (Tezlik sinovi):** Berilgan vaqt ichida imkon qadar ko'proq to'g'ri javob topish. Tezlik uchun maxsus bonus ballar beriladi.
3. **🔥 Survival (Omon qolish):** Xato qilish huquqisiz o'yin! Bitta xato javob belgilangunga qadar qiyinlashib boruvchi cheksiz savollar oqimi.
4. **⚔️ Duel (Yakkama-yakka):** Ikki talaba bir vaqtning o'zida bir xil savollar ustida jonli efirda bellashadi. Tez va to'g'ri javob bergan g'olib bo'ladi.

## 🏆 Reyting Tizimi (Leaderboard)

Talabalarning umumiy to'plagan ballari (XP - Experience Points) doimiy hisoblab boriladi va "Top-10" peshqadamlar jadvalida namoyish etiladi. Haftalik va oylik reytinglar raqobat hissini doimiy yuqori ushlab turadi.
