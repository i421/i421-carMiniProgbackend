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
                        <el-select v-model="conditionAuth" placeholder="是否认证" multiple="multiple" class="table-search">
                            <el-option label="认证" value="1"></el-option>
                            <el-option label="未认证" value="0"></el-option>
                        </el-select>
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

            <el-row>
                <div>
                    <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                    <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
                    <el-button type="primary" class="table-button" icon="el-icon-s-check" @click="checkBroker">审核</el-button>
                    <el-button type="primary" class="table-button" icon="el-icon-s-check" @click="scoreAdd">积分增加管理</el-button>
                    <el-button type="primary" class="table-button" icon="el-icon-s-check" @click="scoreSub">积分回收管理</el-button>
                </div>
            </el-row>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
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
            conditionNickname: '',
            conditionPhone: '',
            conditionAuth: [],
            conditionTime: '',
			tableData: [],
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
                label: "积分数",
                prop: "score_count",
            }, {
                label: "回收积分数",
                prop: "recycling_score_count",
            }, {
                label: "是否认证",
                prop: "auth",
            }],

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
                    /*
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-refresh'
                    },
                    handler: row => {
                        this.togglePass(row)
                    },
                    label: '切换是否销售'
                    */
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-delete-solid'
                    },
                    handler: row => {
                        this.ban(row)
                    },
                    label: '禁用'
                }]
            },
        }
      },

      created () {
          this.fetchCustomers()
      },

      methods: {

          fetchCustomers() {
            http({
                url: Api.brokers,
            }).then(response => {

                for (let i = 0; i < response.data.data.length; i++) {
                    response.data.data[i]['auth'] =  response.data.data[i]['auth'] == "1" ? "认证" : "未认证";
                }

                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionNickname = ''
            this.conditionPhone = ''
            this.conditionTime = ''
            this.conditionAuth = []
          },

          //查询
          search() {
            http({
                url: Api.searchBroker,
                method: "post",
                data: {
                    'phone': this.conditionPhone,
                    'nickname': this.conditionNickname,
                    'auth': this.conditionAuth,
                    'time': this.conditionTime,
                }
            }).then(response => {

                console.log((response.data.data))
                for (let i = 0; i < response.data.data.length; i++) {
                    response.data.data[i]['auth'] =  response.data.data[i]['auth'] == "1" ? "认证" : "未认证";
                }

                this.tableData = response.data.data
            })
          },
        
          //查看详情
          show(row) {
              this.$router.push({ name: 'showBroker', params: {"id": row.id} })
          },

          togglePass(row) {

              if (row.is_seller == '非销售') {
                var is_seller = 1;
              } else {
                var is_seller = 0;
              }

              http({
                  url: Api.customerToggleIsSeller, 
                  params: {
                      id: row.id,
                      is_seller: is_seller
                  }
              }).then(response => {
                this.fetchCustomers()
              })
          },

          //禁止
          ban(row) {
            //todo
          },

          checkBroker() {
              this.$router.push({ name: 'brokerCheckList' })
          },

          scoreAdd() {
              this.$router.push({ name: 'brokerRechargeScoreList' })
          },

          scoreSub() {
              this.$router.push({ name: 'brokerRecyclingScoreList' })
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
