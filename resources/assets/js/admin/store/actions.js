import Vue from 'vue';
export default {
    getRole (context) {
        Vue.http.get('/admin/role').then(response => {
            if (response.body.success == 1) {
                context.commit('setRoleId', response.body.infor.role_id);
            }
        });
    }
}