<template>
  <div class="album py-5 bg-light">
    <div class="container">
      <div v-if="postsItens && postsItens.data.length > 0">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <div v-for="(post, index) in postsItens.data" :key="index">
            <div class="col">
              <div class="card shadow-sm">
                <img class="bd-placeholder-img card-img-top" :src="`/storage/${post.url_image}`"  width="100%" height="225"/>
                <div class="card-body">
                  <p class="card-text">{{post.title}}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">Ver Mais</button>
                    </div>
                    <small class="text-muted">Autor: {{post.author}}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <pagination align="center" :data="postsItens" @pagination-change-page="loadPosts"></pagination>
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
