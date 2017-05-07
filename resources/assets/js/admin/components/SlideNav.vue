<template>
    <div>
        <el-menu
            default-active="index-1"
            class="el-menu-vertical-demo" 
            :router="true" theme="light"
        >
            <el-submenu :index="'index-' + key" v-for="(nav, key) in navs">
                <template slot="title">{{ nav.name }}</template>
                <el-menu-item v-for="child in nav.children" :index="child.nav_index">{{ child.name }}</el-menu-item>
            </el-submenu>
        </el-menu>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                navs: []
            }
        },
        created () {
            var _this = this;
            this.$http.get('/admin/navs').then(response => {
                if (response.body.success) {
                    _this.navs = response.body.infor;
                } else {
                    alert('服务器错误');
                }
            });
        },
        methods: {
            // handleOpen (key, keyPath) {
            //     console.log(key, keyPath);
            // },
            // handleClose (key, keyPath) {
            //     console.log(key, keyPath);
            // }
        }
    }
</script>

<style>

</style>