<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6">
                    <div style="width: 100%">
                        <el-input class="table-search" v-model="conditionNickname" placeholder="昵称"></el-input>
                        <el-input class="table-search" v-model="conditionPhone" placeholder="手机号"></el-input>
                    </div>
                </el-col>

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
                <el-button
                    type="primary"
                    class="table-button"
                    icon="el-icon-search"
                    @click="fetchCutomerCheckList">
                    查询
                </el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
            </div>
        </div>

        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="全部" name="first">

                <!-- table数据 -->
                <data-tables border :data="allTableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
                    </el-table-column>
                </data-tables>

            </el-tab-pane>

            <el-tab-pane label="待审核" name="second">

                <!-- table数据 -->
                <data-tables border :data="notAuthTableData" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
                    </el-table-column>
                </data-tables>

            </el-tab-pane>

            <el-tab-pane label="已审核" name="third">

                <!-- table数据 -->
                <data-tables border :data="authTableData" :pagination-props="{ pageSizes: [10, 15, 20] }">
                    <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
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
            conditionNickname: '',
            conditionPhone: '',
            conditionTime: '',
			allTableData: [],
			authTableData: [],
			notAuthTableData: [],
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
                label: "审核状态",
                prop: "auth",
            }],

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
                        this.show(row)
                    },
                    label: '详情'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-refresh'
                    },
                    handler: row => {
                        this.togglePass(row)
                    },
                    label: '切换审核状态'
                }]
            },
        }
      },

      created () {
          this.fetchCutomerCheckList()
      },

      methods: {

          fetchCutomerCheckList() {
            http({
                url: Api.cutomerCheckList,
                method: "post",
                data: {
                    'phone': this.conditionPhone,
                    'nickname': this.conditionNickname,
                    'time': this.conditionTime,
                }
            }).then(response => {
                //先初始化
                this.allTableData = []
                this.authTableData = []
                this.notAuthTableData = []

                //赋值
                for (let i = 0; i < response.data.data.length; i++) {

                    if (response.data.data[i]['auth'] == 1) {
                        response.data.data[i]['auth'] = '认证'
                        this.authTableData.push(response.data.data[i]);
                        this.allTableData.push(response.data.data[i]);
                    } else {
                        response.data.data[i]['auth'] = '未认证'
                        this.notAuthTableData.push(response.data.data[i]);
                        this.allTableData.push(response.data.data[i]);
                    }
                }

                this.tableData = response.data.data
            })
          },

          //清除查询条件
          clearSearch() {
            this.conditionNickname = ''
            this.conditionPhone = ''
            this.conditionTime = ''
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showCustomerCheck', params: {"id": row.id} })
          },

          //禁止
          togglePass(row) {

              if (row.auth == '认证') {
                var auth = 0;
              } else {
                var auth = 1;
              }

              http({
                  url: Api.customerAuthStatus, 
                  params: {
                      id: row.id,
                      auth: auth
                  }
              }).then(response => {
                this.fetchCutomerCheckList()
              })

          },

          //处理切换
          handleClick(tab, event) {
            //console.log(tab, event);
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
