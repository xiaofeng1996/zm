<template>
    <div>
        <el-dialog title="商品规格管理(最多添加两个规格, 如: 颜色, 尺寸)" v-model="is_dialog_visible" @close="close" size="tiny">
            <div class="top-btn">
                <el-button @click="add">添加</el-button>
            </div>
            <el-table
                    :data="attrs"
                    border
                    max-height="480"
                    style="width: 100%">
                <el-table-column type="expand">
                    <template scope="scope">
                        <el-tag
                                v-for="(val, key) in scope.row.vals"
                                :closable="true"
                                type="primary"
                                class="tag"
                                @close="delCateVal(key, val.id, scope.row)"
                        >
                            {{val.val}}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="规格名称"
                >
                    <template scope="scope">
                        {{ scope.row.name }}
                    </template>
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
        </el-dialog>
        <edit-form 
            ref = "product_attr_form"
            @close="closeEditForm" 
            :show_dialog="show_edit_form"
            :goods_id="goods_id"
        ></edit-form>
    </div>
</template>

<script>

    import EditForm from './EditForm.vue';

    export default {
        components: {
            'edit-form': EditForm
        },
        props: ['showDialog'],
        data () {
            return {
                goods_id: 0,
                attrs: [],
                show_edit_form: false
            }
        },
        computed: {
            is_dialog_visible () {
                return this.showDialog;
            }
        },
        methods: {
            close () {
                this.goods_id = 0;
                this.$emit('closeAttrMan');
            },
            getAttrCates (goods_id) {
                var _this = this;
                _this.goods_id = goods_id;
                _this.$http.get('/admin/attr/cates/' + goods_id).then(response => {
                    if (response.body.success == 1) {
                        _this.attrs = response.body.infor;
                    }
                });
            },
            add () {
                if (this.attrs.length >= 2) {
                    alert('最多添加两个属性');
                } else {
                    this.show_edit_form = true;
                }
            },
            edit (data) {
                this.$refs.product_attr_form.setFormData(data);
                this.show_edit_form = true;
            },
            del (id) {
                if (confirm('确定删除?')) {
                    var _this = this;
                    var data = {
                        id: id,
                        goods_id: _this.goods_id
                    }
                    _this.$http.post('/admin/attr/cates/destory', data).then(response => {
                        if (response.body.success == 1) {
                            _this.getAttrCates(_this.goods_id);
                        }
                    });
                }
            },
            closeEditForm () {
                this.show_edit_form = false
                this.getAttrCates (this.goods_id);
            },
            delCateVal (key, id, row) {
                this.$http.post('/admin/attr/cates/val/destory', {id: id}).then(response => {
                    if (response.body.success == 1) {
                        row.vals.splice(key, 1);
                    } else {
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

    .tag {
        margin-left: 10px;
    }

</style>