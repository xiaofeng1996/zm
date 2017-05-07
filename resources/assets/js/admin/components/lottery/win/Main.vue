<template>
    <el-card class="box-card" >
        <div slot="header" class="clearfix">
            <span class="local-title">订单列表</span>
        </div>
        <div>
            <div class="table-operate">
                <edit-form ></edit-form>
            </div>
            <div>
                <list></list>
            </div>
        </div>
    </el-card> 
</template>

<script>
    import { mapMutations } from 'vuex';
    export default {
        components: {
            'list' : require('./List.vue'),
            'edit-form' : require('./EditForm.vue')
        }
    }
</script>

<style >
    .local-title {
        font-size: 16px;
    }
    .box-card {
        height: 100%; 
    }

    .table-operate {
        margin-bottom: 10px;
    }

</style>