<template>
    <div class="py-5 container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Listagem de Posts</h5>

                    <div class="py-5 row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Titulo</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="inputPassword6"  v-model="title" class="form-control" aria-describedby="passwordHelpInline">
                        </div>
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Categoria</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-control" v-model="category"  id="categoria" >
                                <option value="">Selecione uma Categoria</option>
                                <option v-for="(c, index) in categoryItens.data" :key="index" :value="`${c.id}`">{{c.title}}</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Autor</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="inputPassword6"  v-model="author" class="form-control" aria-describedby="passwordHelpInline">
                        </div>
                        <div class="col-auto">
                            <button type="button" @click="loadPosts" class="btn btn-primary">Filtrar</button>
                        </div>
                    </div>
                    <table class="table" id="posts" >
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Data de criação</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody v-for="(post, index) in postsItens.data" :key="index">
                            <tr>
                            <th scope="row">{{post.id}}</th>
                            <td>{{post.title}}</td>
                            <td>{{post.author}}</td>
                            <td>{{getHumanDate(post.created_at)}}</td>
                            <td><a :href="`/api/destroy/post/${post.id}`"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <pagination align="center" :data="postsItens" @pagination-change-page="loadPosts"></pagination>
            </div>
        </div>
    </div>
</template>
<script>
    import pagination from 'laravel-vue-pagination'
    import moment from 'moment'
    export default {
        name:"posts",
        components:{
            pagination
        },
        created() {
          this.loadPosts()
          this.loadCategory()
        },
        computed: {
            posts() {
              return this.postsItens
            },
            categories() {
              return this.categoryItens
            }
        },

        data() {
          return {
            title: '',
            category: '',
            author: '',
            postsItens: {
              type:Object,
              default:null
            },
            categoryItens: {
              type:Object,
              default:null
            }
          }
        },

        methods:{
          async loadPosts(page=1){
              await axios.get(`/api/posts?page=${page}&title=${this.title}&category=${this.category}&author=${this.author}`).then(({data})=>{
                  this.postsItens = data
              }).catch(({ response })=>{
                  console.error(response)
              })
          },
           async loadCategory(page=1){
              await axios.get(`/api/categories`).then(({data})=>{
                  this.categoryItens = data
              }).catch(({ response })=>{
                  console.error(response)
              })
          },
          getHumanDate : function (date) {
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
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
