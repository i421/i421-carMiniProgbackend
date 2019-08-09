<template>
	<div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-input class="table-search" v-model="search" placeholder="输入关键字查询" @input="searchData"></el-input>
            <el-button type="primary" class="table-button" icon="el-icon-plus" @click="dialogFormVisible = true">添加用户</el-button>
        </div>
		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>
        </data-tables>

		<!--添加用户表单-->
		<el-dialog title="添加用户" :visible.sync="dialogFormVisible">
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
		  <div slot="footer" class="dialog-footer">
			<el-button @click="cancleAddUser">取 消</el-button>
			<el-button type="primary" @click="addUser('form')">确 定</el-button>
		  </div>
		</el-dialog>

		<!--更新用户表单-->
		<el-dialog title="更新用户" :visible.sync="dialogUpdateFormVisible">
		  <el-form :model="updateForm" ref="updateForm" :inline="true">
			<el-form-item label="姓名" :label-width="formLabelWidth" prop="name">
			  <el-input v-model="updateForm.name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="昵称" :label-width="formLabelWidth" prop="nickname">
			  <el-input v-model="updateForm.nickname" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="邮箱" :label-width="formLabelWidth" prop="email"
				:rules="[
					{ required: true, message: '邮箱不能为空', trigger: 'blur' },
					{ type: 'email', message: '必须为邮件', trigger: ['blur', 'change'] },
				]"
			>
			  <el-input v-model="updateForm.email" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="手机号" :label-width="formLabelWidth" prop="phone"
				:rules="[
					{required: true, message: '手机号不能为空'},
					{type: 'number', message: '必须为数字'},
				]"
			>
			  <el-input v-model.number="updateForm.phone" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="角色" :label-width="formLabelWidth" prop="role_id"
				:rules="[
					{required: true, message: '角色不能为空'},
                ]"
            >
                <el-select v-model="updateForm.role_id" multiple placeholder="请选择" @change="changeRole">
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
			<el-button type="primary" @click="updateUser('updateForm')">确 定</el-button>
			<el-button @click="cancleUpdateUser">取 消</el-button>
		  </div>
        </el-dialog>
	</div>
</template>
<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
	  data() {
		return {
			// module show
			tableData: [],
			originTableData: [],
            search: '',
            titles: [{
                label: "序号",
                prop: "id",
            }, {
                label: "姓名",
                prop: "name",
            }, {
                label: "昵称",
                prop: "nickname",
            }, {
                label: "邮箱",
                prop: "email",
            }, {
                label: "手机号",
                prop: "phone",
            }, {
                label: "创建时间",
                prop: "created_at",
            }],

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '200px',
                },

                buttons: [{
                    props: {
                        type: 'warning',
                        size: "mini",
                        icon: 'el-icon-edit'
                    },
                    handler: row => {
                        this.editRow(row)
                    },
                    label: '编辑'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-delete-solid'
                    },
                    handler: row => {
                        this.deleteRow(row)
                    },
                    label: '删除'
                }]
            },

			// module store
			dialogFormVisible: false,
			formLabelWidth: '120px',
			form: {
				name: '',
				nickname: '',
				email: '',
				phone: '',
				password: '',
                role_id: '',
			},
            roles: [],
            dialogUpdateFormVisible: false,
			updateForm: {
				id: '',
				name: '',
				nickname: '',
				email: '',
				phone: '',
                role_id: '',
			},
	    }
	  },

      computed: {
      },

      created () {
        this.fetchUsers()
        this.fetchRoles()
      },

      methods: {

        searchData () {
            var search = this.search;
            if (search) {
				this.tableData = this.tableData.filter((row) => {
					for (var key in row) {
						if (String(row[key]).indexOf(this.search) !== -1) {
							return true;
						}
					}
					return false;
				});
            } else {
				this.tableData = this.originTableData
			}
        },

        //编辑行
        editRow (row) {
            this.dialogUpdateFormVisible = true
            this.showUser(row.id)
        },

        //获取用户信息
        showUser (user_id) {
            http({
                url: Api.showUser + user_id,
            }).then(response => {
                this.updateForm = response.data.data
                let roleArr = [];
                for (let i = 0; i < this.updateForm.roles.length; i++) {
                    roleArr.push(this.updateForm.roles[i].id)
                }
                this.updateForm.role_id = roleArr
            })
        },

		//取消添加用户
		cancleUpdateUser () {
			this.dialogUpdateFormVisible = false;
		},

        //确认更新用户
        updateUser (updateForm) {
            this.$refs[updateForm].validate((valid) => {
              if (valid) {
                http({
                    method: 'put',
                    url: Api.updateUser + this.updateForm.id,
                    data: this.updateForm
                }).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
                    this.$refs[updateForm].resetFields()
                    this.dialogUpdateFormVisible = false
                    this.fetchUsers()
                }).catch(err => {
                    console.log(err)
                })

              } else {
                return false;
              }
            })
        },

        //删除某行
        deleteRow (row) {

			this.$confirm('此操作将永久删除该用户, 是否继续?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {

				http({
					method: 'delete',
					url: Api.destroyUser + row.id,
				}).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
            	    this.fetchUsers()
				})

			}).catch(() => {
				this.$notify({
					type: 'info',
					message: '已取消删除'
				});
			})
        },

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
			this.dialogFormVisible = false;
		},

        //确认添加用户
        addUser (form) {
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
            	    this.fetchUsers()
                    this.$refs[form].resetFields();
                }).catch(err => {
                    console.log(err)
                })

			    this.dialogFormVisible = false;
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

        changeRole () {
            this.$forceUpdate()
        }
      }
    }
</script>

<style>
#tableTools {
    display: inline-flex;
}
#tableTools .table-button {
    margin: 0 0 15px 10px;
}
</style>
