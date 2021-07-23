@extends('layouts.app')

@section('content')
<div class="py-5 container">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Novo Post</h5>
      <p class="card-text">Preencha todas as informações para criar um novo post.</p>
        @include('layouts.alerts')
      <form action="{{route('create.post')}}" method="POST" enctype='multipart/form-data'>
        @csrf
          <div class="mb-3">
              <label for="title" class="form-label">Titulo do Post</label>
              <input type="text" class="form-control" name="title" id="title" required>
          </div>
          <div class="mb-3">
              <label for="content" class="form-label">Conteudo do Post</label>
              <textarea class="form-control" name="content" required id="content"></textarea>
          </div>
          <div class="mb-3">
              <label for="category" class="form-label">Categorias do Post</label>
              <select class="form-control" name="category" id="category" required>
                  @foreach($categories as $category)
                  
                  <option value="{{$category->id}}">{{$category->title}}</option>

                  @endforeach

              </select>
          </div>
          <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Imagem do post</label>
              <input type="file" name="image" class="form-control"  required>
          </div>
        
          <button type="submit" class="btn btn-primary">Cadastrar novo post</button>
      </form>
    </div>
  </div>
</div>
@endsection