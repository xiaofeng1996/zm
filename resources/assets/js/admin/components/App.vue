<template>
    <div id="wrapper">
        <router-view></router-view>
    </div>
</template>

<script>

    import { mapActions } from 'vuex';

    export default {
        created () {
            this.checkLogin();
            this.getRole();
        },
        methods: {
            ...mapActions({
                getRole: 'getRole'
            }),
            checkLogin () {
                this.$http.get('/admin/login/valid').then(response => {
                    if (response.body.success == 0) {
                        this.$router.push('/login');
                    }
                });
            }
        }
    }
</script>

<style>
    #wrapper {
        width: 100%; 
        height: 100%;
    } 
    #header {
        background-color: #20A0FF;
        height: 50px;
        width: 100%;
    }
    #header h1 {
        color: #ffffff;
        font-size: 20px;
        line-height: 50px;
        padding-left: 20px;
    }

    #container {
        height: 100%;
    }
    #container nav {
        float: left;
        width: 150px;
        height: 100%;
    }

    #content {
        height: 100%;
        overflow: auto;
    }

</style>