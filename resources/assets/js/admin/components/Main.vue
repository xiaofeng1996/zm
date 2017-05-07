<template>
    <div id="wrapper">
        <div id="header">
            <h1 class="main-title">知美商城</h1>
            <div id="right-btn">
                <span id="ch-pwd" @click="resetPwd">修改密码</span>
                <span id="logout" @click="logout">退出</span>
            </div>
        </div>
        <div id="container">
            <nav>
                <slide-nav></slide-nav>
            </nav>
            <div id="content">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    // Vue.component('SlideNav', require('./SlideNav.vue'));
    import SlideNav from './SlideNav.vue';
    export default {
        components: { SlideNav },
        created () {
            
        },
        methods: {
            logout () {
                var _this = this;
                this.$http.get('/admin/logout').then(response => {
                    if (response.body.success == 1) {
                        _this.$router.replace('/login');
                    }
                });
            },
            resetPwd () {
                this.$router.push('/password/reset');
            }
        },
        couputed: {
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
        float: left;
    }

    #right-btn {
        float: right;
        overflow: hidden;
    }

    #right-btn span {
        margin-right: 20px;
        line-height: 50px;
        cursor: pointer;

        color: #ffffff;
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