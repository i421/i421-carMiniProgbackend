<template>
    <div id="loginPage">
		<div class="login">
			<div class="message">
				登录界面
			</div>
            <div id="darkbannerwrap"></div>
			<div id="loginForm">
				<el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
				  <el-form-item prop="login">
					<el-input type="text" v-model="ruleForm.login" autocomplete="off" placeholder="用户名/邮箱/手机号"></el-input>
				  </el-form-item>
                  <el-form-item prop="password">
                    <el-input show-password type="password" v-model="ruleForm.password" auto-complete="off" placeholder="密码"></el-input>
                  </el-form-item>
				  <el-form-item>
					<el-button class="submit" type="primary" @click="submitForm('ruleForm')" :loading="loading">提交</el-button>
				  </el-form-item>
				</el-form>
			</div>
		</div>	
    </div>
</template>

<script>

  import Api from './../../config'
  import systemConfig from './../../env'
  import { http } from './../../utils/fetch'
  import { aesEncrypt, encryptData } from './../../utils/encrypt.js'

  export default {
    data() {
      var validatePassword = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'));
        } else {
          callback();
        }
      };
      var validateLogin = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入用户名/邮箱/手机号'));
        } else {
          callback();
        }
      };
      return {
        ruleForm: {
          login: '',
          password: '',
        },
        formDatas: [],
        loading: false,
        rules: {
          password: [
            { validator: validatePassword, trigger: 'blur' }
          ],
          login: [
            { validator: validateLogin, trigger: 'blur' }
          ]
        }
      };
    },

    mounted () {
        if (this.$store.state.access_token !== null && this.$store.state.auth_user !== null) {
            this.$router.push('/dashboard')
        }
    },

    methods: {
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.loading = true;

            var formData = this.newFormData;

            const postData = {
                grant_type: 'password',
                client_id: aesEncrypt(systemConfig.clientId),
                client_secret: aesEncrypt(systemConfig.clientSecret),
                username: this.ruleForm.login,
                password: aesEncrypt(this.ruleForm.password),
                scope: ''
            }

            this.formDatas.push(formData);
            this.formData = {username: '', password: ''};

            http({
                url: Api.oauthToken,
                method: 'post',
                data: postData
            }).then(response => {

                //set token
                /*
                const authToken = {}
                authToken.access_token = response.data.access_token
                authToken.refresh_token = response.data.refresh_token
                */
                this.$store.dispatch('setAccessToken', response.data.access_token)
                /*
                let encryptToken = encryptData(authToken)
                window.localStorage.setItem('token', encryptToken)
                */

                http({
                    url: Api.userInfo,
                }).then(response => {

                    let authUser = response.data.data

                    /*
                    var encryptAuthUser = encryptData(authUser)
                    var encryptVersion = encryptData(systemConfig.version)
                    */

                    this.$store.dispatch('setAuthUser', authUser)
                    this.$store.dispatch('setSysVersion', systemConfig.version)

                    /*
                    window.localStorage.setItem('authUser', encryptAuthUser)
                    window.localStorage.setItem('version', encryptVersion)
                    */
                    this.$router.push('/dashboard')

                }, response => {
                    console.log(err)
                })

                this.loading = false;

            }).catch(err => {
                console.log(err)
            })

            this.loading = false;

          } else {
            this.loading = false;
          }
        });
      },

      resetForm(formName) {
        this.$refs[formName].resetFields();
      }
    }
  }
</script>

<style>
#loginPage {
    width: 100%;
    height: 100%;
	overflow: hidden;
    background: url("/images/login.jpg") no-repeat center;
    background-size: cover;
    z-index: -1;
}
#loginPage .login {
	margin: 150px auto;
	min-height: 420px;
	max-width: 420px;
	padding: 40px;
	background-color: #fff;
	border-radius: 4px;
	box-sizing: border-box;
}
#loginPage #darkbannerwrap {
    background: url("/images/darkbannerwrap.png");
    width: 18px;
    height: 10px;
    margin: 0 0 20px -58px;
}
#loginPage .message {
	margin: 10px 0 0 -58px;
	padding: 18px 10px 18px 60px;
	background: #27a9e3;
	color: #fff;
	font-size: 16px;
}
#loginPage .form {
	margin: 20px 0 20px -58px;
}
#loginPage .submit {
    width: 100%;
    background-color: #27a9e3;
}
#loginForm .el-form-item__content {
    margin-left: 0px !important;
}
</style>
