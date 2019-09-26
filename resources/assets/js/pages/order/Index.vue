<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" class="orderToolCol">
                    <el-input class="table-search" v-model="conditionPhone" placeholder="手机号"></el-input>
                </el-col>
                <el-col :span="6" class="orderToolCol">
                    <el-input class="table-search" v-model="conditionCustomerName" placeholder="姓名"></el-input>
                </el-col>
                <el-col :span="6" class="orderToolCol">
                    <el-input class="table-search" v-model="conditionCarName" placeholder="车名"></el-input>
                </el-col>
                <el-col :span="6" class="orderToolCol">
                    <el-input class="table-search" v-model="conditionOrderNo" placeholder="订单号"></el-input>
                </el-col>

                <el-col :span="6">
                    <el-select v-model="conditionStatus" placeholder="状态" multiple="multiple" class="table-search">
                        <el-option label="客户已到店" value="1"></el-option>
                        <el-option label="客户未到店" value="0"></el-option>
                    </el-select>
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

            <div>
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
            </div>
        </div>

        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="全部" name="first">
                <!-- table数据 -->
                <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="序号" prop="id" width="80">
                    </el-table-column>

                    <el-table-column label="商品图" prop="avatar" width="120">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="car_name" width="150">
                    </el-table-column>

                    <el-table-column label="车价" prop="final_price" width="100">
                    </el-table-column>

                    <el-table-column label="姓名" prop="customer_name" width="120">
                    </el-table-column>

                    <el-table-column label="手机号" prop="phone" width="180">
                    </el-table-column>

                    <el-table-column label="类型" prop="type">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.type == 1" type="success">现车</el-tag>
                            <el-tag v-else type="primary">拼团</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column label="经销商" prop="shop_name" width="180">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="payment_count">
                        <template slot-scope="scope">
                            <el-tag type="primary">{{ scope.row.payment_count }} 元</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column label="状态" prop="status" width="130">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="success">客户已到店</el-tag>
                            <el-tag v-else type="error">客户未到店</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="现车" name="second">
                <!-- table数据 -->
                <data-tables border :data="carTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="序号" prop="id" width="80">
                    </el-table-column>

                    <el-table-column label="商品图" prop="avatar" width="120">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="car_name" width="150">
                    </el-table-column>

                    <el-table-column label="车价" prop="final_price" width="100">
                    </el-table-column>

                    <el-table-column label="姓名" prop="customer_name" width="120">
                    </el-table-column>

                    <el-table-column label="手机号" prop="phone" width="180">
                    </el-table-column>

                    <el-table-column label="类型" prop="type">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.type == 1" type="success">现车</el-tag>
                            <el-tag v-else type="primary">拼团</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column label="经销商" prop="shop_name" width="180">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="payment_count">
                        <template slot-scope="scope">
                            <el-tag type="primary">{{ scope.row.payment_count }} 元</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column label="状态" prop="status" width="130">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="success">客户已到店</el-tag>
                            <el-tag v-else type="error">客户未到店</el-tag>
                        </template>
                    </el-table-column>
                </data-tables>
            </el-tab-pane>

            <el-tab-pane label="拼团" name="third">
                <data-tables border :data="groupCarTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column label="序号" prop="id" width="80">
                    </el-table-column>

                    <el-table-column label="商品图" prop="avatar" width="120">
                        <template slot-scope="scope">
                            <el-image style="width: 60px; height: 60px" :src="scope.row.avatar"></el-image>
                        </template>
                    </el-table-column>

                    <el-table-column label="商品标题" prop="car_name" width="150">
                    </el-table-column>

                    <el-table-column label="车价" prop="final_price" width="100">
                    </el-table-column>

                    <el-table-column label="姓名" prop="customer_name" width="120">
                    </el-table-column>

                    <el-table-column label="手机号" prop="phone" width="180">
                    </el-table-column>

                    <el-table-column label="类型" prop="type">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.type == 1" type="success">现车</el-tag>
                            <el-tag v-else type="primary">拼团</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column label="经销商" prop="shop_name" width="180">
                    </el-table-column>

                    <el-table-column label="支付金额" prop="payment_count">
                        <template slot-scope="scope">
                            <el-tag type="primary">{{ scope.row.payment_count }} 元</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column label="状态" prop="status" width="130">
                        <template slot-scope="scope">
                            <el-tag v-if="scope.row.status == 1" type="success">客户已到店</el-tag>
                            <el-tag v-else type="error">客户未到店</el-tag>
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
	  data() {
		return {
            activeName: 'first',

            conditionTime: [],
            conditionPhone: '',
            conditionCustomerName: '',
            conditionCarName: '',
            conditionOrderNo: '',
            conditionStatus: [],

			tableData: [],
            carTableData: [],
            groupCarTableData: [],

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '300px',
                },

                buttons: [{
                    props: {
                        type: 'warning',
                        size: "mini",
                        icon: 'el-icon-edit'
                    },
                    handler: row => {
                        this.showOrder(row)
                    },
                    label: '详情'
                }, {
                    props: {
                        type: 'warning',
                        size: "mini",
                        icon: 'el-icon-s-custom'
                    },
                    handler: row => {
                        this.arrive(row)
                    },
                    label: '客户到店'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-delete'
                    },
                    handler: row => {
                        this.destroy(row)
                    },
                    label: '删除'
                }]
            },
        }
      },

      created () {
          this.fetchOrders()
      },

      methods: {

          fetchOrders() {
            http({
                url: Api.orders,
            }).then(response => {

                this.tableData = []
                this.carTableData = []
                this.groupCarTableData = []

                for (let i = 0; i < response.data.data.length; i++) {
                    if (response.data.data[i]['type'] == 1) {
                        this.tableData.push(response.data.data[i]);
                        this.carTableData.push(response.data.data[i]);
                    } else {
                        this.tableData.push(response.data.data[i]);
                        this.groupCarTableData.push(response.data.data[i]);
                    }
                }
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionTime = []
            this.conditionCarName = ''
            this.conditionPhone = ''
            this.conditionOrderNo = ''
            this.conditionCustomerName = ''
            this.conditionStatus = []
          },

          //查询
          search() {
            http({
                url: Api.searchOrder,
                params: {
                    'time': this.conditionTime,
                    'car_name': this.conditionCarName,
                    'phone': this.conditionPhone,
                    'order_no': this.conditionOrderNo,
                    'customer_name': this.conditionCustomerName,
                    'status': this.conditionStatus,
                }
            }).then(response => {

                this.tableData = []
                this.carTableData = []
                this.groupCarTableData = []

                for (let i = 0; i < response.data.data.length; i++) {
                    if (response.data.data[i]['type'] == 1) {
                        this.tableData.push(response.data.data[i]);
                        this.carTableData.push(response.data.data[i]);
                    } else {
                        this.tableData.push(response.data.data[i]);
                        this.groupCarTableData.push(response.data.data[i]);
                    }
                }
            })
          },

          //查看详情
          showOrder(row) {
              this.$router.push({ name: 'showOrder', params: {"id": row.id} })
          },

          //处理切换
          handleClick(tab, event) {
            //console.log(tab, event);
          },

          //客户到店
          arrive(row) {
            this.$confirm('确认执行吗？','提示',{}).then(() => {
                http({
                    url: Api.orderStatus + row.id,
                    method: 'post'
                }).then(response => {
                    this.$notify.success({
                        'title': "提示",
                        'message': response.data.msg
                    })
                    this.fetchOrders()
                })
            }).catch(() => {
            });
          },

          //删除
          destroy(row) {
            this.$confirm('此操作将永久删除订单, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {

                http({
                    method: 'delete',
                    url: Api.destroyOrder + row.id,
                }).then(response => {
                    this.$notify.success({
                        'title': "提示",
                        'message': response.data.msg
                    })
                    this.fetchOrders()
                })

            }).catch(() => {
                this.$notify({
                    type: 'info',
                    message: '已取消删除'
                });
            })
          }
      }
  }
</script>

<style scoped>
.orderToolCol {
    padding-right: 5px;
}
#tableTools {
    display: inline-block;
}
#tableTools .table-button {
    margin: 0 0 30px 0px;
}
#tableTools .table-search {
    margin: 0 10px 15px 0px;
}
.el-select {
    width: 100%;
}
</style>
