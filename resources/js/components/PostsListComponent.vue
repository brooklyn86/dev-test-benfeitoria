<template>
    <div class="py-5 container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <table class="table" id="posts" >
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                    <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody v-for="(post, index) in postsItens.data" :key="index">
                                <tr>
                                <th scope="row">{{post.id}}</th>
                                <td>{{post.title}}</td>
                                <td>{{post.author}}</td>
                                <td>{{post.created_at}}</td>
                                <td><a :href="`/api/destroy/post/${post.id}`">excluir</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination align="center" :data="postsItens" @pagination-change-page="loadPosts"></pagination>
                </div>
            </div>
        </div>
    </div>
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
<style scoped>
    .pagination{
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
