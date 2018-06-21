<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                       <div class="input-group">
                           <input type="text" class="form-control" v-model="post.name" @keydown.enter="create">
                           <span class="input-group-btn">
                               <button class="btn btn-success" @click="create">Post</button>
                           </span>
                       </div>
                       <div class="alert alert-danger" v-if="!posts.length">
                        you not have posts !
                      </div>
                       <div class="posts-list">
                           <ul class="list-unstyled">
                               <li v-for="post in posts":key="post.id" :class="{ done:post.compleate}">
                                   <div class="checkbox"> <label> <input type="checkbox" v-model="post.compleate" @click="done(post)"> {{post.name}}</label> 
                                    <span class="pull-right">
                                      <a href="#" @click.prevent="remove(post)">x</a>
                                    </span>
                                   </div>
                               </li>
                              
                           </ul>
                       </div>
                  <div v-f="posts.length">
                      <span class="label label-default"> you have {{ posts.length }} posts</span>
                      <span class="label label-success"> you have riming {{ rimainingPost() }} posts</span>
                      <span class="label label-primary"> you have comlate {{completeedPost()  }} posts</span>
                    </div>
                </div>
                    </div>
                    
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            //console.log('Component mounted.')
            this.featchData();

        },
        data(){
            return{
                posts:[],
                post:{
                  name:''
                }
            }
        },
        methods:{
          rimainingPost(){
            return this.posts.filter(post =>{return !post.compleate}).length
          },
         completeedPost(){
            return this.posts.filter(post =>{return post.compleate}).length
          },
            featchData(){
                axios.get('/api/posts').then((res)=>{
                    this.posts= res.data
                })
                .catch((err)=>{
                                console.log(err)

                })
            },
            create(){
              axios.post('/api/posts',this.post).then((res)=>{
                this.posts.unshift(res.data)
                this.post.name=''
              })
               .catch((err)=>{
                                console.log(err)

                })
            },
            done(post)
            {
              axios.put(`/api/posts/${post.id}`,{ compleate:!post.compleate}).then((res)=>{
                                console.log('post update');

              })
               .catch((err)=>{
                                console.log(err)

                })
            },
                remove(post)
            {
              axios.delete(`/api/posts/${post.id}`).then((res)=>{
                             const postIndex = this.posts.indexOf(post)
                             this.posts.splice(postIndex,1)

              })
               .catch((err)=>{
                                console.log(err)

                })
            }
        }
    }
</script>

<style>
body, .posts-list{
    padding-top:20px;
}
.done label{
  text-decoration:line-through;
}
</style>
