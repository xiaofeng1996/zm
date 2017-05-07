<template>
    <div class="wrapper"> 
        <el-dialog title="编辑" v-model="dialog_visible" size="tiny" @close="localCloseDialog">
            <el-form ref="form_data" :model="form_data" label-width="80px">
                <el-form-item label="商品名称">
                    <el-input v-model="form_data.name"></el-input>
                </el-form-item>
                <el-form-item label="图片">
                    <el-upload
                        :action="upload_url"
                        :data="data_for_upload"
                        :on-success="uploadSucc"
                        >
                        <div class="upload-img">
                            <img :src="form_data.image" alt="图片预览">
                        </div>
                        <el-button size="small" type="primary">点击上传</el-button>
                        <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </el-form-item>
                <el-form-item label="显示顺序">
                    <el-input v-model="form_data.sort" type="number"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialog_visible = false">取 消</el-button>
                <el-button type="primary" @click="formSubmit">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>

    import { mapState, mapMutations, mapActions } from 'vuex';

    export default {
        computed: {
            ...mapState({
                dialog_visible: state => state.category.dialog_visible,
                form_data: state => state.category.form_data,
                upload_url: state => state.upload_url,
                data_for_upload: state => state.data_for_upload,
                host: state => state.host
            })
        },
        methods: {
            ...mapActions({
                getDatas: 'getCategories'
            }),
            ...mapMutations({
                closeDialog: 'closeCategoryDialog',
                clearFormData: 'clearCategoryFormData',
                uploadSucc: 'uploadCategoryImg'
            }),
            formSubmit () {
                var _this = this;
                var data = _this.form_data;
                _this.$http.post('/admin/categories', data).then(response => {
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
    .upload-img {
        overflow: hidden;
    }
    .upload-img, .upload-img img {
        width: 120px;
        height: 120px;
    }
</style>