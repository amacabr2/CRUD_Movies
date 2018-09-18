<template>
    <div class="container">
        <button v-if='authenticated' v-on:click='logout' id='logout-button'> Logout </button>
        <button v-else v-on:click='login' id='login-button'> Login </button>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                authenticated: false
            }
        },

        created () {
            this.isAuthenticated()
        },

        watch: {
            // Everytime the route changes, check for auth status
            '$route': 'isAuthenticated'
        },

        methods: {
            async isAuthenticated () {
                this.authenticated = await this.$auth.isAuthenticated()
            },

            login () {
                this.$auth.loginRedirect('/')
            },

            async logout () {
                await this.$auth.logout()
                await this.isAuthenticated()

                // Navigate back to home
                this.$router.push({ path: '/' })
            }
        }
    }
</script>