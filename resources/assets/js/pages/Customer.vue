<template>
    <div>
		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>
        </data-tables>
    </div>
</template>

<script>
  import { http } from './../utils/fetch'
  import Api from './../config'

  export default {
	  data() {
		return {
			tableData: [],
			originTableData: [],

            titles: [{
                label: "序号",
                prop: "id",
            }, {
                label: "微信openid",
                prop: "openid",
            }, {
                label: "手机号",
                prop: "phone",
            }, {
                label: "昵称",
                prop: "nickname",
            }, {
                label: "推荐人数",
                prop: "recommend_count",
            }, {
                label: "是否认证",
                prop: "status",
            }],
        }
      },

      created () {
      },

      methods: {
      }
  }
</script>

<style>
</style>
