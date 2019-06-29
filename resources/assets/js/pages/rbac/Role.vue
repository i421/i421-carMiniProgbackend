<template>
	<div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-input class="table-search" v-model="search" placeholder="输入关键字查询" @input="searchData"></el-input>
            <el-button type="primary" class="table-button" icon="el-icon-plus" @click="dialogFormVisible = true">添加角色</el-button>
        </div>
		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>
        </data-tables>

		<!--添加角色表单-->
		<el-dialog title="添加角色" :visible.sync="dialogFormVisible">
		  <el-form :model="form" ref="form" :inline="true">
			<el-form-item label="名称" :label-width="formLabelWidth" prop="name"
				:rules="[
					{required: true, message: '名称不能为空'}
				]"
            >
			  <el-input v-model="form.name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="中文名称" :label-width="formLabelWidth" prop="display_zh_name"
				:rules="[
					{required: true, message: '中文名称不能为空'}
				]"
            >
			  <el-input v-model="form.display_zh_name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="英文名称" :label-width="formLabelWidth" prop="display_en_name"
				:rules="[
					{required: true, message: '英文名称不能为空'}
				]"
			>
			  <el-input v-model.number="form.display_en_name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="描述" :label-width="formLabelWidth">
			  <el-input v-model="form.description" autocomplete="off"></el-input>
			</el-form-item>

		  </el-form>
		  <div slot="footer" class="dialog-footer">
			<el-button @click="cancleAddRole">取 消</el-button>
			<el-button type="primary" @click="addRole('form')">确 定</el-button>
		  </div>
		</el-dialog>

		<!--更新角色表单-->
		<el-dialog title="更新角色" :visible.sync="dialogUpdateFormVisible">
		  <el-form :model="updateForm" ref="updateForm" :inline="true">
			<el-form-item label="名称" :label-width="formLabelWidth" prop="name"
				:rules="[
					{ required: true, message: '名称不能为空', trigger: 'blur' }
				]"
            >
			  <el-input v-model="updateForm.name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="中文名称" :label-width="formLabelWidth" prop="display_zh_name"
				:rules="[
					{ required: true, message: '中文名称不能为空', trigger: 'blur' }
				]"
            >
			  <el-input v-model="updateForm.display_zh_name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="英文名称" :label-width="formLabelWidth" prop="display_en_name"
				:rules="[
					{ required: true, message: '英文名称不能为空', trigger: 'blur' },
				]"
			>
			  <el-input v-model="updateForm.display_en_name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="描述" :label-width="formLabelWidth" prop="description" >
			  <el-input v-model.number="updateForm.description" autocomplete="off"></el-input>
			</el-form-item>

		  </el-form>
		  <div slot="footer" id="edit-form-footer">
			<el-button type="primary" @click="updateRole('updateForm')">确 定</el-button>
			<el-button @click="cancleUpdateRole">取 消</el-button>
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
                label: "名称",
                prop: "name",
            }, {
                label: "中文名称",
                prop: "display_zh_name",
            }, {
                label: "英文名称",
                prop: "display_en_name",
            }, {
                label: "描述",
                prop: "description",
            }, {
                label: "创建时间",
                prop: "created_at",
            }],

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '300px',
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
                }, {
                    props: {
                        type: 'primary',
                        size: "mini",
                        icon: 'el-icon-menu'
                    },
                    handler: row => {
                        this.configRow(row)
                    },
                    label: '权限'
                }]
            },

			// module store
			dialogFormVisible: false,
			formLabelWidth: '120px',
			form: {
				name: '',
				display_zh_name: '',
				display_en_name: '',
				description: '',
				status: 1,
			},
            dialogUpdateFormVisible: false,
			updateForm: {
				id: '',
				name: '',
				display_zh_name: '',
				display_en_name: '',
				description: '',
				status: 1,
			},
	    }
	  },

      computed: {
      },

      created () {
        this.fetchRoles()
      },

      methods: {

        //获取角色列表
        fetchRoles () {
            http({
                url: Api.roles,
            }).then(response => {
                this.tableData = response.data.data
                this.originTableData = response.data.data
            })
        },

        //获取某一角色信息
        showRole (role_id) {
            http({
                url: Api.showRole + role_id,
            }).then(response => {
                this.updateForm = response.data.data
            })
        },

        //表格搜索支持
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
            this.showRole(row.id)
        },

		//取消添加角色
		cancleUpdateRole () {
			this.dialogUpdateFormVisible = false;
		},

        //确认更新角色
        updateRole (updateForm) {
            this.$refs[updateForm].validate((valid) => {
              if (valid) {
                http({
                    method: 'put',
                    url: Api.updateRole + this.updateForm.id,
                    data: this.updateForm
                }).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
                    this.$refs[updateForm].resetFields()
                    this.dialogUpdateFormVisible = false
                    this.fetchRoles()
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

			this.$confirm('此操作将永久删除该角色, 是否继续?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {

				http({
					method: 'delete',
					url: Api.destroyRole + row.id,
				}).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
            	    this.fetchRoles()
				})

			}).catch(() => {
				this.$notify({
					type: 'info',
					message: '已取消删除'
				});
			})
        },

        //确认添加角色
        addRole (form) {
            this.$refs[form].validate((valid) => {
              if (valid) {
                http({
                    method: 'post',
                    url: Api.storeRole,
                    data: this.form
                }).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
            	    this.fetchRoles()
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

		//取消添加角色
		cancleAddRole () {
			this.dialogFormVisible = false;
		},

        //跳转配置权限
        configRow (row) {
            this.$router.push({ name: 'rolePermission', params: {role_id: row.id} })
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
