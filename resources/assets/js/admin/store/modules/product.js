
import Vue from 'vue';

const state = {
    datas: [],
    total: 0,
    page_size: 20,
    searches: {
        page: 1,
        is_lucky: -1,
        name: ''
    },
    form_data: {
        id: 0,
        merchant_id: 1,
        cates: [],
        category_id: 0,
        name: '',
        image: '/images/default_img.png',
        price: 0,
        old_price: 0,
        support_return: '0',
        is_lucky: '0',
        recommend: '0',
        lucky_num: 0,
        lucky_rate: 0,
        sort: 0,
        review_status: 0
    },
    is_dialog_visible: false,
    is_attr_goods_visible: false,
    is_product_images_visible: false
}

const actions = {
    getProducts ({ state, commit, rootState }, page) {
        if (page) {
            state.searches.page = page;
        }
        Vue.http.get('/admin/products', {params: state.searches}).then(response => {
            commit('setProducts', response.body.infor.data);
            commit('setProductsTotal', response.body.infor.total);
            commit('setProductsPageSize', response.body.infor.per_page);
        })
    }
}

const mutations = {
    setProducts (state, datas) {
        state.datas = datas;
    },
    setProductsTotal (state, total) {
        state.total = total;
    },
    setProductsPageSize (state, page_size) {
        state.page_size = page_size;
    },
    openProductsDialog (state) {
        state.is_dialog_visible = true;
    },
    closeProductsDialog (state) {
        state.is_dialog_visible = false;
    },
    openAttrGoodsDialog (state) {
        state.is_attr_goods_visible = true;
    },
    closeAttrGoodsDialog (state) {
        state.is_attr_goods_visible = false;
    },
    openProductImagesDialog (state) {
        state.is_product_images_visible = true;
    },
    closeProductImagesDialog (state) {
        state.is_product_images_visible = false;
    },
    setProductCateId (state, cate_id) {
        state.form_data.category_id = cate_id;
    },
    setProductsFormData (state, data) {
        state.form_data.id              = data.id;
        state.form_data.merchant_id     = data.merchant_id;
        state.form_data.category_id     = data.category_id;
        state.form_data.name            = data.name;
        state.form_data.image           = data.image;
        state.form_data.price           = data.price;
        state.form_data.old_price       = data.old_price;
        state.form_data.support_return  = data.support_return.toString();
        state.form_data.is_lucky        = data.is_lucky.toString();
        state.form_data.recommend       = data.recommend.toString();
        state.form_data.lucky_num       = data.lucky_num;
        state.form_data.lucky_rate      = data.lucky_rate.replace('%', '');
        state.form_data.sort            = data.sort;
        state.form_data.review_status   = data.review_status;
    },
    clearProductsFormData (state) {
        state.form_data.id              = 0;
        state.form_data.merchnat_id     = 0;
        state.form_data.category_id     = 0;
        state.form_data.name            = '';
        state.form_data.image           = '/images/default_img.png';
        state.form_data.price           = 0;
        state.form_data.old_price       = 0;
        state.form_data.support_return  = '0';
        state.form_data.is_lucky        = '0';
        state.form_data.recommend       = '0';
        state.form_data.lucky_num       = 0;
        state.form_data.lucky_rate      = 0;
        state.form_data.sort            = 0;
        state.form_data.review_status   = 0;
    },
    setSearchLucky (state, val) {
        state.searches.is_lucky = val;
    },
    setSearchName (state, name) {
        state.searches.name = name;
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