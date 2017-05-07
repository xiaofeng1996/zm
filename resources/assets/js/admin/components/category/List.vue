<template>
    <div class="tree-block">
        <el-tree 
            :data="datas" 
            :props="default_props"
            :render-content="render"
            :expand-on-click-node="false"
            :default-expand-all="true"
            accordion 
        >
        </el-tree>
    </div>
</template>

<script>

    import { mapState, mapActions, mapMutations } from 'vuex';

    export default {
        data () {
            return {
                default_props: {
                    label: 'name',
                    children: 'children'
                },
                current_node: {},
            }
        },
        computed: mapState({
            datas: state => state.category.datas
        }),
        created () {
            var _this = this;
            this.getDatas();
        },
        methods: {
            ...mapActions({
                getDatas: 'getCategories'
            }),
            ...mapMutations({
                openDialog: 'openCategoryDialog',
                setFormData: 'setCategoryFormData',
                clearFormData: 'clearCategoryFormData',
                setParentId: 'setCategoryParentId'
            }),
            addChild (data) {
                if (data.lv >= 2) {
                    alert('最多添加三级分类');
                } else {
                    this.setParentId(data.id);
                    this.openDialog();
                }
            },
            edit (data) {
                this.setFormData(data);
                this.openDialog();
            },
            del (id) {
                if (confirm('确认删除?')) {
                    var _this = this;
                    _this.$http.post('/admin/category/del', {id: id}).then(response => {
                        if (response.body.success == 1) {
                            _this.getDatas();
                        } else {
                            alert(response.body.infor);
                        }
                    });
                }
            },
            render (h, node) {
                var _this = this;
                return h('span', 
                           [
                               h('span', {
                                   domProps: {
                                       innerHTML: node.data.name
                                   },
                                   style: {
                                       display: 'inline-block',
                                       width: '80px'
                                   }
                               }), 
                               h('img', node.data.image 
                                        ? {
                                              attrs: {
                                                  src: node.data.image
                                              },
                                              style: {
                                                  height: '20px',
                                                  width: '20px',
                                              }
                                          } 
                                        : ''
                               ),
                               h('span', {
                                   style: {
                                       marginLeft: '20px',
                                       fontSize: '12px',
                                       color: '#20A0FF'
                                   }
                               },
                               [
                                   h('span', {
                                       style: {
                                           cursor: 'pointer' 
                                       },
                                       on: {
                                           click: function () {
                                               _this.addChild(node.data);
                                           }
                                       }
                                   }, '添加子类'),
                                   h('span', {
                                       style: {
                                           cursor: 'pointer',
                                           marginLeft: '20px'
                                       },
                                       on: {
                                           click: function () {
                                               _this.edit(node.data);
                                           }
                                       }
                                   }, '编辑'),
                                   h('span', {
                                       style: {
                                           cursor: 'pointer', 
                                           marginLeft: '20px',
                                           color: '#FF4949'
                                       },
                                       on: {
                                           click: function () {
                                               _this.del(node.data.id);
                                           }
                                       }
                                   }, '删除')
                               ])
                           ]
                       );
            }
            // ...mapMutations({
            //     setFormData: 'setProductsFormData',
            //     openDialog: 'openProductsDialog',
            //     setSearchType: 'setSearchLucky',
            //     setSearchName: 'setSearchName'
            // }),
            // edit (row) {
            //     this.setFormData(row);
            //     this.openDialog();
            // },
            // del (id) {
            //     var _this = this;
            //     if (confirm('确认删除?')) {
            //         _this.$http.post('/admin/merchant/delete', {id: id}).then(response => {
            //             _this.getDatas();
            //         });
            //     }
            // },
            // chSearchType (val) {
            //     this.setSearchType(val);
            //     this.getDatas();
            // },
            // chSearchName(name) {
            //     this.setSearchName(name);
            //     this.getDatas();
            // }
        }
    }
</script>

<style>
    .tree-block {
        padding: 20px;
    }
</style>