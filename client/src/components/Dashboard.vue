<template>
   <div class="container">
       <table class="table">
           <thead>
           <tr>
               <th>ID</th>
               <th>Title</th>
               <th>Count</th>
           </tr>
           </thead>

           <tbody>
           <template v-for="movie in movies">
               <tr v-bind:key="movie.id">
                   <td>{{ movie.id }}</td>
                   <td>{{ movie.title }}</td>
                   <td>{{ movie.count }}</td>
               </tr>
           </template>
           </tbody>
       </table>

       <a class="button is-primary">Add Movie</a>
   </div>
</template>

<script>
    export default {
        name: "Dashboard",

        data() {
            return {
                movies: []
            }
        },

        async created() {
            await this.getMovies()
        },

        methods: {
            async getMovies() {
                const response = await axios.get('http://localhost:8000/movies')
                this.movies = response.data
            }
        }
    }
</script>
