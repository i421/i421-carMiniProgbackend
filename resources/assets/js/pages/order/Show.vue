<template>
    <div>
        <el-row id="pageTitle">
            <span class="infoGroup">订单信息</span>
        </el-row>

        <el-row id="orderDetail">
            <el-col :span="12" style="padding-top: 10px">
                <span>订单号: {{ form.order_num }}</span>
                <el-divider></el-divider>
                <span v-if="form.type == 2">
                    <div v-if="form.group_type == 1">
                        时间拼团: {{ form.start_time }} —— {{ form.end_time}}
                    </div>
                    <div v-else>
                        数量拼团: 总数: {{ form.total_num }}
                    </div>
                </span>
                <span v-else>
                    现车
                </span>
                <el-divider></el-divider>
                <span>经销商: {{ form.shop_name }}</span>
                <el-divider></el-divider>
            </el-col>

            <el-col :span="12">
                <span v-if="form.status == 1">订单状态: 
                    <el-tag type="success">客户已到店</el-tag>
                </span>
                <span v-else>订单状态: 
                    <el-tag type="primary">客户未到店</el-tag>
                </span>
                <el-divider></el-divider>
                <span v-if="form.type == 1">
                    现车
                </span>
                <span v-else>
                    拼团
                </span>
                <el-divider></el-divider>
                <span>支付额: {{ form.payment_count }}</span>
                <el-divider></el-divider>
            </el-col>
        </el-row>

        <el-row id="userInfo">
            <el-col :span="12">
                <span>用户名: {{ form.customer_name }}</span>
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
                <span>落地价: {{ form.final_price }}</span>
                <el-divider></el-divider>
                <span>拼团价: {{ form.group_price }}</span>
                <el-divider></el-divider>
            </el-col>

            <el-col :span="12">
                <span>商品标题: {{ form.car_name }}</span>
                <el-divider></el-divider>
                <span>裸车价: {{ form.car_price}}</span>
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
              url: Api.showOrder + this.$route.params.id,
          }).then(response => {
              this.form = response.data.data
          })
        },

        back() {
            this.$router.push({ name: 'order'})
        },
      }
  }
</script>

<style>
#pageTitle {
    margin-bottom: 10px;
}
#orderDetail {
    margin-top: 30px;
}
#userInfo {
    margin-top: 50px;
}
#carInfo {
    margin-top: 50px;
}
</style>
