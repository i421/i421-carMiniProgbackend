<template>
    <div>
        <el-row id="pageTitle">
            <span class="infoGroup">基本信息</span>
        </el-row>

        <el-row id="userDetail">
            <!--
            <el-col :span="3">
             <el-avatar shape="square" :size="100" fit="fill" :src="customerInfo.avatar"></el-avatar>
            </el-col>
            -->
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

        <el-row class="userAuthTitle">
            <span class="infoGroup">用户认证信息</span>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="12">
                <div class="auth-grid-content">
                    <span>姓名: {{ customerInfo.info.name }}</span>
                </div>
            </el-col>
            <el-col :span="12">
                <div class="auth-grid-content">
                    <span>身份证号: {{ customerInfo.info.id_card }}</span>
                </div>
            </el-col>
        </el-row>

        <el-row class="userAuthTitle">
            <span class="block">身份证</span>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content">
                    <el-image fit="contain" :src="customerInfo.info.id_card_front_path"></el-image>
                </div>
            </el-col>
            <el-col :span="12">
                <div class="grid-content">
                    <el-image fit="contain" :src="customerInfo.info.id_card_back_path"></el-image>
                </div>
            </el-col>
        </el-row>

        <el-row class="userAuthTitle">
            <span class="block">驾驶证</span>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content">
                    <el-image fit="contain" :src="customerInfo.info.driver_license"></el-image>
                </div>
            </el-col>
        </el-row>

        <el-row class="userAuthTitle">
            <span class="block">银行卡</span>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content">
                    <el-image fit="contain" :src="customerInfo.info.bank_card"></el-image>
                </div>
            </el-col>
        </el-row>

        <el-row id="authTools">
            <el-button type="primary" @click="submitCheck(1)">审核通过</el-button>
            <el-button type="primary" @click="submitCheck(0)">拒绝</el-button>
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
          },

          submitCheck(auth) {
              console.log(auth);
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
.userAuth {
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
.userAuthTitle {
    margin-top: 30px;
}
.auth-grid-content {
    width: auto;
    height: 50px;
    margin-top: 10px;
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 16px;
}
.grid-content {
    width: auto;
    height: 200px;
    margin-top: 10px;
    border: 1px solid #ccc;
    padding-top: 30px;
    padding-bottom: 30px;
    padding-left: 20px;
    padding-right: 20px;
    font-size: 16px;
}
#authTools {
    margin: 50px 0px 0px 0px;
}
</style>
