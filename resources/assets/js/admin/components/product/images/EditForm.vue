<template>
    <div>
        <el-dialog title="规格添加/修改" v-model="is_dialog_visible" class="product-attr-edit" @close="close" size="tiny">
            <el-form ref="form_data" :model="form_data" label-width="90px">
                <el-form-item label="多图上传">
                    <el-upload
                            ref="upload"
                            class="upload-demo"
                            :action="upload_url"
                            :data="data_for_upload"
                            :on-remove="handleRemove"
                            :on-success="uploadSucc"
                            list-type="picture">
                        <el-button size="small" type="primary">点击上传</el-button>
                        <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </el-form-item>
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

    export default {
        data () {
            return {
                file_list: []
            }
        },
        computed: {
            ...mapState({
                is_dialog_visible:  state => state.product_images.is_dialog_visible,
                form_data:          state => state.product_images.form_data,
                upload_url:         state => state.upload_url,
                data_for_upload:    state => state.data_for_upload,
            })
        },
        methods: {
            ...mapActions({
                getDatas: 'getProductImages'
            }),
            ...mapMutations({
                closeForm: 'closeProductImagesForm',
                clear: 'clearProductImagesForm',
                updateImage: 'updateProductImagesIm'
            }),
            close () {
                this.closeForm();
                this.clear();
            },
            formSubmit () {
                var _this = this;
                var data = _this.form_data;
                if (_this.file_list.length <= 0) {
                    alert('上传列表不能为空');
                } else {
                    data.file_list = _this.file_list;
                    _this.$http.post('/admin/product/images', data).then(response => {
                        if (response.body.success == 1) {
                            _this.getDatas(_this.form_data.goods_id);
                            _this.close();
                        } else {
                            alert(response.body.infor);
                        }
                    });
                    this.$refs.upload.clearFiles();
                }
            },
            handleRemove (file, file_list) {
                this.updateFileList(file_list);
            },
            uploadSucc (response, file, file_list) {
                this.updateFileList(file_list);
            },
            updateFileList (file_list) {
                var new_file_list = [];
                for (var i in file_list) {
                    new_file_list[i] = {url: file_list[i].response};
                }
                this.file_list = new_file_list;
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
</style>