
import Vue from 'vue';

const state = {
    banners: [],
    formData: {
        id: 0,
        keytype: 1,
        keyid: 0,
        link_type: 1,
        link: '',
        content: '',
        image: '',
        image_web: '', 
        sort: 0
    },
    isDialogVisible: false
}

const actions = {
    getBanners ({ state, commit, rootState }) {
        var url = rootState.host + 'banners';
        Vue.http.get(url).then(response => {
            commit('setBanners', response.data.infor);
        })
    }
}

const mutations = {
    setBanners (state, banners) {
        state.banners = banners;
    },
    openBannerDialog (state) {
        state.isDialogVisible = true;
    },
    closeBannerDialog (state) {
        state.isDialogVisible = false;
    },
    setBannerFormData (state, banner) {
        state.formData.id = banner.id;
        state.formData.keytype = banner.keytype;
        state.formData.keyid = banner.keyid;
        state.formData.link_type = banner.link_type ? banner.link_type : 1,
        state.formData.link = banner.link,
        state.formData.content = banner.content,
        state.formData.image = banner.image,
        state.formData.image_web = banner.image_web,
        state.formData.sort = banner.sort
    },
    clearBannerFormData (state) {
        state.formData.id = 0;
        state.formData.keytype = 1;
        state.formData.keyid = 0;
        state.formData.link_type = 1,
        state.formData.link = '',
        state.formData.content = '',
        state.formData.image = '',
        state.formData.image_web = '',
        state.formData.sort = 0
    },
    updateBannerImage (state, response) {
        state.formData.image = response;
    },
    updateBannerWebImage (state, response) {
        state.formData.image_web = response;
    }
}

export default {
    state,
    actions,
    mutations
}