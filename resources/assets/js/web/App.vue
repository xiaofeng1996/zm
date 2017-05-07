<template>
    <div>
        <passport-clients></passport-clients>
        <passport-authorized-clients></passport-authorized-clients>
        <passport-personal-access-tokens></passport-personal-access-tokens>
    </div>
</template>

<script>

    Vue.component(
       'passport-clients',
       require('./components/passport/Clients.vue')
    );

    Vue.component(
       'passport-authorized-clients',
       require('./components/passport/AuthorizedClients.vue')
    );

    Vue.component(
       'passport-personal-access-tokens',
       require('./components/passport/PersonalAccessTokens.vue')
    );

    export default {
        created () {
            // this.$http.get('/').then(response => {
            //    console.log(response.data);
            // })
        }
    }
</script>

<style>

</style>