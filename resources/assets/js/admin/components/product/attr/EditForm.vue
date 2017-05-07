<template>
    <div>
        <el-dialog title="规格添加/修改" v-model="is_dialog_visible" class="product-attr-edit" @close="close" size="tiny">
            <el-form ref="form_data" :model="form_data" label-width="90px">
                <el-form-item label="规格名称">
                    <el-input v-model="form_data.name"></el-input>
                </el-form-item>
                <el-form-item label="规格值">
                    <el-input v-for="val in form_data.vals" v-model="val.val" class="val-input"></el-input>
                    <div class="plus" @click="addVal" >
                        <i class="el-icon-plus"></i>
                    </div>
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
    export default {
        data () {
            return {
                form_data: {
                    id: 0,
                    name: '',
                    vals: [
                        {id: 0, val: ''}
                    ]
                }
            }
        },
        props: ['show_dialog', 'goods_id'],
        computed: {
            is_dialog_visible () {
                return this.show_dialog;
            }
        },
        methods: {
            close () {
                this.$emit('close');
                this.clear();
            },
            formSubmit () {
                var _this = this;
                var data = _this.form_data;
                data.goods_id = _this.goods_id;
                _this.$http.post('/admin/attr/cates', data).then(response => {
                    if (response.body.success == 1) {
                        _this.close();
                    } else {
                        alert(response.body.infor);
                    }
                });
            },
            setFormData (data) {
                this.form_data.id   = data.id;
                this.form_data.name = data.name;
                this.form_data.vals = data.vals.length ? data.vals : [{id: 0, val: ''}];
            },
            clear () {
                this.form_data.id = 0;
                this.form_data.name = '';
                this.form_data.vals = [{id: 0, val: ''}];
            },
            addVal () {
                var val_len = this.form_data.vals.length;
                var last_val = this.form_data.vals[val_len - 1];
                if (last_val.val == '') {
                    alert('属性值不能为空');
                } else {
                    var val = {id: 0, val: ''};
                    this.form_data.vals.push(val);
                }
            }
        }
    }
</script>

<style scoped="scoped">
    .product-attr-edit {
        z-index: 999;
    }
    .plus {
        border: 2px solid #8492A6;
        width: 34px;
        margin-top: 20px;
        text-align: center;
        cursor: pointer;
    }
    .val-input {
        margin-top: 10px;
    }
</style>