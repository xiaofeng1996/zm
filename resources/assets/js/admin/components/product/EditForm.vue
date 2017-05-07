<template>
    <div class="wrapper"> 
        <el-dialog title="添加广告" v-model="is_dialog_visible" @close="localCloseDialog()">
            <el-form ref="form_data" :model="form_data" label-width="90px">
                <el-form-item label="商品类型" v-if="role_id == 1">
                    <el-radio class="radio" v-model="form_data.is_lucky" label="0">会员商品</el-radio>
                    <el-radio class="radio" v-model="form_data.is_lucky" label="1">幸运区商品</el-radio>
                </el-form-item>
                <el-form-item label="赠送选号数" v-if="role_id == 1 && form_data.is_lucky == 1">
                    <el-input v-model="form_data.lucky_num" type="number"></el-input>
                </el-form-item>
                <el-form-item label="中奖率" v-if="role_id == 1 && form_data.is_lucky == 1">
                    <el-input v-model="form_data.lucky_rate" type="number" placeholder=""></el-input>
                </el-form-item>
                <el-form-item label="审核状态" v-if="role_id == 1">
                    <el-select v-model="form_data.review_status" placeholder="请选择">
                        <el-option
                                v-for="s in status"
                                :label="s.label"
                                :value="s.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="首页推荐" v-if="role_id == 1">
                    <el-select v-model="form_data.recommend" placeholder="请选择">
                        <el-option
                                v-for="r in recommends"
                                :label="r.label"
                                :value="r.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="商家名称" v-if="role_id == 1">
                    <el-select v-model="form_data.merchant_id" placeholder="请选择">
                        <el-option
                        v-for="merchant in merchants"
                        :label="merchant.name"
                        :value="merchant.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="商品名称">
                    <el-input v-model="form_data.name"></el-input>
                </el-form-item>
                <el-form-item label="商品类别">
                    <cate-sel ref="product_cate"></cate-sel>
                </el-form-item>
                <el-form-item label="商品图片">
                    <el-upload
                        :action="upload_url"
                        :data="data_for_upload"
                        :on-success="updateImage"
                    >
                        <div class="product-image">
                            <img :src = "form_data.image" />
                        </div>
                        <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </el-form-item>
                <el-form-item label="商品价格">
                    <el-input v-model="form_data.price" type="number"></el-input>
                </el-form-item>
                <el-form-item label="商品原价">
                    <el-input v-model="form_data.old_price" type="number"></el-input>
                </el-form-item>
                <el-form-item label="支持退货">
                    <el-radio class="radio" v-model="form_data.support_return" label="0">不支持</el-radio>
                    <el-radio class="radio" v-model="form_data.support_return" label="1">支持</el-radio>
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
    import CateSel from './CateSel.vue';

    export default {
        components: {
            'cate-sel': CateSel
        },
        data () {
            return {
                cate_parent_id: 0,
                merchants: [],
                status: [
                    {label: '未审核', value: 0},
                    {label: '审核通过', value: 1},
                    {label: '未通过', value: 2},
                ],
                recommends: [
                    {label: '否', value: "0"},
                    {label: '是', value: "1"}
                ]
            }
        },
        computed: {
            ...mapState({
                is_dialog_visible: state => state.product.is_dialog_visible,
                form_data: state => state.product.form_data,
                upload_url: state => state.upload_url,
                data_for_upload: state => state.data_for_upload,
                host: state => state.host,
                role_id: state => state.role_id,
            })
        },
        created () {
            console.log(this.role_id);
            this.getMerchants();
        },
        methods: {
            ...mapMutations({
                'closeDialog': 'closeProductsDialog',
                'clearFormData': 'clearProductsFormData',
                'updateImage': 'updateProductsImage'
            }),
            ...mapActions({
                'getDatas': 'getProducts'
            }),
            formSubmit () {
                var _this = this;
                _this.$http.post('/admin/products', _this.form_data).then(response => {
                    if (response.body.success == 1) {
                        _this.closeDialog();
                        _this.getDatas();
                        _this.clearFormData();
                        _this.$refs.product_cate.clear();
                    } else {
                        alert(response.body.infor);
                    }
                });
            },
            localCloseDialog () {
                this.closeDialog();
                this.clearFormData();
            },
            getMerchants () {
                var _this = this;
                _this.$http.get('/admin/merchants/all').then(response => {
                    if (response.body.success) {
                        _this.merchants = response.body.infor;
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .product-image, .product-image img {
        width: 120px;
        height: 120px;
    }

    .product-cate {
        float: left;
        width: 100px;
        margin-right: 10px;
        overflow: hidden;
    }
    
</style>