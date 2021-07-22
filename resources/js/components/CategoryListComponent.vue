<template>
    <div class="py-5 container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Listagem de Categorias</h5>
                <p class="card-text">Liastagem de todas as categorias.</p>

                <table class="table" id="posts" >
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome da Categoria</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody v-for="(category, index) in categoryItens.data" :key="index">
                        <tr>
                        <th scope="row">{{category.id}}</th>
                        <td>{{category.title}}</td>
                        <td><a class="btn btn-danger" :href="`/api/destroy/category/${category.id}`"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pagination align="center" :data="categoryItens" @pagination-change-page="loadCategories"></pagination>
        </div>
    </div>
</template>
<script>
  import pagination from 'laravel-vue-pagination'
    export default {
        name:"categories",
        components:{
          pagination
          },
        created() {
          this.loadCategories()
        },
        computed: {
            categories() {
              return this.categoryItens
            }
        },

        data() {
          return {
            categoryItens: {
              type:Object,
              default:null
            }
          }
        },

        methods:{
          async loadCategories(page=1){
              await axios.get(`/api/categories?page=${page}`).then(({data})=>{
                  this.categoryItens = data
              }).catch(({ response })=>{
                  console.error(response)
              })
          }
        }

      
    }
</script>
<style scoped>
    .pagination{
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
