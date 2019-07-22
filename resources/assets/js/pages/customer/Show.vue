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
            <el-col :span="6">
                <span>国别: {{ customerInfo.country }}</span>
                <el-divider></el-divider>
                <span>省份: {{ customerInfo.province }}</span>
                <el-divider></el-divider>
                <span>城市: {{ customerInfo.city }}</span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <el-row id="userActionTitle">
            <span class="infoGroup">用户行为信息</span>
        </el-row>

        <el-row id="userAction">
            <el-col :span="6">
                <span>积分: {{ appendData.scoreCount }}</span>
                <el-divider></el-divider>
                <span>订单数: {{ appendData.orderCount }}</span>
                <el-divider></el-divider>
                <span>收藏数: {{ appendData.collectionCount }}</span>
                <el-divider></el-divider>
            </el-col>
            <el-col :span="6">
                <span>推荐人数: {{ customerInfo.recommend_count }}</span>
                <el-divider></el-divider>
                <span>推荐人: {{ appendData.recommender }}</span>
                <el-divider></el-divider>
                <span>收藏数: {{ appendData.collectionCount }}</span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <div v-if="customerInfo.auth == 1">

            <el-row class="userAuthTitle">
                <span class="infoGroup">用户认证信息</span>
            </el-row>

            <el-row class="userAuth">
                <el-col :span="6">
                    <span>姓名: {{ customerInfo.info.name }}</span>
                    <el-divider></el-divider>
                    <span>身份证号: {{ customerInfo.info.id_card }}</span>
                    <el-divider></el-divider>
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

        </div>
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
                url: Api.showCustomer + this.$route.params.id,
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
#userAction {
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
#userActionTitle {
    margin-top: 30px;
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
</style>
