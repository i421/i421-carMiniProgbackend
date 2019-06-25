<template>
    <div id="resetPasswordForm">
		<el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
		  <el-form-item label="原密码" prop="originPass">
			<el-input type="password" v-model="ruleForm.originPass"></el-input>
		  </el-form-item>
		  <el-form-item label="新密码" prop="pass">
			<el-input type="password" v-model="ruleForm.pass" autocomplete="off"></el-input>
		  </el-form-item>
		  <el-form-item label="确认密码" prop="checkPass">
			<el-input type="password" v-model="ruleForm.checkPass" autocomplete="off"></el-input>
		  </el-form-item>
		  <el-form-item>
			<el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
			<el-button @click="resetForm('ruleForm')">重置</el-button>
		  </el-form-item>
		</el-form>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
    data() {
      var validateOriginPass = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('原密码不能为空'));
        } else {
        	callback();
		}
      };
      var validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'));
        } else if (value.length < 6) {
          callback(new Error('密码至少6位'));
		} else {
          if (this.ruleForm.checkPass !== '') {
            this.$refs.ruleForm.validateField('checkPass');
          }
          callback();
        }
      };
      var validateCheckPass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'));
        } else if (value !== this.ruleForm.pass) {
          callback(new Error('两次输入密码不一致!'));
        } else {
          callback();
        }
      };
      return {
        ruleForm: {
          pass: '',
          checkPass: '',
          originPass: ''
        },
        rules: {
          pass: [
            { validator: validatePass, trigger: 'blur' }
          ],
          checkPass: [
            { validator: validateCheckPass, trigger: 'blur' }
          ],
          originPass: [
            { validator: validateOriginPass, trigger: 'blur' }
          ]
        }
      };
    },
    methods: {
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {

          if (valid) {
            http({
                url: Api.updatePassword,
                method: 'post',
                data: this.ruleForm
            }).then(response => {
				this.$notify.success({
					'title': "提示",
					'message': response.data.msg
            	})
			})
          } else {
            return false;
          }
        });
      },
      resetForm(formName) {
        this.$refs[formName].resetFields();
      }
    }
  }
</script>

<style scoped>
#resetPasswordForm {
	width: 450px;
}
</style>
