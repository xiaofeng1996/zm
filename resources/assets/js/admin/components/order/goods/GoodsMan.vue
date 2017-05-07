<template>
    <div>
        <el-dialog title="订单商品" v-model="is_dialog_visible" @close="closeDialog">
            <el-table
                :data="datas"
                border
                max-height="480"
                style="width: 100%">
                <el-table-column
                    prop="name"
                    label="商品名称"
                    >
                </el-table-column>
                <el-table-column
                    label="商品图片"
                    >
                    <template scope="scope">
                        <div class="goods-img">
                            <img :src="scope.row.image" alt="商品图片">
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="price"
                    label="商品价格"
                    >
                </el-table-column>
                <el-table-column
                    prop="goods_num"
                    label="购买数量"
                    >
                </el-table-column>
                <el-table-column
                    prop="attr"
                    label="商品属性"
                    >
                </el-table-column>
            </el-table>
        </el-dialog>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations } from 'vuex';

    export default {
        computed: {
            ...mapState({
                is_dialog_visible: state => state.order.is_goods_visible,
                datas: state => state.order_goods.datas
            })
        },
        methods: {
            ...mapActions({
                getDatas: 'getOrderGoods'
            }),
            ...mapMutations({
                closeDialog: 'closeOrderGoods'
            })
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