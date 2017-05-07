import Vue from 'vue';

const state = {
    form_data: {
        id: 0,
        goods_id: 0,
        title: '',
        price: 0,
        stock: 0,
        image: '/images/default_img.png'
    },
    attrs: [
    ],
    datas: [],
    is_dialog_visible: false
}

const actions = {
    getProductGoods ({ state, commit, rootState }, goods_id) {
        Vue.http.get('/admin/attr/goods/' + goods_id).then(response => {
            if (response.body.success == 1) {
                commit('setProductGoods', response.body.infor);
            }
        });
    },
    getProductAttrs ({state, commit, rootState}, goods_attr_id) {
        var data = {
            goods_attr_id: goods_attr_id
        };
        Vue.http.get('/admin/product/attrs/' + state.form_data.goods_id, {params: data}).then(response => {
            if (response.body.success == 1) {
                commit('setProductGoodsAttrs', response.body.infor);
            }
        });
    }
}

const mutations = {
    setProductGoods (state, datas) {
        state.datas = datas;
    },
    setProductGoodsAttrs (state, datas) {
        state.attrs = datas;
    },
    openProductGoodsDialog (state) {
        state.is_dialog_visible = true;
    },
    closeProductGoodsDialog (state) {
        state.is_dialog_visible = false;
    },
    setAttrGoodsId (state, goods_id) {
        state.form_data.goods_id = goods_id;
    },
    setProductGoodsFormData (state, data) {
        state.form_data.id              = data.id;
        state.form_data.title           = data.title;
        state.form_data.price           = data.price;
        state.form_data.stock           = data.stock;
        state.form_data.image           = data.image;
    },
    clearProductGoodsFormData (state) {
        state.form_data.id              = 0;
        state.form_data.title           = '';
        state.form_data.price           = 0;
        state.form_data.stock           = 0;
        state.form_data.image           = '/images/default_img.png';
        state.attrs                     = [{name: '属性1', field: 'attr1', value: ''}]
    },
    updateProductsImage (state, response) {
        state.form_data.image = response;
    },
}

export default {
    state,
    actions,
    mutations
}