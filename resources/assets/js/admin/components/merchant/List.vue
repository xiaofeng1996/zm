<template>
    <div>
        <el-table
            :data="datas"
            border
            style="width: 100%">
            <el-table-column
                prop="name"
                label="店铺名称"
                width="120">
            </el-table-column>
            <el-table-column
                prop="mobile"
                label="手机号"
                width="150">
            </el-table-column>
            <el-table-column
                label="店铺图片"
                width="210">
                <template scope="scope">
                    <div class="merchant-img">
                        <img :src="scope.row.image" alt="">
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                prop="fare"
                label="运费"
                width="150">
            </el-table-column>
            <el-table-column
                label="店铺地址"
                >
                <template scope="scope">
                    {{ scope.row.province + scope.row.city + scope.row.district + scope.row.address }}
                </template>
            </el-table-column>
            <el-table-column
                label="操作"
                width="100">
                <template scope="scope">
                    <el-button type="primary" size="mini" icon="edit" @click="edit(scope.row)"></el-button>
                    <el-button v-if="role_id == 1" type="danger" size="mini" icon="delete" @click="del(scope.row.id)"></el-button>
                </template>
            </el-table-column>
        </el-table> 
        <div v-if="role_id == 1" class="page-block">
            <el-pagination
            @current-change="getDatas"
            layout="prev, pager, next"
            :total="total"
            :page-size="page_size">
            </el-pagination>
        </div>
    </div>
</template>

<script>

    import { mapState, mapActions, mapMutations } from 'vuex';

    export default {
        computed: mapState({
            role_id: state => state.role_id,
            datas: state => state.merchant.datas,
            formData: state => state.merchant.formData,
            total: state => state.merchant.total,
            page_size: state => state.merchant.page_size,
            current_page: state => state.merchant.current_page
        }),
        created () {
            var _this = this;
            this.getDatas();
        },
        methods: {
            ...mapActions({
                getDatas: 'getDatas'
            }),
            ...mapMutations({
                setFormData: 'setFormData',
                openDialog: 'openDialog'
            }),
            edit (row) {
                this.setFormData(row);
                this.openDialog();
            },
            del (id) {
                var _this = this;
                if (confirm('确认删除?')) {
                    _this.$http.post('/admin/merchant/delete', {id: id}).then(response => {
                        _this.getDatas();
                    });
                }
            }
        }
    }
</script>

<style scoped="scoped">
    a {
        color: #1D8CE0;
        cursor: pointer;
    }

    .merchant-img {
        width: 180px;
    }

    .merchant-img img {
        width: 180px;
    }

    .page-block {
        margin: 20px;
        float: right;
    }
</style>