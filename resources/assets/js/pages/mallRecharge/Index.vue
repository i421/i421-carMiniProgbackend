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
                    <el-input class="table-search" v-model.number="conditionAgent" placeholder="代理商"></el-input>
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
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="exportExcel">导出</el-button>
            </div>
        </div>

        <!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column label="ID" prop="id" width="180">
            </el-table-column>

            <el-table-column label="用户名" prop="nickname">
            </el-table-column>

            <el-table-column label="手机号" prop="phone">
            </el-table-column>

            <el-table-column label="充值金额" prop="count">
            </el-table-column>

            <el-table-column label="充值时间" prop="created_at">
            </el-table-column>

            <el-table-column label="充值方式" prop="type">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.type == 1" type="primary">微信</el-tag>
                    <el-tag v-else type="danger">后台</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="上级用户" prop="recommender">
            </el-table-column>

            <el-table-column label="代理商" prop="agent">
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
            conditionPhone: '',
            conditionAgent: '',
            conditionTime: [],
			tableData: [],
          }
      },
      created () {
          this.search()
      },
      methods: {
          search() {
            http({
                url: Api.searchMallRecharge,
                method: 'post',
                data: {
                    'name': this.conditionName,
                    'phone': this.conditionPhone,
                    'agent': this.conditionAgent,
                    'time': this.conditionTime,
                }
            }).then(response => {
                this.tableData = response.data.data;
            })
          },

          //清除查询条件
          clearSearch() {
            this.conditionName = ''
            this.conditionPhone = ''
            this.conditionAgent = ''
            this.conditionTime = []
          },

          exportExcel() {

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
