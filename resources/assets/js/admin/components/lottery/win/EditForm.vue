<template>
    <div class="wrapper"> 
        <el-dialog title="奖品发放状态" v-model="is_dialog_visible" @close="localCloseDialog()" size="tiny">
            <el-form ref="form_data" :model="form_data" label-width="80px">
                <el-form-item label="处理状态">
                    <el-select
                        v-model="form_data.operate_status"
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
                    {label: "未处理", value: 0},
                    {label: "已发货", value: 1},
                    {label: "已收货", value: 2}
                ]
            }
        },
        computed: {
            ...mapState({
                is_dialog_visible:  state => state.lottery.is_dialog_visible,
                form_data:          state => state.lottery.form_data
            })
        },
        methods: {
            ...mapMutations({
                closeDialog: 'closeLotteryWinDialog',
                clearFormData: 'clearLotteryFormData'
            }),
            ...mapActions({
                getDatas: 'getLotteryWins'
            }),
            formSubmit () {
                var _this = this;
                _this.$http.post('/admin/lottery/wins', _this.form_data).then(response => {
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