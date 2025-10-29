<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leekha — A Digital Space for Words, Emotions & Stories</title>

    <!-- ✅ SEO Meta Tags -->
    <meta name="description" content="Leekha — a modern digital platform for writers, readers, and dreamers. Discover stories, poems, and creative writings that connect emotions and art.">
    <meta name="keywords" content="Leekha, writing, stories, poems, digital literature, creative platform, Indian writers, emotional storytelling, art and words, blog, literature platform">
    <meta name="author" content="Leekha Team">
    <meta name="robots" content="index, follow">

    <!-- ✅ Open Graph / Social Preview -->
    <meta property="og:title" content="Leekha — A Digital Space for Words, Emotions & Stories">
    <meta property="og:description" content="A modern space where words find rhythm. Share your stories, feel emotions, and explore creativity with Leekha.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('images/leekha-preview.jpg') }}">
    <meta property="og:locale" content="en_IN">

    <!-- ✅ Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Leekha — A Digital Space for Words, Emotions & Stories">
    <meta name="twitter:description" content="A modern storytelling platform for dreamers, writers, and thinkers.">
    <meta name="twitter:image" content="{{ asset('images/leekha-preview.jpg') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
      body {
        font-family: 'Inter', sans-serif;
        transition: background-color 0.4s, color 0.4s;
        min-height: 100vh;
        overflow-x: hidden;
      }

      .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 1s ease-out forwards;
      }

      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }

      /* 🌙 Dark and ☀️ Light themes */
      body.dark {
        background: radial-gradient(circle at 20% 30%, #1f2937, #0f172a);
        color: #f8fafc;
      }

      body.light {
        background: radial-gradient(circle at 20% 30%, #f8fafc, #e2e8f0);
        color: #1a202c;
      }

      /* 🌌 Subtle Floating Background Motion */
      body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.05), transparent 70%),
                    radial-gradient(circle at 80% 70%, rgba(255,255,255,0.04), transparent 70%);
        animation: float 10s ease-in-out infinite alternate;
        z-index: -1;
      }

      @keyframes float {
        from { transform: translateY(0px); }
        to { transform: translateY(-15px); }
      }

      .theme-toggle {
        cursor: pointer;
        transition: transform 0.3s ease;
      }

      .theme-toggle:hover {
        transform: rotate(15deg);
      }
    </style>
  </head>

  <body class="dark flex flex-col items-center justify-center text-center px-6">
    <!-- Navbar -->
    <nav class="absolute top-0 left-0 w-full flex justify-between items-center px-8 py-4">
      <h1 class="text-2xl font-bold tracking-wide">Leekha</h1>
      
      <div class="flex items-center gap-4">
        <!-- Theme Toggle -->
        <button id="theme-toggle" class="theme-toggle text-xl" aria-label="Toggle theme">🌙</button>

        <!-- Login Button -->
        <a href="/admin/login"
           class="px-5 py-2 text-sm font-semibold bg-white text-gray-900 rounded-full shadow hover:bg-gray-200 transition dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
           Login
        </a>
      </div>
    </nav>

    <!-- Hero -->
    <main class="flex flex-col justify-center items-center h-screen fade-in">
      <h1 class="text-5xl sm:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-purple-400 via-pink-500 to-red-400">
        Welcome to Leekha
      </h1>
      <p class="text-gray-300 dark:text-gray-300 text-lg sm:text-xl max-w-2xl mb-8">
        A digital space for words, emotions, and stories.<br>
        Let your thoughts find their rhythm here.
      </p>

      <div class="flex gap-4">
        <a href="/admin/login"
           class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-full shadow-lg font-semibold transition">
           Get Started
        </a>
        <a href="#about"
           class="px-6 py-3 border border-gray-400 hover:border-white dark:hover:border-gray-300 text-gray-200 hover:text-white rounded-full transition">
           Learn More
        </a>
      </div>
    </main>

    <!-- About -->
    <section id="about" class="py-20 max-w-4xl mx-auto text-center fade-in">
      <h2 class="text-3xl font-semibold mb-4">What is Leekha?</h2>
      <p class="text-gray-400 dark:text-gray-400 text-lg leading-relaxed">
        Leekha is a storytelling platform crafted for dreamers, writers, and thinkers.  
        It’s designed to give your words a digital soul — where creativity meets calm simplicity.
      </p>
    </section>

    <!-- Footer -->
    <footer class="py-6 border-t border-gray-700 text-gray-500 text-sm w-full text-center">
      © {{ date('Y') }} Leekha — All Rights Reserved.
      <div class="mt-2 flex justify-center gap-4">
        <a href="#" class="hover:text-gray-300">Instagram</a>
        <a href="mailto:contact@leekha.com" class="hover:text-gray-300">Contact</a>
      </div>
    </footer>

    <!-- Theme Toggle Script -->
    <script>
      const themeToggle = document.getElementById('theme-toggle');
      const body = document.body;

      const savedTheme = localStorage.getItem('theme');
      if (savedTheme) {
        body.classList.remove('light', 'dark');
        body.classList.add(savedTheme);
        themeToggle.textContent = savedTheme === 'dark' ? '🌙' : '☀️';
      } else {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        body.classList.add(prefersDark ? 'dark' : 'light');
        themeToggle.textContent = prefersDark ? '🌙' : '☀️';
      }

      themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark');
        body.classList.toggle('light');
        const newTheme = body.classList.contains('dark') ? 'dark' : 'light';
        themeToggle.textContent = newTheme === 'dark' ? '🌙' : '☀️';
        localStorage.setItem('theme', newTheme);
      });
    </script>
  </body>
</html>
