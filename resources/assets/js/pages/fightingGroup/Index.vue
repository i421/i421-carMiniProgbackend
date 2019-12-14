<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="margin-right: 5px;">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionCarName" placeholder="汽车名称"></el-input>
                    </div>
                </el-col>

                <el-col :span="8" style="margin-right: 5px;">
                    <el-select v-model="conditionGroup" placeholder="拼团类型" multiple="multiple" class="table-search">
                        <el-option label="时间拼团" value="1"></el-option>
                        <el-option label="数量拼团" value="2"></el-option>
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

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="序号" prop="id" width="60">
            </el-table-column>

            <el-table-column label="汽车名称" prop="name" width="150">
            </el-table-column>

            <el-table-column label="类型" prop="type" width="100">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.group_type == 1" type="success">时间拼团</el-tag>
                    <el-tag v-else type="primary">数量拼团</el-tag>
                </template>
            </el-table-column>

            <!--
            <el-table-column label="首页推荐" prop="group_recommend" width="110">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.group_recommend == 1" type="warning">首页推荐</el-tag>
                    <el-tag v-else type="default">非首页推荐</el-tag>
                </template>
            </el-table-column>
            -->

            <el-table-column label="拼团价格" prop="group_price" width="120">
            </el-table-column>

            <el-table-column label="优惠(仅数量拼团)" prop="off" width="120">
            </el-table-column>

            <el-table-column label="开始时间" prop="start_time" width="180">
            </el-table-column>

            <el-table-column label="结束时间" prop="end_time" width="180">
            </el-table-column>

            <el-table-column label="拼团总数" prop="total_num" width="150">
            </el-table-column>

            <el-table-column label="拼团当前数" prop="current_num" width="80">
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
            conditionCarName: '',
            conditionGroup: [],
			tableData: [],

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '130px',
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
            this.conditionCarName = ''
            this.conditionGroup = []
          },

          //查询
          search() {
            http({
                url: Api.searchFightingGroup,
                params: {
                    'time': this.conditionTime,
                    'group_type': this.conditionGroup,
                    'car_name': this.conditionCarName,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showFightingGroup', params: {"id": row.id} })
          },
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
