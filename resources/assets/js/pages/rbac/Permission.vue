<template>
  <el-transfer
		class="permissionTransfer"
		v-model="rolePermission"
		:data="permission"
		:titles="['系统权限', '用户权限']"
		:button-texts="['移除', '添加']"
		@change="handleChange"
  >
  </el-transfer>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
    data() {
        return {
            rolePermission: [], 
            permission: [],
        }
    },

    created () {
        this.fetchPermission()
    },

    methods: {

        //获取权限列表
        fetchPermission () {
            http({
                url: Api.rolePermission + this.$route.params.role_id,
            }).then(response => {
                this.permission = this.generatePermissions(response.data.data.permission)
                this.rolePermission = this.generateRolePermissions(response.data.data.rolePermission)
            })
        },

		//生成全部菜单选项
		generatePermissions(permissions) {
			let data = [];
			for (let i = 0; i < permissions.length; i++) {
				data.push({
					key: permissions[i]['id'],
					label: permissions[i]['display_zh_name']
				})
			}
			return data;
		},

		//生成角色菜单选项
		generateRolePermissions(permissions) {
			let data = [];
			for (let i = 0; i < permissions.length; i++) {
				data.push(permissions[i]['id'])
			}
			return data;
		},

		//更新权限
		handleChange (value, direction, keys) {

			const params = {
				direction: direction,
				keys: keys
			}

            http({
                method: 'put',
                url: Api.updateRolePermission + this.$route.params.role_id,
                data: params
            }).then(response => {
				this.$notify.success({
					title: '提示',
					message: response.data.msg,
				});
			});
		}
    }
  }
</script>

<style>
.el-transfer-panel__body, .el-transfer-panel__list {
	height: 380px;
}
.el-transfer-panel__body .el-transfer-panel__list > .el-checkbox, .el-transfer-panel__body .el-transfer-panel__list > .el-checkbox__input {
	display: block;
}
.el-transfer-panel .el-transfer-panel__header .el-checkbox {
	padding-top: 10px;
}
</style>
