import Vue from 'vue';

const state = {
    form_data: {
        id: 0,
        goods_id: 0
        // image: '/images/default_img.png',
        // sort: 0
    },
    datas: [],
    is_dialog_visible: false
}

const actions = {
    getProductImages ({ state, commit, rootState }, goods_id) {
        Vue.http.get('/admin/product/images/' + goods_id).then(response => {
            if (response.body.success == 1) {
                commit('setProductImages', response.body.infor);
            }
        });
    }
}

const mutations = {
    setProductImages (state, datas) {
        state.datas = datas;
    },
    openProductImagesForm (state) {
        state.is_dialog_visible = true;
    },
    closeProductImagesForm (state) {
        state.is_dialog_visible = false;
    },
    setProductImagesForm (state, data) {
        state.form_data.id          = data.id;
        state.form_data.goods_id    = data.imageable_id;
        state.form_data.image       = data.image;
        state.form_data.sort        = data.sort;
    },
    clearProductImagesForm (state) {
        state.form_data.id          = 0;
        state.form_data.goods_id    = 0;
        state.form_data.image       = '/images/default_img.png';
        state.form_data.sort        = 0;
    },
    setProductImagesGoodsId (state, goods_id) {
        state.form_data.goods_id = goods_id;
    },
    updateProductImagesIm (state, response) {
        state.form_data.image = response;
    },
}

export default {
    state,
    actions,
    mutations
}
