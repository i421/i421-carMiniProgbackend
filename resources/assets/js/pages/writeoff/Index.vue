<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="margin-right: 5px;">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionMerchantPhone" placeholder="核销人手机号"></el-input>
                    </div>
                </el-col>

                <el-col :span="6" style="margin-right: 5px;">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionCustomerPhone" placeholder="消费者手机号"></el-input>
                    </div>
                </el-col>
            </el-row>

            <div>
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
            </div>
        </div>

		<!-- table数据 -->        
        <data-tables-server
            border
            :total="total"
            :data="tableData"
            :pagination-props="{ pageSizes: [10, 15, 20, 10000] }"
            @query-change="loadData"
        >

            <el-table-column label="序号" prop="write_off_id" width="180">
            </el-table-column>

            <el-table-column label="核销人昵称" prop="merchant_nickname">
            </el-table-column>

            <el-table-column label="核销人手机号" prop="merchant_phone">
            </el-table-column>

            <el-table-column label="消费者昵称" prop="customer_nickname">
            </el-table-column>

            <el-table-column label="消费者手机号" prop="customer_phone">
            </el-table-column>

            <el-table-column label="内容" prop="content">
            </el-table-column>

            <el-table-column label="核销时间" prop="write_off_created_at">
            </el-table-column>

        </data-tables-server>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
	  data() {
		return {
            pageSize: 15,
            page: 1,
            conditionCustomerNickname: '',
            conditionCustomerPhone: '',
            conditionMerchantNickname: '',
            conditionMerchantPhone: '',
			tableData: [],
            total: 0,
        }
      },

      created () {
        this.search({
            page: this.page,
            pageSize: this.pageSize,
        }) 
      },

      methods: {

          //清楚查询条件
          clearSearch() {
            this.conditionCustomerNickname = ''
            this.conditionCustomerPhone = ''
            this.conditionMerchantNickname = ''
            this.conditionMerchantPhone = ''
          },

        async loadData(queryInfo) {
        await this.search(queryInfo)
        },

        search(queryInfo) {
            this.tableData = []
            http({
                url: Api.searchWriteOff,
                method: "post",
                data: {
                    'customer_phone': this.conditionCustomerPhone,
                    'merchant_phone': this.conditionMerchantPhone,
                    'page': queryInfo.page,
                    'pagesize': queryInfo.pageSize,
                }
            }).then(response => {
                this.total = response.data.total
                this.tableData = response.data.data
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
