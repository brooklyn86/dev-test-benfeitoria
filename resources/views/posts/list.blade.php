<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Album example · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
  </head>
  <body> 
    <div id="app">
      <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
          <div class="container">
            <a href="#" class="navbar-brand d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
              <strong>Album</strong>
            </a>
            @if (Route::has('login'))
                  <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                      @auth
                          <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                      @else
                          <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                          @if (Route::has('register'))
                              <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                          @endif
                      @endauth
                  </div>
              @endif
          </div>
        </div>
      </header>
      <main>
        <postlistcomponent></postlistcomponent>
      </main>

      <footer class="text-muted py-5">
        <div class="container">
          <p class="float-end mb-1">
            <a href="#">Back to top</a>
          </p>
          <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
          <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="../getting-started/introduction/">getting started guide</a>.</p>
        </div>
      </footer>
    </div>   
    


    <script src="/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
      
  </body>
</html>