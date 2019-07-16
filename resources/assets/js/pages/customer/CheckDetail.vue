<template>
    <div>
        <el-row id="pageTitle">
            <span class="infoGroup">基本信息</span>
        </el-row>

        <el-row id="userDetail">
            <el-col :span="3">
             <el-avatar shape="square" :size="100" fit="fill" :src="customerInfo.avatar"></el-avatar>
            </el-col>
            <el-col :span="6">
                <span>昵称: {{ customerInfo.nickname }}</span>
                <el-divider></el-divider>
                <span>微信openid: {{ customerInfo.openid }}</span>
                <el-divider></el-divider>
                <span>手机号:  {{ customerInfo.phone }}</span>
                <el-divider></el-divider>
                <span v-if="customerInfo.gender == 1">
                    性别: <i class="el-icon-male"></i> 男
                </span>
                <span v-else>
                    性别: <el-button type="warning" icon="el-icon-female" circle></el-button> 女 
                </span>
            </el-col>
        </el-row>

        <el-row id="userAuthTitle">
            <span class="infoGroup">用户认证信息</span>
        </el-row>

        <el-row id="userAuth">
            <el-col :span="6">
            </el-col>
        </el-row>

    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
	  data() {
		return {
            customerInfo: {},
            appendData: {}
        }
      },

      created () {
          this.fetchCustomer()
      },

      methods: {

          fetchCustomer() {
            http({
                url: Api.customerCheckDetail + this.$route.params.id,
            }).then(response => {
                this.customerInfo = response.data.data
                this.appendData = response.data.append
            })
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
#tableTools .table-search {
    margin: 0 10px 15px 0px;
}
.infoGroup {
    font-size: 20px;
}
#pageTitle {
    margin-bottom: 10px;
}
#userDetail {
    border: 1px solid #ccc;
    padding-top: 10px;
    padding-bottom: 30px;
    padding-left: 20px;
    padding-right: 20px;
    width: 100%;
    height: auto;
    font-size: 16px;
}
#userAuth {
    margin-top: 10px;
    border: 1px solid #ccc;
    padding-top: 30px;
    padding-bottom: 30px;
    padding-left: 20px;
    padding-right: 20px;
    width: 100%;
    height: auto;
    font-size: 16px;
}
#userAuthTitle {
    margin-top: 30px;
}
</style>
