@extends('layouts.app')

@section('content')
<div class="py-5 container">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Nova Categoria</h5>
      <p class="card-text">Preencha todas as informações para criar um novo post.</p>
      @include('layouts.alerts')
      <form action="{{route('create.category')}}" method="POST" >
        @csrf
          <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Nome da categoria</label>
              <input type="text" class="form-control" name="title" id="title" required>
          </div>
        
          <button type="submit" class="btn btn-primary">Cadastrar novo post</button>
      </form>
    </div>
  </div>
</div>
@endsection

