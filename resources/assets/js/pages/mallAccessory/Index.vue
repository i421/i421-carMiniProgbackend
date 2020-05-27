<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="padding-right: 5px">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionName" placeholder="配件名"></el-input>
                    </div>
                </el-col>

                <el-col :span="6" style="padding-right: 5px">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionClassify" placeholder="品牌"></el-input>
                    </div>
                </el-col>
                <el-col :span="6" style="padding-right: 5px">
                    <el-input class="table-search" v-model.number="conditionMinPrice" placeholder="最低价格"></el-input>
                </el-col>

                <el-col :span="6">
                    <el-input class="table-search" v-model.number="conditionMaxPrice" placeholder="最高价格"></el-input>
                </el-col>
            </el-row>


            <div class="searchControl">
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-plus" @click="addMallAccessory">新增</el-button>
            </div>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column label="配件主图" prop="img_url" width="180">
                <template slot-scope="scope">
                    <el-image style="width: 60px; height: 60px" lazy :src="scope.row.avatar"></el-image>
                </template>
            </el-table-column>

            <el-table-column label="商品标题" prop="name">
            </el-table-column>

            <el-table-column label="规格" prop="size">
            </el-table-column>

            <el-table-column label="积分价" prop="score_price">
            </el-table-column>

            <el-table-column label="原价" prop="price">
            </el-table-column>

            <el-table-column label="销量" prop="count">
            </el-table-column>

            <el-table-column label="一级分类" prop="p_name">
            </el-table-column>

            <el-table-column label="二级分类" prop="classify_name">
            </el-table-column>

            <el-table-column label="权重" prop="height">
            </el-table-column>

            <el-table-column label="状态" prop="status">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.status == 1" type="danger">上架中</el-tag>
                    <el-tag v-else type="warning">下架</el-tag>
                </template>
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
            conditionName: '',
            conditionClassify: '',
            conditionMinPrice: '',
            conditionMaxPrice: '',
			tableData: [],
            groupForm: {
                name: '',
                size: '',
                avatar: '',
                score_price: '',
                price: '',
                count: '',
                status: '',
                height: '',
                first: '',
                second: '',
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
                        this.toggle(row)
                    },
                    label: '切换状态'
                }]
            },
          }
      },
      created () {
          this.fetchMallAccessories()
      },
      methods: {
          search() {
            http({
                url: Api.searchMallAccessory,
                method: 'post',
                data: {
                    'name': this.conditionName,
                    'classify': this.conditionClassify,
                    'min_price': this.conditionMinPrice,
                    'max_price': this.conditionMaxPrice,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          fetchMallAccessories() {
            http({
                url: Api.mallaccessories,
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionName = ''
            this.conditionClassify = ''
            this.conditionMinPrice = ''
            this.conditionMaxPrice = ''
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showMallAccessory', params: {"id": row.id} })
          },

          addMallAccessory() {
              this.$router.push({ name: 'createMallAccessory' })
          },

          //切换
          toggle(row) {
            this.$confirm('此操作将切换状态, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {

                http({
                    method: 'post',
                    url: Api.toggleMallaccessoryStatus + row.id,
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
