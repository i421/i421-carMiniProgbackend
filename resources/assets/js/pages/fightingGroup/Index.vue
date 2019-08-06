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

            <el-table-column label="汽车名称" prop="car_name" width="180">
            </el-table-column>

            <el-table-column label="拼团类型" prop="type" width="80">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.type == 1" type="success">时间拼团</el-tag>
                    <el-tag v-else type="primary">数量拼团</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="拼团价格" prop="group_price" width="180">
            </el-table-column>

            <el-table-column label="开始时间" prop="start_time" width="180">
            </el-table-column>

            <el-table-column label="结束时间" prop="end_time" width="180">
            </el-table-column>

            <el-table-column label="拼团总数" prop="total_num" width="120">
            </el-table-column>

            <el-table-column label="拼团当前数" prop="current_num" width="120">
            </el-table-column>

            <el-table-column label="拼团状态" prop="status" width="80">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.status == 1" type="success">正常</el-tag>
                    <el-tag v-else type="primary">关闭</el-tag>
                </template>
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
                        this.show(row)
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
          this.fetchFightingGroups()
      },

      methods: {

          fetchFightingGroups() {
            http({
                url: Api.fightingGroups,
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
                url: Api.searchFightingGroup,
                params: {
                    'time': this.conditionTime,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showFightingGroup', params: {"id": row.id} })
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
					url: Api.destroyFightingGroup + row.id,
				}).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
            	    this.fetchFightingGroups()
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
