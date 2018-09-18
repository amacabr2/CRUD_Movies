<template>
    <table>
        <tbody>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Count</th>
        </tr>
        <template v-for="movie in movies">
            <tr v-bind:key="movie.id">
                <td>{{ movie.id }}</td>
                <td>{{ movie.title }}</td>
                <td>{{ movie.count }}</td>
            </tr>
        </template>
        </tbody>
    </table>
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
