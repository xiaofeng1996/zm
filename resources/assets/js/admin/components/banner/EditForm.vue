<template>
    <div class="wrapper"> 
        <el-dialog title="添加广告" v-model="isDialogVisible" @close="closeDialog()">
                <el-row :gutter="20" class="form-item1 banner-image-mobile">
                    <el-col :span="4">手机端图片: </el-col>
                    <el-col :span="20">
                        <el-upload
                            :action="upload_url"
                            type="drag"
                            :thumbnail-mode="true"
                            :default-file-list="fileList"
                            :data="data_for_upload"
                            :headers="headersForUpload"                         
                            :on-success="updateBannerImage"
                        >
                            <i class="el-icon-upload"></i>
                            <div class="el-dragger__text">将文件拖到此处，或<em>点击上传</em></div>
                            <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                        </el-upload>
                    </el-col>
                </el-row>
                <el-row :gutter="20" class="form-item1 banner-image-web">
                    <el-col :span="4">电脑端图片: </el-col>
                    <el-col :span="20">
                        <el-upload
                            width="100px"
                            :action="upload_url"
                            type="drag"
                            :thumbnail-mode="true"
                            :default-file-list="fileList"
                            :data="data_for_upload"
                            :on-success="updateBannerWebImage"
                        >
                            <i class="el-icon-upload"></i>
                            <div class="el-dragger__text">将文件拖到此处，或<em>点击上传</em></div>
                            <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                        </el-upload>
                    </el-col>
                </el-row>
                <el-row :gutter="20" class="form-item1"> 
                    <el-col :span="4" >广告类型: </el-col>
                    <el-col :span="20">
                        <el-radio class="radio" v-model="formData.keytype" :label="1">商品</el-radio>
                        <el-radio class="radio" v-model="formData.keytype" :label="2">网页</el-radio>
                    </el-col>
                </el-row>
                <el-row v-if="formData.keytype == 1" :gutter="20" class="form-item1"> 
                    <el-col :span="4" >商品id: </el-col>
                    <el-col :span="20">
                        <el-input class="local-input" v-model="formData.keyid" type="number" placeholder="请输入商品id"></el-input>
                    </el-col>
                </el-row>
                <!--<el-row v-if="formData.keytype == 2" :gutter="20" class="form-item1"> 
                    <el-col :span="4" >跳转网页类型: </el-col>
                    <el-col :span="20">
                        <el-radio class="radio" v-model="formData.link_type" :label="1">已有链接</el-radio>
                        <el-radio class="radio" v-model="formData.link_type" :label="2">自定义网页内容</el-radio>
                    </el-col>
                </el-row> -->
                <el-row v-if="formData.keytype == 2 && formData.link_type == 1" :gutter="20" class="form-item1"> 
                    <el-col :span="4" >跳转地址: </el-col>
                    <el-col :span="20">
                        <el-input class="local-input" v-model="formData.link" type="text" placeholder="请输入跳转地址"></el-input>
                    </el-col>
                </el-row>
                <el-row v-show="formData.keytype == 2 && formData.link_type == 2" :gutter="20" class="form-item1"> 
                    <el-col :span="4" >编辑内容: </el-col>
                    <el-col :span="20">
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </el-col>
                </el-row>
                <el-row :gutter="20" class="form-item1"> 
                    <el-col :span="4" >显示顺序: </el-col>
                    <el-col :span="20">
                        <el-input class="local-input" v-model="formData.sort" type="number" placeholder="显示顺序"></el-input>
                    </el-col>
                </el-row>
            <div slot="footer" class="dialog-footer">
                <el-button @click="closeBannerDialog()">取 消</el-button>
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
                content: null
            }
        },
        computed: {
            ...mapState({
                isDialogVisible: state => state.banner.isDialogVisible,
                upload_url: state => state.upload_url,
                data_for_upload: state => state.data_for_upload,
                host: state => state.host,
                formData: state => state.banner.formData
            })
        },
        methods: {
            ...mapMutations([
                'closeBannerDialog',
                'clearBannerFormData',
                'updateBannerImage',
                'updateBannerWebImage'
            ]),
            ...mapActions([
                'getBanners'
            ]),
            formSubmit () {
                var _this = this;
                if (_this.formData.id > 0) {
                    var url = this.host + 'banner/update';
                } else {
                    var url = this.host + 'banner/create';
                }
                _this.$http.post(url, _this.formData).then(response => {
                    if (response.body.success == 1) {
                        _this.closeBannerDialog();
                        _this.getBanners();
                        _this.clearBannerFormData();
                    } else {
                        alert(response.body.infor);
                    }
                });
            },
            closeDialog () {
                this.closeBannerDialog();
                this.clearBannerFormData();
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