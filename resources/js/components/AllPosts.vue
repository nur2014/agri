<template>
    <div>
        <h3 class="text-center">All Posts</h3><br/>
 
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in posts" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.name }}</td>
                <td>{{ post.address }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: post.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deletePost(post.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                posts: []
            }
        },
        created() {
            console.log('test');
            this.axios
                .get('http://blog.local/api/cities')
                .then(response => {
                    let result = response.data;
                    if (result.success) {
                        this.posts = result.data.data;


                    }

                    console.log(this.posts);
                });
        },
        methods: {
            deletePost(id) {
                this.axios
                    .delete(`http://blog.local/api/cities/${id}`)
                    .then(response => {
                        let i = this.posts.map(item => item.id).indexOf(id); // find index of your object
                        this.posts.splice(i, 1)
                    });
            }
        }
    }
</script>