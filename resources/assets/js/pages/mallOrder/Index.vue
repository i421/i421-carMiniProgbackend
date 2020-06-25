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
                <data-tables border :data="allTableData" :action-col="showActionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

                    <el-table-column label="订单编号" prop="uuid">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="收货地址" prop="mall_address_detail">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="快递单号" prop="express_number">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">待付款</el-tag>
                            <el-tag v-else-if="scope.row.status == 2" type="warning">待发货</el-tag>
                            <el-tag v-else-if="scope.row.status == 3" type="info">已发货</el-tag>
                            <el-tag v-else type="success">已完成</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="待付款" name="second">
                <!-- table数据 -->
                <data-tables border :data="toBePayTableData" :action-col="showActionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

                    <el-table-column label="订单编号" prop="uuid">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="收货地址" prop="mall_address_detail">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="快递单号" prop="express_number">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">待付款</el-tag>
                            <el-tag v-else-if="scope.row.status == 2" type="warning">待发货</el-tag>
                            <el-tag v-else-if="scope.row.status == 3" type="info">已发货</el-tag>
                            <el-tag v-else type="success">已完成</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="待发货" name="third">
                <!-- table数据 -->
                <data-tables border :data="toBeDeliveredTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="订单编号" prop="uuid">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="收货地址" prop="mall_address_detail">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="快递单号" prop="express_number">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">待付款</el-tag>
                            <el-tag v-else-if="scope.row.status == 2" type="warning">待发货</el-tag>
                            <el-tag v-else-if="scope.row.status == 3" type="info">已发货</el-tag>
                            <el-tag v-else type="success">已完成</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="已发货" name="fourth">
                <!-- table数据 -->
                <data-tables border :data="deliveredTableData" :action-col="alreadyActionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="订单编号" prop="uuid">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="收货地址" prop="mall_address_detail">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="快递单号" prop="express_number">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">待付款</el-tag>
                            <el-tag v-else-if="scope.row.status == 2" type="warning">待发货</el-tag>
                            <el-tag v-else-if="scope.row.status == 3" type="info">已发货</el-tag>
                            <el-tag v-else type="success">已完成</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="已完成" name="fifth">
                <!-- table数据 -->
                <data-tables border :data="doneTableData" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="订单编号" prop="uuid">
                    </el-table-column>

                    <el-table-column label="收货姓名" prop="mall_address_name">
                    </el-table-column>

                    <el-table-column label="收货手机号" prop="mall_address_phone">
                    </el-table-column>

                    <el-table-column label="收货地址" prop="mall_address_detail">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="pay_price">
                    </el-table-column>

                    <el-table-column label="快递单号" prop="express_number">
                    </el-table-column>

                    <el-table-column label="状态" prop="status">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="danger">待付款</el-tag>
                            <el-tag v-else-if="scope.row.status == 2" type="warning">待发货</el-tag>
                            <el-tag v-else-if="scope.row.status == 3" type="info">已发货</el-tag>
                            <el-tag v-else type="success">已完成</el-tag>
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
            toBeDeliveredTableData: [],
            deliveredTableData: [],
            doneTableData: [],

            showActionCol: {
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
                }]
            },

            alreadyActionCol: {
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
                        this.updateExpress(row)
                    },
                    label: '更新快递单号'
                }]
            },

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
                this.toBeDeliveredTableData = []
                this.deliveredTableData = []
                this.doneTableData = []

                for (let i = 0; i < response.data.data.length; i++) {
                    if (response.data.data[i]['status'] == 1) {
                        this.toBePayTableData.push(response.data.data[i]);
                        this.allTableData.push(response.data.data[i]);
                    } else if (response.data.data[i]['status'] == 2) {
                        this.toBeDeliveredTableData.push(response.data.data[i]);
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

          //更新快递单号
          updateExpress(row) {

            this.$prompt('请输入快递号', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
            }).then(({ value }) => {

                if (value.trim().length <= 1) {
                    this.$message({
                        type: 'error',
                        message: "快递单号不能为空"
                    });
                }

                http({
                    method: 'post',
                    url: Api.updateMallOrderExpress,
                    data: {
                        'express_num': value.trim(),
                        'id': row.id
                    }
                }).then(response => {
                    if (response.data.code != '200') {
                        this.$notify.error({
                            'title': "提示",
                            'message': response.data.msg
                        })
                    } else {
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })
                        this.search()
                    }
                })

            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '取消更新'
                });       
            });
          },

          //切换
          ship(row) {

            this.$prompt('请输入快递号', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
            }).then(({ value }) => {

                if (value.trim().length <= 1) {
                    this.$message({
                        type: 'error',
                        message: "快递单号不能为空"
                    });
                }

                http({
                    method: 'post',
                    url: Api.toggleMallOrderStatus + row.id,
                    data: {
                        'status': 3,
                        'express_num': value.trim(),
                    }
                }).then(response => {
                    if (response.data.code != '200') {
                        this.$notify.error({
                            'title': "提示",
                            'message': response.data.msg
                        })
                    } else {
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })
                        this.search()
                    }
                })

            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '取消输入'
                });       
            });
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
