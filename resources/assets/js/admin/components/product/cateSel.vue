<template>
    <div>
        <el-select 
            v-for="(cates, index) in catess"
            v-model="values[index]" 
            placeholder="请选择"
            class="cate-sel"
            @change="chCate(values[index])"
        >
            <el-option
                v-for="cate in cates"
                :label="cate.name"
                :value="cate.id"
            >
            </el-option>
        </el-select>
    </div>
</template>

<script>

    import { mapMutations } from 'vuex';

    export default {
        data () {
            return {
                parent_id: 0,
                catess: [],
                values: []
            }
        },
        created () {
            this.getCates();
        },
        methods: {
            ...mapMutations({
                'setCateId': 'setProductCateId'
            }),
            getCates (parent_id) {
                var parent_id = parent_id ? parent_id : 0;
                var _this = this;
                _this.$http.get('/admin/cates/' + parent_id).then(response => {
                    var data = response.body;
                    if (response.body.success == 1 && response.body.infor.length > 0) {
                        _this.catess.push(response.body.infor);
                    }
                });
            },
            chCate (id) {
                this.setCateId(id);
                this.getCates (id);
            },
            clear () {
                this.catess = [];
                this.values = [];
                this.getCates();
            }
        }
    }
</script>

<style>
    .cate-sel {
        margin-right: 10px;
        margin-bottom: 20px;
    }
</style>