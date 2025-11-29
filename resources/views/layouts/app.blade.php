<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'SI RT/RW') — SI RT/RW</title>

  <!-- Fonts & Tailwind (optional: you can precompile tailwind in your pipeline) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/lucide@latest/dist/css/lucide.css" rel="stylesheet">

  <!-- App CSS -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

  @stack('head')
</head>
<body>
  <div class="app sidebar-state-open" id="appRoot">
    @include('layouts.sidebar')

    <div class="main">
      @include('layouts.header')

      <main>
        @yield('content')
      </main>
    </div>
  </div>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @stack('scripts')
</body>
</html>
