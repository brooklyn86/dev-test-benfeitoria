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
              <img src="/imgs/white.png" alt="benfetoria" width="50%"/>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                @auth
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Postagens
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{route('create.post.view')}}">Cadastrar novo post</a></li>
                    <li><a class="dropdown-item" href="{{route('list.post')}}">Listar Postagens</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Categorias
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{route('create.category.view')}}">Cadastrar nova categoria</a></li>
                    <li><a class="dropdown-item" href="{{route('list.category')}}">Listar Categorias</a></li>
                  </ul>
                </li>
                @endauth
                @if (Route::has('login'))
                  <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                      @auth
                          <li class="nav-item">
                            <a class="nav-link" href="#">Olá {{auth()->user()->name}}</a>
                          </li>
                      @else
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                          </li>
                        @if (Route::has('register'))
                          <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Cadastre-se</a>
                          </li> 
                        @endif
                      @endauth
                  </div>
              @endif
              </ul>

            </div>
            
          </div>
        </div>
      </header>
      <main>
        <div class="py-5 container">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Novo Post</h5>
              <p class="card-text">Preencha todas as informações para criar um novo post.</p>
              <form action="{{route('create.post')}}" method="POST" enctype='multipart/form-data'>
                @csrf
                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Titulo do Post</label>
                      <input type="text" class="form-control" name="title" id="title" required>
                  </div>
                  <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Conteudo do Post</label>
                      <textarea class="form-control" name="content" required></textarea>
                  </div>
                  <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Categorias do Post</label>
                      <select class="form-control" name="category" required>
                          @foreach($categories as $category)
                          
                          <option value="{{$category->id}}">{{$category->title}}</option>

                          @endforeach

                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Imagem do post</label>
                      <input type="file" name="image" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                  </div>
                
                  <button type="submit" class="btn btn-primary">Cadastrar novo post</button>
              </form>
            </div>
          </div>
        </div>
      </main>

    </div>   
    


    <script src="/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
      
  </body>
</html>