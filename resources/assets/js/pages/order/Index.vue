<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" :offset="1">
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

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="序号" prop="id" width="80">
            </el-table-column>

            <el-table-column label="商品图" prop="avatar" width="180">
            </el-table-column>

            <el-table-column label="商品标题" prop="car_name" width="180">
            </el-table-column>

            <el-table-column label="车价" prop="final_price">
            </el-table-column>

            <el-table-column label="姓名" prop="customer_nickname">
            </el-table-column>

            <el-table-column label="手机号" prop="phone">
            </el-table-column>

            <el-table-column label="类型" prop="type">
            </el-table-column>

            <el-table-column label="经销商" prop="shop_name">
            </el-table-column>

            <el-table-column label="支付金额" prop="payment_count">
            </el-table-column>

            <el-table-column label="状态" prop="status">
            </el-table-column>

        </data-tables>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
	  data() {
		return {
            conditionTime: [],
			tableData: [],

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
                        icon: 'el-icon-edit'
                    },
                    handler: row => {
                        this.showOrder(row)
                    },
                    label: '编辑'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-delete-solid'
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
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionTime = ''
          },

          //查询
          search() {
            http({
                url: Api.searchOrder,
                params: {
                    'time': this.conditionTime,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //查看详情
          showOrder(row) {
              this.$router.push({ name: 'showOrder', params: {"id": row.id} })
          },

          //删除
          destroy(row) {

			this.$confirm('此操作将永久该消息, 是否继续?', '提示', {
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
            	    this.fetchMessages()
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
