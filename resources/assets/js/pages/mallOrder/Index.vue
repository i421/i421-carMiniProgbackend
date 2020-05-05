<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="padding-right: 5px">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionName" placeholder="用户名"></el-input>
                    </div>
                </el-col>

                <el-col :span="6" style="padding-right: 5px">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionPhone" placeholder="手机号"></el-input>
                    </div>
                </el-col>
                <el-col :span="6" style="padding-right: 5px">
                    <el-input class="table-search" v-model.number="conditionOrderNo" placeholder="订单号"></el-input>
                </el-col>

                <el-col :span="6">
                    <div>
                        <el-date-picker
                            v-model="conditionTime"
                            type="daterange"
                            class="table-search"
                            align="right"
                            value-format="yyyy-MM-dd"
                            unlink-panels
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期" >
                        </el-date-picker>
                    </div>
                </el-col>

            </el-row>


            <div class="searchControl">
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
            </div>
        </div>

        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="全部" name="first">
                <!-- table数据 -->
                <data-tables border :data="allTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="配件主图" prop="img_url" width="180">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" lazy :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="mall_accessory_name">
                    </el-table-column>

                    <el-table-column label="积分价" prop="score_price">
                    </el-table-column>

                    <el-table-column label="原价" prop="price">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">全部</el-tag>
                            <el-tag v-else type="warning">下架</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="待付款" name="second">
                <!-- table数据 -->
                <data-tables border :data="toBePayTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="配件主图" prop="img_url" width="180">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" lazy :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="mall_accessory_name">
                    </el-table-column>

                    <el-table-column label="积分价" prop="score_price">
                    </el-table-column>

                    <el-table-column label="原价" prop="price">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">全部</el-tag>
                            <el-tag v-else type="warning">下架</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="待发货" name="third">
                <!-- table数据 -->
                <data-tables border :data="toBeDeliveredTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="配件主图" prop="img_url" width="180">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" lazy :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="mall_accessory_name">
                    </el-table-column>

                    <el-table-column label="积分价" prop="score_price">
                    </el-table-column>

                    <el-table-column label="原价" prop="price">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">全部</el-tag>
                            <el-tag v-else type="warning">下架</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="已发货" name="fourth">
                <!-- table数据 -->
                <data-tables border :data="deliveredTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="配件主图" prop="img_url" width="180">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" lazy :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="mall_accessory_name">
                    </el-table-column>

                    <el-table-column label="积分价" prop="score_price">
                    </el-table-column>

                    <el-table-column label="原价" prop="price">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">全部</el-tag>
                            <el-tag v-else type="warning">下架</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="已完成" name="fifth">
                <!-- table数据 -->
                <data-tables border :data="doneTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="配件主图" prop="img_url" width="180">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" lazy :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="mall_accessory_name">
                    </el-table-column>

                    <el-table-column label="积分价" prop="score_price">
                    </el-table-column>

                    <el-table-column label="原价" prop="price">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">全部</el-tag>
                            <el-tag v-else type="warning">下架</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data () {
          return {
            activeName: 'first',
            conditionName: '',
            conditionPhone: '',
            conditionOrderNo: '',
            conditionTime: [],
			allTableData: [],
            toBePayTableData: [],
            toByDeliveredTableData: [],
            deliveredTableData: [],
            doneTableData: [],

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '400px',
                },

                buttons: [{
                    props: {
                        type: 'warning',
                        size: "mini",
                    },
                    handler: row => {
                        this.show(row)
                    },
                    label: '详情'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                    },
                    handler: row => {
                        //发货
                        this.ship(row)
                    },
                    label: '发货'
                }]
            },
          }
      },
      created () {
          this.search()
      },
      methods: {
          search() {
            http({
                url: Api.searchMallOrder,
                method: 'post',
                data: {
                    'name': this.conditionName,
                    'phone': this.conditionPhone,
                    'order_no': this.conditionOrderNo,
                    'time': this.conditionTime,
                }
            }).then(response => {
                this.allTableData = []
                this.toBePayTableData = []
                this.toByDeliveredTableData = []
                this.deliveredTableData = []
                this.doneTableData = []

                for (let i = 0; i < response.data.data.length; i++) {
                    if (response.data.data[i]['status'] == 1) {
                        this.toBePayTableData.push(response.data.data[i]);
                        this.allTableData.push(response.data.data[i]);
                    } else if (response.data.data[i]['status'] == 2) {
                        this.toByDeliveredTableData.push(response.data.data[i]);
                        this.allTableData.push(response.data.data[i]);
                    } else if (response.data.data[i]['status'] == 3) {
                        this.deliveredTableData.push(response.data.data[i]);
                        this.allTableData.push(response.data.data[i]);
                    } else if (response.data.data[i]['status'] == 4) {
                        this.doneTableData.push(response.data.data[i]);
                        this.allTableData.push(response.data.data[i]);
                    }
                }
            })
          },

          //清除查询条件
          clearSearch() {
            this.conditionName = ''
            this.conditionPhone = ''
            this.conditionOrderNo = ''
            this.conditionTime = []
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showMallOrder', params: {"id": row.id} })
          },

          //切换
          ship(row) {
            this.$confirm('此操作将发货, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {

                http({
                    method: 'post',
                    url: Api.toggleMallOrderStatus + row.id,
                    data: {
                        'status': row.status,
                    }
                }).then(response => {
                    this.$notify.success({
                        'title': "提示",
                        'message': response.data.msg
                    })
                    this.fetchMallAccessories()
                })

            }).catch(() => {
                this.$notify({
                    type: 'info',
                    message: '已取消切换'
                });
            })
          },
          //处理切换
          handleClick(tab, event) {
            //console.log(tab, event);
          }
      }
  }
</script>

<style>
#tableTools {
    display: inline-block;
}
#tableTools .table-button {
    margin: 0 0 30px 0px;
}
#tableTools .table-search {
    margin: 0 10px 15px 0px;
}
</style>
