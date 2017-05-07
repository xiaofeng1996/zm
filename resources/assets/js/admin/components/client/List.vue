<template>
    <div>
        <el-table
            :data="clients"
            border
            style="width: 100%">
            <el-table-column
                prop="name"
                label="用户名"
                width="150">
            </el-table-column>
            <el-table-column
                prop="mobile"
                label="用户电话"
                width="150">
            </el-table-column>
            <el-table-column
                label="用户头像"
                width="120">
                <template scope="scope">
                    <div class="avatar">
                        <img :src="scope.row.avatar" alt="">
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                label="注册地区"
                width="200">
                <template scope="scope">
                    {{scope.row.province + scope.row.city + scope.row.district}}
                </template>
            </el-table-column>
            <el-table-column
                prop="account_balance"
                label="账户余额"
                width="150">
            </el-table-column>
            <el-table-column
                prop="shop_balance"
                label="购物金"
                width="150">
            </el-table-column>
            <el-table-column
                prop="comulate_shop_balance"
                label="累计购物消费"
                width="150">
            </el-table-column>
        </el-table> 
        <div class="page-block">
            <el-pagination
            @current-change="chPage"
            layout="prev, pager, next"
            :total="total"
            :page-size="page_size">
            </el-pagination>
        </div>
    </div>
</template>

<script>

    export default {
        data () {
            return {
                total: 0,
                page_size: 20,
                clients: []
            }
        },
        created () {
            this.getClients();
        },
        methods: {
            getClients (page) {
                var _this =this;
                page = page ? page : 1;
                _this.$http.get('/admin/clients?page=' + page).then(response => {
                    console.log(response.body);
                    if (response.body.success) {
                        _this.clients = response.body.infor.data;
                        _this.total = response.body.infor.total;
                        _this.page_size = response.body.infor.per_page;
                    }
                });
            }, 
            chPage (page) {
                this.getClients(page);
            }
        }
    }
</script>

<style>
    a {
        color: #1D8CE0;
        cursor: pointer;
    }

    .page-block {
        margin: 20px;
        float: right;
    }

    .avatar {
        width: 100px;
        height: 100px;
    }
    .avatar img {
        width: 80px;
        height: 80px;
    }
</style>