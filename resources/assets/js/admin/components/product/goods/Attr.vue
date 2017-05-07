<template>
    <div>
        <el-input
            class="attr-input"
            v-for="(attr, key) in attrs"
            v-model="attr.value"
            :placeholder="attr.name"
        ></el-input>
    </div>
</template>

<script>
    import { mapState, mapMutations, mapActions } from 'vuex';

    export default {
        computed: {
            ...mapState({
                attrs: state => state.product_goods.attrs
            }),
            local_attr_input: []
        },
        methods: {
        }
    }
</script>

<style scoped="scoped">
    .attr-input {
        margin-top: 10px;
    }
</style>