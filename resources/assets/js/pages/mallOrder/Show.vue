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
            <span class="infoGroup">用户信息</span>
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

        <el-row id="userInfo" style="margin-bottom: 30px;">
            <span class="infoGroup">商品信息</span>
        </el-row>

        <el-row id="carInfo">

            <div v-for="(item, i) in form.mall_accessories">
                <el-col :span="12">
                    <span>商品标题: {{ item.name }}</span>
                    <el-divider></el-divider>
                    <span>原价: {{ item.price }}</span>
                    <el-divider></el-divider>
                </el-col>

                <el-col :span="12">
                    <span>购买数量: {{ item.buy_count}}</span>
                    <el-divider></el-divider>
                    <span>积分价: {{ item.score_price}}</span>
                    <el-divider></el-divider>
                </el-col>
            </div>
        </el-row>

        <el-row id="userInfo">
            <span class="infoGroup">收货信息</span>
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
