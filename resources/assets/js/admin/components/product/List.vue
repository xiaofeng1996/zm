<template>
    <div>
        <div id="search-block">
            <ul>
                <li>
                    <el-select 
                        v-model="searches.is_lucky"
                        placeholder="商品类别" 
                        @change="chSearchType"
                    >
                        <el-option
                        v-for="type in search_types"
                        :label="type.label"
                        :value="type.value"
                        >
                        </el-option>
                    </el-select>
                </li>
                <li>
                    <el-input 
                        v-model="searches.name" 
                        placeholder="商品名称搜索"
                        @change="chSearchName">
                    </el-input>
                </li>
            </ul>
        </div>
        <el-table
            :data="datas"
            border
            style="width: 100%">
            <el-table-column
                fixed
                prop="id"
                label="商品id"
                width="120">
            </el-table-column>
            <el-table-column
                prop="merchant.name"
                label="所属店铺"
                width="120">
            </el-table-column>
            <el-table-column
                prop="name"
                label="商品名称"
                width="120">
            </el-table-column>
            <el-table-column
                label="审核状态"
                width="120">
                <template scope="scope">
                    <span v-if="scope.row.review_status == 0" style="color: #20A0FF;">未审核</span>
                    <span v-if="scope.row.review_status == 1" style="color: #13CE66;">审核通过</span>
                    <span v-if="scope.row.review_status == 2" style="color: #FF4949;">未通过</span>
                </template>
            </el-table-column>
            <el-table-column
                prop="category.name"
                label="商品类别"
                width="120">
            </el-table-column>
            <el-table-column
                label="商品图片"
                width="120">
                <template scope="scope">
                    <div class="merchant-img">
                        <img :src="scope.row.image" alt="">
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                    label="查看多图"
                    width="120">
                <template scope="scope">
                    <a @click="openImages(scope.row.id)">点击查看</a>
                </template>
            </el-table-column>
            <el-table-column
                    label="规格类别管理"
                    width="130">
                <template scope="scope">
                    <span class="z-link" @click="openProductAttrMan(scope.row.id)">点击查看</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="规格商品管理"
                    width="130">
                <template scope="scope">
                    <span class="z-link" :class="{warning: scope.row.attrs_count == 0}" @click="openAttrGoods(scope.row.id)">点击查看</span>
                </template>
            </el-table-column>
            <el-table-column
                prop="price"
                label="商品价格"
                width="120">
            </el-table-column>
            <el-table-column
                prop="old_price"
                label="原价"
                width="120">
            </el-table-column>
            <el-table-column
                    label="图文详情"
                    width="120">
                <template scope="scope">
                    <a @click="openRichtextView(scope.row.id)" >点击查看</a>
                    <!--<a :href="scope.row.id" target="_blank">图文详情</a>-->
                </template>
            </el-table-column>
            <el-table-column
                label="首页推荐"
                width="120">
                <template scope="scope">
                    {{ scope.row.recommend ? '是' : '否' }}
                </template>
            </el-table-column>
            <el-table-column
                label="支持退货"
                width="120">
                <template scope="scope">
                    {{ scope.row.support_return ? '是' : '否' }}
                </template>
            </el-table-column>
            <el-table-column
                label="幸运区商品"
                width="120">
                <template scope="scope">
                    {{ scope.row.is_lucky ? '是' : '否' }}
                </template>
            </el-table-column>
            <el-table-column
                prop="lucky_num"
                label="赠送号码数"
                width="120">
            </el-table-column>
            <el-table-column
                prop="lucky_rate"
                label="中奖率"
                width="120">
            </el-table-column>
            <el-table-column
                fixed="right"
                label="操作"
                width="100">
                <template scope="scope">
                    <el-button type="primary" size="mini" icon="edit" @click="edit(scope.row)"></el-button>
                    <el-button type="danger" size="mini" icon="delete" @click="del(scope.row.id)"></el-button>
                </template>
            </el-table-column>
        </el-table> 
        <div class="page-block">
            <el-pagination
            @current-change="getDatas"
            layout="prev, pager, next"
            :total="total"
            :page-size="page_size">
            </el-pagination>
        </div>
        <attr-man 
            ref = "attr_man"
            :show-dialog="show_attr_man_dialog" 
            @closeAttrMan="closeProductAttrMan"
        ></attr-man>
        <goods-man></goods-man>
        <images></images>
    </div>
</template>

<script>

    import { mapState, mapActions, mapMutations } from 'vuex';
    import AttrMan from './attr/AttrMan.vue';
    import GoodsMan from './goods/GoodsMan.vue';
    import Images from './images/Main.vue';

    export default {
        components: {
            'attr-man': AttrMan,
            'goods-man': GoodsMan,
            'images': Images
        },
        data () {
            return {
                search_types: [
                    {label: '全部商品', value: -1},
                    {label: '会员商品', value: 0},
                    {label: '幸运区商品', value: 1}
                ],
                show_attr_man_dialog: false,
                show_attr_goods_dialog: false,
                test_show: true
            }
        },
        computed: mapState({
            datas:          state => state.product.datas,
            searches:       state => state.product.searches,
            total:          state => state.product.total,
            page_size:      state => state.product.page_size,
            current_page:   state => state.product.current_page
        }),
        created () {
            this.getDatas();
        },
        methods: {
            ...mapActions({
                getDatas: 'getProducts',
                getProductGoods: 'getProductGoods',
                getProductImages: 'getProductImages'
            }),
            ...mapMutations({
                setFormData: 'setProductsFormData',
                openDialog: 'openProductsDialog',
                setSearchType: 'setSearchLucky',
                setSearchName: 'setSearchName',
                openAttrGoodsDialog: 'openAttrGoodsDialog',
                setAttrGoodsId: 'setAttrGoodsId',
                openProductImages: 'openProductImagesDialog',
                setImagesGoodsId: 'setProductImagesGoodsId'
            }),
            edit (row) {
                this.setFormData(row);
                this.openDialog();
            },
            del (id) {
                var _this = this;
                if (confirm('确认删除?')) {
                    _this.$http.post('/admin/products/destory/' + id).then(response => {
                        _this.getDatas();
                    });
                }
            },
            chSearchType (val) {
                this.setSearchType(val);
                this.getDatas();
            },
            chSearchName(name) {
                this.setSearchName(name);
                this.getDatas();
            },
            openProductAttrMan (goods_id) {
                this.show_attr_man_dialog = true;
                this.$refs.attr_man.getAttrCates(goods_id);
            },
            closeProductAttrMan () {
                this.show_attr_man_dialog = false;
            },
            openAttrGoods (goods_id) {
                this.openAttrGoodsDialog();
                this.setAttrGoodsId(goods_id);
                this.getProductGoods(goods_id);
            },
            openImages (goods_id) {
                this.openProductImages();
                this.setImagesGoodsId(goods_id);
                this.getProductImages(goods_id);
            },
            openRichtextView (id) {
                window.open('/admin/richtext?module=goods&id=' + id);
            }
        }
    }
</script>

<style scoped="scoped">
    #search-block {
        border-top: 1px solid #E5E9F2;
        padding: 10px;
        overflow: hidden;
    }

    #search-block li {
        float: left;
        margin-right: 20px;

        width: 120px;
    }

    a {
        color: #1D8CE0;
        cursor: pointer;
    }

    .merchant-img {
        width: 100px;
    }

    .merchant-img img {
        width: 80px;
    }

    .page-block {
        margin: 20px;
        float: right;
    }

    .z-link {
        color: #1D8CE0;
        cursor: pointer;
    }

    .warning {
        color: #FF4949;
    }

</style>