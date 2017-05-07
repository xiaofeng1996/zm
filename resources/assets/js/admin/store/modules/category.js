
import Vue from 'vue';

const state = {
    datas: [],
    dialog_visible: false,
    form_data: {
        id: 0,
        parent_id: 0,
        name: '',
        image: '/images/default_img.png',
        sort: 0
    }
}

const actions = {
    getCategories ({ state, commit, rootState }) {
        Vue.http.get('/admin/categories').then(response => {
            commit('setCategories', response.body.infor);
        })
    }
}

const mutations = {
    setCategories (state, datas) {
        state.datas = datas;
    },
    openCategoryDialog (state) {
        state.dialog_visible = true;
    },
    closeCategoryDialog (state) {
        state.dialog_visible = false;
    },
    setCategoryParentId (state, parent_id) {
        state.form_data.parent_id = parent_id;
    },
    setCategoryFormData (state, data) {
        state.form_data.id        = data.id;
        state.form_data.parent_id = data.parent_id;
        state.form_data.name      = data.name;
        state.form_data.image     = data.image;
        state.form_data.sort      = data.sort;
    },
    clearCategoryFormData (state) {
        state.form_data.id        = 0;
        state.form_data.parent_id = 0;
        state.form_data.name      = '';
        state.form_data.image     = '';
        state.form_data.sort      = 0;
    },
    uploadCategoryImg (state, response) {
        state.form_data.image = response;
    }
}

export default {
    state,
    actions,
    mutations
}