<template>
    <div id="login-panel">
        <div class="login-panel-header">
            <h1>知美商城--修改密码</h1>
        </div>
        <div class="login-panel-body">
            <el-form :model="form_data" :rules="rules" ref="reset_form">
                <el-form-item prop="mobile">
                    <el-input type="text" v-model="form_data.mobile" required="true" placeholder="请输入手机号 / 用户名" ></el-input>
                </el-form-item>
                <el-form-item prop="old_password">
                    <el-input type="password" v-model="form_data.old_password" placeholder="请输入原密码"></el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input type="password" v-model="form_data.password" placeholder="请输入原密码"></el-input>
                </el-form-item>
                <el-form-item prop="re_password">
                    <el-input type="password" v-model="form_data.re_password" placeholder="请输入原密码"></el-input>
                </el-form-item>
                <el-form-item class="btn-item">
                    <el-button type="primary" size="small" @click="submit('reset_form')">提交</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                form_data: {
                    mobile: '',
                    old_password: '',
                    password: '',
                    re_password: ''
                },
                rules: {
                    mobile: [
                        { required: true, message: "手机号不能为空", trigger: "blur"}
                    ],
                    old_password: [
                        { required: true, message: "原密码不能为空", trigger: "blur"}
                    ],
                    password: [
                        { required: true, message: "密码不能为空", trigger: "blur"}
                    ],
                    re_password: [
                        { required: true, message: "确认密码不能为空", trigger: "blur"}
                    ]
                }
            }
        },
        methods: {
            submit () {
                this.$http.post('/admin/password/reset', this.form_data).then(response => {
                    if (response.body.success == 1) {
                        this.$router.replace('/');
                    } else {
                        alert(response.body.infor);
                    }
                });
            }
        }
    }
</script>

<style>
    #login-panel {
        width: 400px;
        margin: 100px auto;
    }

    .login-panel-header {
        height: 60px;
        text-align: center;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
    }

    .login-panel-header h1 {
        line-height: 60px;
        text-align: center;

        font-size: 22px;
        color: #ffffff;
        background-color: #20A0FF;

    }

    .login-panel-body {
        border: 1px solid #E5E9F2;
        padding: 40px 40px;
    }

    .btn-item {
        text-align: right;
    }

</style>