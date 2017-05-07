<template>
    <div>
        <el-dialog title="图片管理" v-model="is_dialog_visible" @close="close" size="tiny">
            <div class="top-btn">
                <el-button @click="openForm">添加</el-button>
            </div>
            <el-table
                :data="images"
                border
                max-height="480"
                style="width: 100%">
                <el-table-column
                    label="商品图片"
                    >
                    <template scope="scope">
                        <div class="goods-img">
                            <img :src="scope.row.image" alt="商品图片">
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    width="100"
                    label="显示顺序"
                >
                    <template scope="scope">
                        <el-input @change="updateSort(scope.row.id, scope.row.sort)" v-model="scope.row.sort"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                    label="操作"
                    width="100">
                    <template scope="scope">
                        <!--<el-button type="primary" size="mini" icon="edit" @click="edit(scope.row)"></el-button>-->
                        <el-button type="danger" size="mini" icon="delete" @click="del(scope.row)"></el-button>
                    </template>
                </el-table-column>
            </el-table> 
        </el-dialog>
        <edit-form></edit-form>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations } from 'vuex';
    import EditForm from './EditForm.vue';

    export default {
        components: {
            'edit-form': EditForm
        },
        data () {
            return {
            }
        },
        computed: {
            ...mapState({
                is_dialog_visible: state => state.product.is_product_images_visible,
                images: state => state.product_images.datas
            })
        },
        methods: {
            ...mapActions({
                getDatas: 'getProductImages'
            }),
            ...mapMutations({
                close: 'closeProductImagesDialog',
                openForm: 'openProductImagesForm',
                setFormData: 'setProductImagesForm'
            }),
//            edit (data) {
//                this.setFormData(data);
//                this.openForm();
//            },
            del (data) {
                if (confirm('确认删除?')) {
                    var _this = this;
                    _this.$http.post('/admin/product/images/destory/' + data.id).then(response => {
                        if (response.body.success==1) {
                            this.getDatas(data.imageable_id);
                        } else {
                            alert(response.body.infor);
                        }
                    });
                }
            },
            updateSort (id, sort) {
                this.$http.post('/admin/product/images/sort', {id: id, sort: sort}).then(response => {
                    if (response.body.success != 1) {
                        alert(response.body.infor);
                    }
                });
            }
        }
    }
</script>

<style scoped="scoped">
    .top-btn {
        margin-bottom: 20px;
    }

    .goods-img {
        margin: 0 auto;
        padding: 10px;
    }
    .goods-img img {
        width: 80px;
        height: 80px;
    }
</style>