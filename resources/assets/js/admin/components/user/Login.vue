<template>
    <div id="login-panel">
        <div class="login-panel-header">
            <h1>知美商城--登录</h1>
        </div>
        <div class="login-panel-body">
            <el-form :model="form_data" :rules="rules" ref="login_form">
                <el-form-item prop="mobile">
                    <el-input type="text" v-model="form_data.mobile" required="true" placeholder="请输入手机号 / 用户名" ></el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input type="password" v-model="form_data.password" placeholder="请输入密码"></el-input>
                </el-form-item>
                <el-form-item class="btn-item">
                    <el-button type="primary" size="small" @click="submitForm('login_form')">提交</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>

    import { mapActions } from 'vuex';

    export default {
        data () {
            return {
                form_data: {
                    mobile: '',
                    password: ''
                },
                rules: {
                    mobile : [
                        { required: true, message: "手机号不能为空", trigger: "blur"}
                    ],
                    password: [
                        { required: true, message: "密码不能为空", trigger: "blur"}
                    ]
                }
            }
        },
        methods: {
            ...mapActions({
                getRole: 'getRole'
            }),
            submitForm (form_name) {
                var _this = this;
                _this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        _this.$http.post("admin/login", this.form_data).then(response => {
                            if (response.data.success == 1) {
                                _this.getRole();
                                _this.$router.push('/');
                            } else {
                                alert(response.data.infor);
                            }
                        });
                    } 
                })
            }
        }
    }
</script>

<style scoped>
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