<template>
    <div>
        <div id="search-block">
            <el-form :inline="true" :model="formInline" class="demo-form-inline">
                <el-form-item label="订单号">
                    <el-input
                        v-model="searches.out_trade_no"
                        placeholder="订单号"
                        @change="getDatas">
                    </el-input>
                </el-form-item>
                <el-form-item label="开奖期数">
                    <el-input
                        v-model="searches.expect"
                        placeholder="开奖期数"
                        @change="getDatas">
                    </el-input>
                </el-form-item>
                <el-form-item label="获奖状态">
                    <el-select
                        v-model="searches.status"
                        placeholder="获奖状态"
                        @change="getDatas"
                    >
                        <el-option
                            v-for="s in status"
                            :label="s.label"
                            :value="s.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="奖品处理状态">
                    <el-select
                        v-model="searches.operate_status"
                        placeholder="奖品处理状态"
                        @change="getDatas"
                    >
                        <el-option
                            v-for="s in operate_status"
                            :label="s.label"
                            :value="s.value">
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
                prop="opentime"
                label="开奖时间"
                width="200">
            </el-table-column>
            <el-table-column
                prop="expect"
                label="开奖期数"
                width="200">
            </el-table-column>
            <el-table-column
                prop="opencode"
                label="开奖号码"
                width="120"
            >
            </el-table-column>
            <el-table-column
                prop="code"
                label="投注号码"
                width="120"
            >
            </el-table-column>
            <el-table-column
                label="是否中奖"
                width="100"
            >
                <template scope="scope">
                    <a v-if="scope.row.status == 0" style="color: #20A0FF;">待开奖</a>
                    <a v-if="scope.row.status == 1" style="color: #13CE66;">中奖</a>
                    <a v-if="scope.row.status == 2" style="color: #FF4949;">未中奖</a>
                </template>
            </el-table-column>
            <el-table-column
                    label="奖品处理状态"
                    width="150">
                <template scope="scope">
                    <span v-if="scope.row.operate_status == 0" style="color: #20A0FF;">未处理</span>
                    <span v-if="scope.row.operate_status == 1" style="color: #13CE66;">已发货</span>
                    <span v-if="scope.row.operate_status == 2" style="color: #FF4949;">已收货</span>
                </template>
            </el-table-column>
            <el-table-column
                label="奖品处理时间"
                width="200">
                <template scope="scope">
                    <span v-if="scope.row.operated_at">{{ scope.row.operated_at }}</span>
                    <span v-else>暂未处理</span>
                </template>
            </el-table-column>
            <el-table-column
                prop="mobile"
                label="手机号"
                width="200"
            >
            </el-table-column>
            <el-table-column
                prop="award_desc"
                label="奖品"
                width="150">
            </el-table-column>
            <el-table-column
                prop="order.out_trade_no"
                label="订单号"
                width="200">
            </el-table-column>
            <el-table-column
                prop="express_name"
                label="快递公司"
                width="200">
            </el-table-column>
            <el-table-column
                prop="express_nu"
                label="快递单号"
                width="200">
            </el-table-column>
            <el-table-column
                fixed="right"
                label="操作"
                width="100">
                <template scope="scope">
                    <el-button type="primary" size="mini" icon="edit" @click="edit(scope.row)"></el-button>
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
    </div>
</template>

<script>

    import { mapState, mapActions, mapMutations } from 'vuex';

    export default {
        data () {
            return {
                status: [
                    {label: "全部", value: -1},
                    {label: "待开奖", value: 0},
                    {label: "中奖", value: 1},
                    {label: "未中奖", value: 2},
                ],
                operate_status: [
                    {label: "全部", value: -1},
                    {label: "未处理", value: 0},
                    {label: "已发货", value: 1},
                    {label: "已收货", value: 2},
                ]
            }
        },
        computed: mapState({
            datas:      state => state.lottery.datas,
            total:      state => state.lottery.total,
            page_size:  state => state.lottery.page_size,
            searches:   state => state.lottery.searches
        }),
        created () {
            this.getDatas();
        },
        methods: {
            ...mapActions({
                getDatas: 'getLotteryWins'
            }),
            ...mapMutations({
                setFormData: 'setLotteryFormData',
                openDialog: 'openLotteryWinDialog',
                setPage: 'setLotteryWinPage'
            }),
            edit (row) {
                this.setFormData(row);
                this.openDialog();
            },
            chPage (page) {
                this.setPage(page);
                this.getDatas();
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