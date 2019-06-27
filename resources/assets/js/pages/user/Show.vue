<template>
	<div id="edit-form">
		<!--添加用户表单-->
		  <el-form :model="form" ref="form">
			<el-form-item label="姓名" :label-width="formLabelWidth" prop="name">
			  <el-input v-model="form.name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="昵称" :label-width="formLabelWidth" prop="nickname">
			  <el-input v-model="form.nickname" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="邮箱" :label-width="formLabelWidth" prop="email"
				:rules="[
					{ required: true, message: '邮箱不能为空', trigger: 'blur' },
					{ type: 'email', message: '必须为邮件', trigger: ['blur', 'change'] },
				]"
			>
			  <el-input v-model="form.email" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="手机号" :label-width="formLabelWidth" prop="phone"
				:rules="[
					{required: true, message: '手机号不能为空'},
					{type: 'number', message: '必须为数字'},
				]"
			>
			  <el-input v-model.number="form.phone" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="密码" :label-width="formLabelWidth" prop="password"
				:rules="[
					{required: true, message: '密码不能为空'},
					{type: 'string', min: 6, message: '最少6位'},
				]"
			>
			  <el-input type="password" v-model="form.password" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="角色" :label-width="formLabelWidth" prop="role_id"
				:rules="[
					{required: true, message: '角色不能为空', trigger: 'change'},
					{type: 'array', message: '至少一种角色'},
				]"
            >
                <el-select v-model="form.role_id" multiple placeholder="请选择">
                    <el-option
                        v-for="role in roles"
                        :key="role.id"
                        :label="role.display_zh_name"
                        :value="role.id">
                    </el-option>
                </el-select>
			</el-form-item>

		  </el-form>
		  <div slot="footer" id="edit-form-footer">
			<el-button type="primary" @click="updateUser('form')">确 定</el-button>
			<el-button @click="cancleAddUser">取 消</el-button>
		  </div>
	</div>
</template>
<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
	  data() {
		return {
			// module store
			formLabelWidth: '100px',
            roles: [],
			form: {
				id: '',
				name: '',
				nickname: '',
				email: '',
				phone: '',
				password: '',
                role_id: '',
			},
	    }
	  },

      computed: {
      },

      created () {
        this.fetchRoles()
      },

      methods: {

        //获取用户列表
        fetchUsers () {
            http({
                url: Api.users,
            }).then(response => {
                this.tableData = response.data.data
                this.originTableData = response.data.data
            })
        },

		//取消添加用户
		cancleAddUser () {
            consle.log('cancle');
		},

        //确认添加用户
        updateUser (form) {
            this.$refs[form].validate((valid) => {
              if (valid) {
                http({
                    method: 'post',
                    url: Api.storeUser,
                    data: this.form
                }).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
                    this.$refs[form].resetFields();
                }).catch(err => {
                    console.log(err)
                })

              } else {
                return false;
              }
            })
        },

        //获取角色列表
        fetchRoles () {
            http({
                url: Api.roles,
            }).then(response => {
                this.roles = response.data.data
            })
        },
      }
    }
</script>

<style>
#edit-form {
    padding: 20px;
    width: 600px;
}
#edit-form-footer {
    width: 600px;
    margin-left: 200px;
}
</style>
