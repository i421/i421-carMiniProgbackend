<template>
    <div>
        <el-row id="pageTitle">
            <span class="infoGroup">基本信息</span>
        </el-row>

        <el-row id="userDetail">
            <el-col :span="6">
                <span>昵称: {{ brokerInfo.nickname }}</span>
                <el-divider></el-divider>
                <span>微信openid: {{ brokerInfo.openid }}</span>
                <el-divider></el-divider>
                <span>手机号:  {{ brokerInfo.phone }}</span>
                <el-divider></el-divider>
                <span v-if="brokerInfo.gender == 1">
                    性别: <i class="el-icon-male"></i> 男
                </span>
                <span v-else>
                    性别: <el-button type="warning" icon="el-icon-female" circle></el-button> 女 
                </span>
            </el-col>
            <el-col :span="6">
                <span>国别: {{ brokerInfo.country }}</span>
                <el-divider></el-divider>
                <span>省份: {{ brokerInfo.province }}</span>
                <el-divider></el-divider>
                <span>城市: {{ brokerInfo.city }}</span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <el-row id="userActionTitle">
            <span class="infoGroup">用户行为信息</span>
        </el-row>

        <el-row id="userAction">
            <el-col :span="12">
                <span>积分: {{ appendData.scoreCount }}</span>
                <el-divider></el-divider>
            </el-col>
            <el-col :span="12">
                <span>回收积分: {{ appendData.recyclingScoreCount }}</span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <div v-if="brokerInfo.type_auth == 1">

            <el-row class="userAuthTitle">
                <span class="infoGroup">用户认证信息</span>
            </el-row>

            <el-row class="userAuth">
                <el-col :span="6">
                    <div v-if="brokerInfo.info">
                        <span>姓名: {{ brokerInfo.info.name }}</span>
                    </div>
                    <el-divider></el-divider>
                    <div v-if="brokerInfo.info">
                        <span>身份证号: {{ brokerInfo.info.id_card }}</span>
                    </div>
                    <el-divider></el-divider>
                </el-col>
            </el-row>

            <el-row class="userAuthTitle">
                <span class="block">身份证</span>
            </el-row>

            <el-row :gutter="20">
                <el-col :span="12">
                    <div class="grid-content" v-if="brokerInfo.broker_info">
                        <el-image fit="contain" :src="brokerInfo.broker_info.id_card_front_path" :preview-src-list="[brokerInfo.broker_info.id_card_front_path]"></el-image>
                    </div>
                </el-col>
                <el-col :span="12">
                    <div class="grid-content" v-if="brokerInfo.broker_info">
                        <el-image fit="contain" :src="brokerInfo.broker_info.id_card_back_path" :preview-src-list="[brokerInfo.broker_info.id_card_back_path]"></el-image>
                    </div>
                </el-col>
            </el-row>

            <el-row class="userAuthTitle">
                <span class="block">银行卡</span>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="12">
                    <div class="grid-content" v-if="brokerInfo.broker_info">
                        <el-image fit="contain" :src="brokerInfo.broker_info.bank_card" :preview-src-list="[brokerInfo.broker_info.bank_card]"></el-image>
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
            brokerInfo: {},
            appendData: {}
        }
      },

      created () {
          this.fetchCustomer()
      },

      methods: {

          fetchCustomer() {
            http({
                url: Api.showBroker + this.$route.params.id,
            }).then(response => {
                this.brokerInfo = response.data.data
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
