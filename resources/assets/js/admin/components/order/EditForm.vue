<template>
    <div class="wrapper"> 
        <el-dialog title="添加广告" v-model="is_dialog_visible" @close="localCloseDialog()" size="tiny">
            <el-form ref="form_data" :model="form_data" label-width="80px">
                <el-form-item label="发货">
                    <el-select
                        v-model="form_data.status"
                        placeholder="请选择"
                    >
                        <el-option
                                v-for="s in status"
                                :label="s.label"
                                :value="s.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="快递公司">
                    <el-input v-model="form_data.express_name"></el-input>
                </el-form-item>
                <el-form-item label="订单号">
                    <el-input v-model="form_data.express_nu"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="closeDialog()">取 消</el-button>
                <el-button type="primary" @click="formSubmit()">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>

    import { mapState, mapMutations, mapActions } from 'vuex';

    export default {
        data () {
            return {
                status: [
                    {label: "未支付", value: 1},
                    {label: "待发货", value: 2},
                    {label: "已发货", value: 3},
                    {label: "已收货", value: 4},
                    {label: "已评价", value: 5},
                ]
            }
        },
        computed: {
            ...mapState({
                is_dialog_visible:  state => state.order.is_dialog_visible,
                form_data:          state => state.order.form_data
            })
        },
        methods: {
            ...mapMutations({
                closeDialog: 'closeOrderDialog',
                clearFormData: 'clearOrderFormData'
            }),
            ...mapActions({
                getDatas: 'getOrders'
            }),
            formSubmit () {
                var _this = this;
                _this.$http.post('/admin/orders', _this.form_data).then(response => {
                    if (response.body.success == 1) {
                        _this.closeDialog();
                        _this.getDatas();
                        _this.clearFormData();
                    } else {
                        alert(response.body.infor);
                    }
                });
            },
            localCloseDialog () {
                this.closeDialog();
                this.clearFormData();
            },
            chDeliverStatus (status) {
                console.log(status);
                console.log(this.current_deliver_status);
                commit('setOrderStatus', status);
            }
        }
    }
</script>

<style scoped>
    .wrapper {
        width: 80%;
        margin: 0 auto;
    }

    .form-item1 {
        margin-top: 20px;
    }

    .local-input {
        width: 300px;
    }

    .banner-image-mobile{
        width: 640px;
        height: 240px;
    }

</style>