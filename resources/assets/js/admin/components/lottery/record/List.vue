<template>
    <div>
        <div id="search-block">
            <el-form :inline="true" :model="formInline" class="demo-form-inline">
                <el-form-item label="开奖期数">
                    <el-input
                        v-model="searches.expect"
                        placeholder="开奖期数"
                        @change="getDatas">
                    </el-input>
                </el-form-item>
            </el-form>
        </div>
        <el-table
            :data="datas"
            border
            style="width: 100%;"
            >
            <el-table-column
                prop="expect"
                label="开奖期数"
                width="200">
            </el-table-column>
            <el-table-column
                prop="opencode"
                label="开奖号码"
            >
            </el-table-column>
            <el-table-column
                prop="district"
                label="开奖地区"
            >
            </el-table-column>
            <el-table-column
                prop="opentime"
                label="开奖时间"
            >
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
                searches: {
                    expect: ''
                },
                total: 0,
                page_size: 15,
                datas: []
            }
        },
        created () {
            this.getDatas();
        },
        methods: {
            getDatas () {
                var _this = this;
                _this.$http.get('/admin/lotteries', {params: _this.searches}).then(response => {
                    if (response.body.success == 1) {
                        _this.total = response.body.infor.total;
                        _this.datas = response.body.infor.data;
                    }
                });
            },
            chPage (page) {
                this.getDatas(page);
            }
        }
    }
</script>

<style>
    a {
        color: #1D8CE0;
        cursor: pointer;
    }
</style>