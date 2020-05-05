<template>
    <div>
        <el-row id="pageTitle">
            <span class="infoGroup">订单信息</span>
        </el-row>

        <el-row id="orderDetail">
            <el-col :span="12" style="padding-top: 10px">
                <span>订单号: {{ form.uuid }}</span>
                <el-divider></el-divider>

                <span v-if="form.type == 1">
                    支付额: {{ form.pay_price }} 元
                </span>
                <span v-else>
                    支付积分: {{ form.pay_price }} 积分
                </span>

                <el-divider></el-divider>
                <span>经销商: {{ form.shop_name }}</span>
                <el-divider></el-divider>
            </el-col>

            <el-col :span="12">
                <span v-if="form.status == 1">订单状态: 
                    <el-tag type="success">待支付</el-tag>
                </span>
                <span v-else-if="form.status == 2">订单状态: 
                    <el-tag type="primary">待发货</el-tag>
                </span>
                <span v-else-if="form.status == 3">订单状态: 
                    <el-tag type="primary">待收货</el-tag>
                </span>
                <span v-else-if="form.status == 4">订单状态: 
                    <el-tag type="primary">已完成</el-tag>
                </span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <el-row id="userInfo">
            <el-col :span="12">
                <span>用户名: {{ form.customer_nickname }}</span>
                <el-divider></el-divider>
                <span v-if="form.gender == 1">
                    性别: <i class="el-icon-male"></i> 男
                </span>
                <span v-else>
                    性别: <i class="el-icon-female"></i> 女 
                </span>
                <el-divider></el-divider>
            </el-col>

            <el-col :span="12">
                <span>手机号: {{ form.phone }}</span>
                <el-divider></el-divider>
                <span v-if="form.customer_agent == 1">用户类型: 合作商家</span>
                <span v-else>用户类型: 普通会员</span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <el-row>
            <el-col :span="12">
                <span>商品图:
                    <el-avatar shape="square" :size="100" fit="fill" :src="form.avatar"></el-avatar>
                </span>
            </el-col>
        </el-row>

        <el-row id="carInfo">
            <el-col :span="12">
                <span>商品标题: {{ form.mall_accessory_name }}</span>
                <el-divider></el-divider>
                <span>原价: {{ form.price }}</span>
                <el-divider></el-divider>
            </el-col>

            <el-col :span="12">
                <span>_ </span>
                <el-divider></el-divider>
                <span>积分价: {{ form.score_price}}</span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <el-row id="addressInfo">
            <el-col :span="12">
                <span>姓名: {{ form.mall_address_name }}</span>
                <el-divider></el-divider>
                <span>地址: {{ form.mall_address_detail }}</span>
                <el-divider></el-divider>
            </el-col>

            <el-col :span="12">
                <span>收货手机: {{ form.mall_address_phone }}</span>
                <el-divider></el-divider>
                <span>收货地址: {{ form.mall_address_city}} {{ form.mall_address_detail }}</span>
                <el-divider></el-divider>
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
              form: {}
          }
      },

      created () {
          this.fetchOrder();
      },

      methods: {

        fetchOrder() {
          http({
              url: Api.showMallOrder + this.$route.params.id,
          }).then(response => {
              this.form = response.data.data
          })
        },

        back() {
            this.$router.push({ name: 'mallorder'})
        },
      }
  }
</script>

<style>
#pageTitle {
    margin-bottom: 10px;
}
#orderDetail {
    margin-top: 20px;
}
#userInfo {
    margin-top: 50px;
}
#carInfo {
    margin-top: 50px;
}
#addressInfo {
    margin-top: 50px;
}
</style>
