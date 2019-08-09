<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="margin-right: 5px;">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionName" placeholder="经销商"></el-input>
                    </div>
                </el-col>

                <el-col :span="6" style="margin-right: 5px;">
                    <div style="width: 100%">
                        <el-input class="table-search" v-model="conditionPhone" placeholder="手机号"></el-input>
                    </div>
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
                <el-button type="primary" class="table-button" icon="el-icon-plus" @click="addShop">新增</el-button>
            </div>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="序号" prop="id" width="180">
            </el-table-column>

            <el-table-column label="门店" prop="img_url" width="180">
                <template slot-scope="scope">
                    <el-image style="width: 60px; height: 60px" :src="scope.row.img_url"></el-image>
                </template>
            </el-table-column>

            <el-table-column label="经销商名" prop="name">
            </el-table-column>

            <el-table-column label="手机号" prop="phone">
            </el-table-column>

            <el-table-column label="地址" prop="address">
            </el-table-column>

            <el-table-column label="订单数" prop="order_count">
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
            conditionName: '',
            conditionPhone: '',
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
                        this.showShop(row)
                    },
                    label: '详情'
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
          this.fetchShops()
      },

      methods: {

          fetchShops() {
            http({
                url: Api.shops,
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionName = ''
            this.conditionPhone = ''
            this.conditionTime = ''
          },

          //查询
          search() {
            http({
                url: Api.searchShop,
                params: {
                    'name': this.conditionName,
                    'phone': this.conditionPhone,
                    'time': this.conditionTime,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //添加
          addShop() {
              this.$router.push({ name: 'createShop'})
          },
        
          //查看详情
          showShop(row) {
              this.$router.push({ name: 'showShop', params: {"id": row.id} })
          },

          //删除
          destroy(row) {

			this.$confirm('此操作将永久该品牌, 是否继续?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {

				http({
					method: 'delete',
					url: Api.destroyShop + row.id,
				}).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
            	    this.fetchShops()
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
