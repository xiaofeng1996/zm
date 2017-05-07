<template>
    <div>
        <el-dialog title="商品管理" v-model="is_dialog_visible" @close="closeAttrGoodsDialog">
            <div class="top-btn">
                <el-button @click="add">添加</el-button>
            </div>
            <el-table
                :data="datas"
                border
                max-height="480"
                style="width: 100%">
                <!--<el-table-column-->
                    <!--prop="title"-->
                    <!--label="商品名称"-->
                    <!--&gt;-->
                <!--</el-table-column>-->
                <!--<el-table-column-->
                    <!--label="商品图片"-->
                    <!--&gt;-->
                    <!--<template scope="scope">-->
                        <!--<div class="goods-img">-->
                            <!--<img :src="scope.row.image" alt="商品图片">-->
                        <!--</div>-->
                    <!--</template>-->
                <!--</el-table-column>-->
                <!--<el-table-column-->
                    <!--prop="price"-->
                    <!--label="商品价格"-->
                    <!--&gt;-->
                <!--</el-table-column>-->
                <el-table-column
                    prop="stock"
                    label="库存"
                    >
                </el-table-column>
                <el-table-column
                    prop="attr1"
                    label="属性1"
                    >
                </el-table-column>
                <el-table-column
                    prop="attr2"
                    label="属性2"
                    >
                </el-table-column>
                <el-table-column
                    label="操作"
                    width="100">
                    <template scope="scope">
                        <el-button type="primary" size="mini" icon="edit" @click="edit(scope.row)"></el-button>
                        <el-button type="danger" size="mini" icon="delete" @click="del(scope.row.id)"></el-button>
                    </template>
                </el-table-column>
            </el-table> 
        </el-dialog>
        <edit-form></edit-form>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations } from 'vuex';
    import EditForm from './EditForm.vue';

    export default {
        components: {
            'edit-form': EditForm
        },
        computed: {
            ...mapState({
                is_dialog_visible: state => state.product.is_attr_goods_visible,
                datas: state => state.product_goods.datas,
                form_data: state => state.product_goods.form_data
            })
        },
        methods: {
            ...mapActions({
                getProductAttrs: 'getProductAttrs',
                getDatas: 'getProductGoods'
            }),
            ...mapMutations({
                closeAttrGoodsDialog: 'closeAttrGoodsDialog',
                openProductGoodsDialog: 'openProductGoodsDialog',
                setFormData: 'setProductGoodsFormData'
            }),
            add () {
                this.getProductAttrs();
                this.openProductGoodsDialog();
            },
            edit (data) {
                this.setFormData(data);
                console.log(data.id);
                this.getProductAttrs(data.id);
                this.openProductGoodsDialog();
            },
            del (id) {
                if (confirm('确认删除?')) {
                    var _this = this;
                    _this.$http.post('admin/attr/goods/destory/' + id).then(response => {
                        if (response.body.success == 1) {
                            _this.getDatas(_this.form_data.goods_id);
                        } else {
                            alert(response.body.infor);
                        }
                    });
                }
            }
        }
    }
</script>

<style>
    .top-btn {
        margin-bottom: 20px;
    }
    .goods-img, .goods-img img {
        width: 80px;
        height: 80px;
    }
</style>