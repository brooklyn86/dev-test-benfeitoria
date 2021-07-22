<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Listagem de Categorias</div>

                    <div class="card-body">
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
                                <td><a :href="`/api/destroy/category/${category.id}`">excluir</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination align="center" :data="categoryItens" @pagination-change-page="loadCategories"></pagination>
                </div>
            </div>
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
