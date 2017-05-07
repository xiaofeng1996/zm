<template>
    <div>
        <el-dialog title="规格添加/修改" v-model="is_dialog_visible" class="product-attr-edit" @close="close" size="tiny">
            <el-form ref="form_data" :model="form_data" label-width="90px">
                <!--<el-form-item label="商品名称">-->
                    <!--<el-input v-model="form_data.title"></el-input>-->
                <!--</el-form-item>-->
                <!--<el-form-item label="价格">-->
                    <!--<el-input v-model="form_data.price"></el-input>-->
                <!--</el-form-item>-->
                <el-form-item label="库存">
                    <el-input v-model="form_data.stock"></el-input>
                </el-form-item>
                <el-form-item label="规格">
                    <el-select v-for="(attr, key) in attrs" v-model="attr.value" class="attrs" placeholder="请选择">
                        <el-option
                        v-for="val in attr.vals"
                        :label="val.val"
                        :value="val.val">
                        </el-option>
                    </el-select>
                </el-form-item>
                <!--<el-form-item label="图片">-->
                    <!--<el-upload-->
                        <!--:action="upload_url"-->
                        <!--:data="data_for_upload"-->
                        <!--:on-success="updateImage"-->
                    <!--&gt;-->
                        <!--<div class="product-image">-->
                            <!--<img :src = "form_data.image" />-->
                        <!--</div>-->
                        <!--<div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>-->
                    <!--</el-upload>-->
                <!--</el-form-item>-->
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="close()">取 消</el-button>
                <el-button type="primary" @click="formSubmit()">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import { mapState, mapMutations, mapActions } from 'vuex';
    import Attr from './Attr.vue';

    export default {
        components: {
            'attr': Attr
        },
        computed: {
            ...mapState({
                is_dialog_visible:  state => state.product_goods.is_dialog_visible,
                form_data:          state => state.product_goods.form_data,
                attrs:              state => state.product_goods.attrs,
                upload_url:         state => state.upload_url,
                data_for_upload:    state => state.data_for_upload
            })
        },
        methods: {
            ...mapActions({
                getDatas: 'getProductGoods'
            }),
            ...mapMutations({
                closeProductGoods: 'closeProductGoodsDialog',
                clear: 'clearProductGoodsFormData',
                updateImage: 'updateProductsImage'
            }),
            close () {
                this.closeProductGoods();
                this.clear();
            },
            formSubmit () {
                var _this = this;
                var data = _this.form_data;
                var attrs_len = _this.attrs.length;
                for (var i = 0; i < attrs_len; i++) {
                    var k = _this.attrs[i].field;
                    data[k] = _this.attrs[i].value;
                }
                _this.$http.post('/admin/attr/goods', data).then(response => {
                    if (response.body.success == 1) {
                        _this.close();
                        console.log(_this.form_data.goods_id);
                        _this.getDatas(_this.form_data.goods_id);
                    } else {
                        alert(response.body.infor);
                    }
                });
            }
        }
    }
</script>

<style scoped="scoped">
    .product-attr-edit {
        z-index: 999;
    }

    .product-image img {
        width: 120px;
        height: 120px;
    }

    .attrs {
        margin-top: 10px;
    }

</style>