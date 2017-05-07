<template>
    <div class="wrapper"> 
        <el-dialog title="添加广告" v-model="is_dialog_visible" @close="localCloseDialog()">
            <el-form ref="form_data" :model="form_data" label-width="80px">
                <el-form-item label="商家名称">
                    <el-input v-model="form_data.name"></el-input>
                </el-form-item>
                <el-form-item label="商家电话">
                    <el-input v-model="form_data.mobile"></el-input>
                </el-form-item>
                <el-form-item label="商家图片">
                    <el-upload
                        :action="upload_url"
                        type="drag"
                        :thumbnail-mode="true"
                        :on-preview="handlePreview"
                        :on-remove="handleRemove"
                        :default-file-list="fileList"
                        :data="data_for_upload"
                        :on-success="updateImage"
                    >
                        <i class="el-icon-upload"></i>
                        <div class="el-dragger__text">将文件拖到此处，或<em>点击上传</em></div>
                        <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </el-form-item>
                <el-form-item label="所在省">
                    <el-input v-model="form_data.province"></el-input>
                </el-form-item>
                <el-form-item label="所在市">
                    <el-input v-model="form_data.city"></el-input>
                </el-form-item>
                <el-form-item label="所在地区">
                    <el-input v-model="form_data.district"></el-input>
                </el-form-item>
                <el-form-item label="详细地址">
                    <el-input v-model="form_data.address"></el-input>
                </el-form-item>
                <el-form-item label="订单运费">
                    <el-input v-model="form_data.fare"></el-input>
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
            }
        },
        computed: {
            ...mapState({
                is_dialog_visible: state => state.merchant.is_dialog_visible,
                upload_url: state => state.upload_url,
                data_for_upload: state => state.data_for_upload,
                host: state => state.host,
                form_data: state => state.merchant.form_data
            })
        },
        methods: {
            ...mapMutations([
                'closeDialog',
                'clearFormData',
                'updateImage',
            ]),
            ...mapActions([
                'getDatas'
            ]),
            formSubmit () {
                var _this = this;
                var url = this.host + 'merchant';
                _this.$http.post(url, _this.form_data).then(response => {
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