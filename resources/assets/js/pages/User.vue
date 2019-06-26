<template>
	<div>
        <div id="tableTools">
            <el-input class="table-search" v-model="search" placeholder="输入关键字查询" v-on:input="searchData"></el-input>
            <el-button type="primary" class="table-button" icon="el-icon-plus" v-on:click="addUser">添加用户</el-button>
        </div>
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>
        </data-tables>
	</div>
</template>
<script>
  import { http } from './../utils/fetch'
  import Api from './../config'

  export default {
	  data() {
		return {
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
                    label: ''
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-delete-solid'
                    },
                    handler: row => {
                        this.deleteRow(row)
                    },
                    label: ''
                }]
            }
	    }
	  },

      computed: {
          tables: function() {
          }
      },

      created () {
        this.fetchUsers()
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
            console.log("method edit")
            this.$message('Edit clicked')
            row.id = 'hello word' + Math.random()
            row.name = Math.random() > 0.5 ? 'Water flood' : 'Lock broken'
            row.nickname = Math.random() > 0.5 ? 'Repair' : 'Help'
        },

        //删除某行
        deleteRow (row) {
            http({
                method: 'delete',
                url: Api.destroyUser + row.id,
            }).then(response => {
				this.$notify.success({
					'title': "提示",
					'message': response.data.msg
            	})
            })

            this.fetchUsers()
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

        //添加用户
        addUser () {
            console.log('addUser')
        },
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
