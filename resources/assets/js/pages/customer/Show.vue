<template>
    <div>
        <el-row>
            <span class="infoGroup">基本信息</span>
        </el-row>

        <el-row>
                <span>微信openid</span>
                <el-input v-model=customerInfo.openid></el-input>
                <span>手机号</span>
                <el-input v-model=customerInfo.phone></el-input>
        </el-row>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
	  data() {
		return {
            customerInfo: {}
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
</style>
