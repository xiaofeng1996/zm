<template>
    <div>
        <div id="search-block">
            <el-form :inline="true" :model="formInline" class="demo-form-inline">
                <el-form-item label="订单号">
                    <el-input
                            v-model="searches.out_trade_no"
                            placeholder="订单号"
                            @change="search">
                    </el-input>
                </el-form-item>
                <el-form-item label="订单状态">
                    <el-select
                            v-model="searches.status"
                            placeholder="订单状态"
                            @change="search"
                    >
                        <el-option
                                v-for="s in status"
                                :label="s.label"
                                :value="s.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="收货人">
                    <el-input
                            v-model="searches.name"
                            placeholder="收货人"
                            @change="search">
                    </el-input>
                </el-form-item>
                <el-form-item label="收货人手机">
                    <el-input
                            v-model="searches.mobile"
                            placeholder="手机号"
                            @change="search">
                    </el-input>
                </el-form-item>
                <el-form-item label="订单类型">
                    <el-select
                            v-model="searches.is_lucky"
                            @change="search"
                    >
                        <el-option
                                v-for="t in order_types"
                                :label="t.label"
                                :value="t.value">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
        </div>
        <el-table
            :data="datas"
            border
            style="width: 100%;"
            >
            <el-table-column
                prop="out_trade_no"
                label="订单号"
                width="200">
            </el-table-column>
            <!--<el-table-column-->
                    <!--label="幸运区订单"-->
                    <!--width="120"-->
            <!--&gt;-->
                <!--<template scope="scope">-->
                    <!--<a v-if="scope.row.is_lucky == 1">是</a>-->
                    <!--<a v-if="scope.row.is_lucky == 0">否</a>-->
                <!--</template>-->
            <!--</el-table-column>-->
            <!--<el-table-column-->
                    <!--label="已投注"-->
                    <!--width="100"-->
            <!--&gt;-->
                <!--<template scope="scope">-->
                    <!--<a v-if="scope.row.is_bet == 1">是</a>-->
                    <!--<a v-if="scope.row.is_bet == 0">否</a>-->
                <!--</template>-->
            <!--</el-table-column>-->
            <!--<el-table-column-->
                    <!--label="是否中奖"-->
                    <!--width="100"-->
            <!--&gt;-->
                <!--<template scope="scope">-->
                    <!--<a v-if="scope.row.award_status == 0">待开奖</a>-->
                    <!--<a v-if="scope.row.award_status == 1">中奖</a>-->
                    <!--<a v-if="scope.row.award_status == 2">未中奖</a>-->
                <!--</template>-->
            <!--</el-table-column>-->
            <el-table-column
                    label="商品列表"
                    width="150">
                <template scope="scope">
                    <a @click="openGoods(scope.row.id)">点击查看</a>
                </template>
            </el-table-column>
            <el-table-column
                prop="total_money"
                label="支付金额"
                width="150">
            </el-table-column>
            <el-table-column
                prop="fare"
                label="运费"
                width="210">
            </el-table-column>
            <el-table-column
                prop="total_goods_num"
                label="商品总数"
                width="120"
                >
            </el-table-column>
            <el-table-column
                label="订单状态"
                width="120"
            >
                <template scope="scope">
                    <span v-if="scope.row.status==1" style="color: #FF4949;">待付款</span>
                    <span v-if="scope.row.status==2" style="color: #F7BA2A;">待发货</span>
                    <span v-if="scope.row.status==3" style="color: #13CE66;">待收货</span>
                    <span v-if="scope.row.status==4" style="color: #20A0FF;">待评价</span>
                    <span v-if="scope.row.status==5" style="color: #20A0FF;">待评价</span>
                </template>
            </el-table-column>
            <el-table-column
                prop="paid_at"
                label="支付时间"
                width="120"
            >
            </el-table-column>
            <el-table-column
                prop="name"
                label="收货人"
                width="120"
            >
            </el-table-column>
            <el-table-column
                prop="mobile"
                label="收货人电话"
                width="150"
            >
            </el-table-column>
            <el-table-column
                prop="address"
                label="收货地址"
                width="200"
            >
            </el-table-column>
            <el-table-column
                prop="express_name"
                label="快递公司"
                width="200"
            >
            </el-table-column>
            <el-table-column
                prop="express_nu"
                label="快递单号"
                width="200"
            >
                </el-table-column>
            <el-table-column
                prop="delivered_at"
                label="发货时间"
                width="200"
            >
            </el-table-column>
            <el-table-column
                fixed="right"
                label="操作"
                width="100">
                <template scope="scope">
                    <el-button type="primary" size="mini" icon="edit" @click="edit(scope.row)"></el-button>
                    <el-button type="danger" size="mini" icon="delete" @click="del(scope.row.id)"></el-button>
                </template>
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
        <goods></goods>
    </div>
</template>

<script>

    import { mapState, mapActions, mapMutations } from 'vuex';
    import goods from './goods/GoodsMan.vue';

    export default {
        components: {
            'goods': goods
        },
        data () {
            return {
                status: [
                    {label: "全部", value: 0},
                    {label: "未支付", value: 1},
                    {label: "待发货", value: 2},
                    {label: "已发货", value: 3},
                    {label: "已收货", value: 4},
                    {label: "已评价", value: 5},
                ],
                order_types: [
                    {label: "全部", value: -1},
                    {label: "会员区商品", value: 0},
                    {label: "幸运区商品", value: 1}
                ]
            }
        },
        computed: mapState({
            datas:      state => state.order.datas,
            formData:   state => state.order.form_data,
            total:      state => state.order.total,
            page_size:  state => state.order.page_size,
            searches:   state => state.order.searches
        }),
        created () {
            this.getDatas();
        },
        methods: {
            ...mapActions({
                getDatas: 'getOrders',
                getGoods: 'getOrderGoods'
            }),
            ...mapMutations({
                setFormData: 'setOrderFormData',
                openDialog: 'openOrderDialog',
                openOrderGoods: 'openOrderGoods'
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
            },
            search () {
                this.getDatas();
            },
            chPage (page) {
                this.getDatas(page);
            },
            openGoods (order_id) {
                this.getGoods(order_id);
                this.openOrderGoods();
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