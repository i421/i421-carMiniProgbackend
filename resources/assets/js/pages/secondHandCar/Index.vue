<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="padding-right: 5px">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionName" placeholder="汽车名"></el-input>
                    </div>
                </el-col>

                <el-col :span="6" style="padding-right: 5px">
                    <div style="width: 100%; min-width: 200px">
                        <el-select v-model="conditionShop" placeholder="经销商名">
                            <el-option
                                v-for="shop in shops"
                                :key="shop.id"
                                :label="shop.name"
                                :value="shop.id">
                            </el-option>
                        </el-select>
                    </div>
                </el-col>
            </el-row>

            <div class="searchControl">
                <!--<el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>-->
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-plus" @click="addSecondHandCar">新增</el-button>
            </div>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <!--
            <el-table-column label="商品图" prop="img_url" width="180">
                <template slot-scope="scope">
                    <el-image style="width: 60px; height: 60px" lazy :src="scope.row.avatar"></el-image>
                </template>
            </el-table-column>
            -->

            <el-table-column label="店铺名称" prop="shop_name">
            </el-table-column>

            <el-table-column label="店铺地址" prop="shop_address">
            </el-table-column>

            <el-table-column label="二手车名" prop="name">
            </el-table-column>

            <el-table-column label="类型" prop="type">
            </el-table-column>

            <el-table-column label="描述" prop="desc">
            </el-table-column>

            <el-table-column label="详细地址" prop="address">
            </el-table-column>
        </data-tables>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data () {
          return {
            shops: [],
            activeName: 'timeGroup',
		    dialogVisible: false,
            conditionName: '',
            conditionShop: '',
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
                        this.show(row)
                    },
                    label: '详情'
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
          this.fetchSecondHandCar()
          this.fetchShop()
      },
      methods: {
          fetchShop() {
              http({
                  url: Api.shops,
              }).then(response => {
                  this.shops = response.data.data
              }).catch(err => {
                  console.log(err)
              })
          },

          fetchSecondHandCar() {
            http({
                url: Api.secondHandCarList,
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionName = ''
            this.conditionShop = ''
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showSecondHandCar', params: {"id": row.id} })
          },

          addSecondHandCar() {
              this.$router.push({ name: 'createSecondHandCar' })
          },

          //删除
          destroy(row) {
            this.$confirm('此操作将永久删除二手车, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {

                http({
                    method: 'delete',
                    url: Api.destroySecondHandCar + row.id,
                }).then(response => {
                    this.$notify.success({
                        'title': "提示",
                        'message': response.data.msg
                    })
                    this.fetchSecondHandCar()
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
