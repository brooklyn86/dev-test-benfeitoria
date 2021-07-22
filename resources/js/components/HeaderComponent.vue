<template>
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
</template>
<script>
  import pagination from 'laravel-vue-pagination'
    export default {
        name:"posts",
        components:{
          pagination
          },
        created() {
          this.loadPosts()
        },
        computed: {
            notifications() {
              return this.postsItens
            }
        },

        data() {
          return {
            postsItens: {
              type:Object,
              default:null
            }
          }
        },

        methods:{
          async loadPosts(page=1){
              await axios.get(`/api/posts?page=${page}`).then(({data})=>{
                  this.postsItens = data
              }).catch(({ response })=>{
                  console.error(response)
              })
          }
        }

      
    }
</script>