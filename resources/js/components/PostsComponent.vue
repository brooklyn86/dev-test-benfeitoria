<template>
  <div class="album py-5 bg-light">
    <div class="container">
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
          <!-- <input type="text" id="inputPassword6" v-model="category" class="form-control" aria-describedby="passwordHelpInline"> -->
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
      <div v-if="postsItens && postsItens.data.length > 0">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <div v-for="(post, index) in postsItens.data" :key="index">
            <div class="col">
              <div class="card shadow-sm">
                <img class="bd-placeholder-img card-img-top" :src="`/storage/${post.url_image}`"  width="100%" height="225"/>
                <div class="card-body">
                  <p class="card-text">{{post.title}}</p>
                  <p class="card-text">{{post.content.substr(0, 250)}}...</p>
                  <p class="card-text">Data de publicação:{{getHumanDate(post.created_at)}}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">Ver Mais</button>
                    </div>
                    <small class="text-muted">Autor: {{post.author}}</small>
                    <small class="text-muted">Categoria: {{post.category_name}}</small>

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
