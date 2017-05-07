<template>
    <div>
        <el-table
            :data="banners"
            border
            style="width: 100%">
            <el-table-column
                prop="keytype"
                label="跳转类型"
                width="120">
                <template scope="scope">
                    <span v-if="scope.row.keytype === 1">商品</span>
                    <span v-if="scope.row.keytype === 2">网页</span>
                </template>
            </el-table-column>
            <el-table-column
                label="手机图片"
                width="210">
                <template scope="scope">
                    <img class="banner-image" :src="scope.row.image" alt="">
                </template>
            </el-table-column>
            <el-table-column
                label="电脑图片"
                width="210">
                <template scope="scope">
                    <img class="banner-image" :src="scope.row.image_web" alt="">
                </template>
            </el-table-column>
            <el-table-column
                prop="keyid"
                label="商品id"
                width="80">
            </el-table-column>
            <el-table-column
                label="图文详情"
                width="120">
                <template scope="scope">
                    <a @click="openRichtextView(scope.row.id)" >图文详情</a>
                    <!--<a :href="scope.row.id" target="_blank">图文详情</a>-->
                </template>
            </el-table-column>
            <el-table-column
                prop="link"
                label="跳转链接">
            </el-table-column>
            <el-table-column
                prop="sort"
                label="显示顺序">
            </el-table-column>
            <el-table-column
                label="操作"
                width="100">
                <template scope="scope">
                    <el-button type="primary" size="mini" icon="edit" @click="edit(scope.row)"></el-button>
                    <el-button type="danger" size="mini" icon="delete" @click="del(scope.row.id)"></el-button>
                </template>
            </el-table-column>
        </el-table> 
    </div>
</template>

<script>

    import { mapState, mapActions, mapMutations } from 'vuex';

    export default {
        computed: mapState({
            banners: state => state.banner.banners,
            formData: state => state.banner.formData,
            host: state => state.host
        }),
        created () {
            var _this = this;
            this.getBanners();
        },
        methods: {
            ...mapActions({
                getBanners: 'getBanners'
            }),
            ...mapMutations({
                setFormData: 'setBannerFormData',
                openBannerDialog: 'openBannerDialog'
            }),
            edit (row) {
                this.setFormData(row);
                this.openBannerDialog();
            },
            del (id) {
                var _this = this;
                var url = _this.host + 'banner/delete';
                if (confirm('确认删除?')) {
                    _this.$http.post(url, {id: id}).then(response => {
                        _this.getBanners();
                    });
                }
            },
            openRichtextView (id) {
                window.open('/admin/richtext?module=banner&id=' + id); 
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