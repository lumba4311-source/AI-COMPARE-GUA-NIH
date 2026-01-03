⚡ AI Compare — Gemma vs Nemotron

AI Compare adalah aplikasi web berbasis PHP + JavaScript yang membandingkan output dua model AI (Gemma & Nemotron) secara berdampingan menggunakan OpenRouter API.
UI menggunakan konsep glassmorphism, sidebar interaktif, dan render Markdown real-time.

🚀 Fitur Utama

    🔁 Perbandingan 2 model AI sekaligus

    📡 Streaming output (fake-stream / character-based)

    🧠 Render Markdown (heading, list, code block)

    🧊 Glass UI + animasi halus

    📱 Sidebar collapse

    ⬆⬇ Scroll control interaktif

🧱 Teknologi yang Digunakan

    Frontend:

        HTML5

        CSS3 (Glassmorphism, Animation)

        Bootstrap 5

        Boxicons

        Marked.js (Markdown parser)

    Backend:

        PHP 8+

        cURL

        Server-Sent Events (SSE – fake stream)

    API:

        OpenRouter.ai


📂 Struktur File
/
├── index.php        # UI utama & logic frontend
├── stream.php       # Backend AI request (fake streaming)
├── style.css        # Styling global & markdown output
├── logo.png
└── README.md

📌 Catatan Penting

    Streaming bukan streaming asli OpenRouter, tetapi fake streaming

    Aman untuk shared hosting

    Tidak membutuhkan WebSocket

    Fokus pada UX dan visual clarity

👤 Author

    AI Compare
    Dibangun sebagai project UAS Kecerdasan Buatan Semester 5
    oleh Surya Dwiky Candra Wijaya  🚀