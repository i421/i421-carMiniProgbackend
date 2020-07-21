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

                        <el-select v-model="conditionSeller" placeholder="能否核销" multiple="multiple" class="table-search">
                            <el-option label="核销" value="1"></el-option>
                            <el-option label="无核销权限" value="0"></el-option>
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

                    <el-select v-model="conditionBuyer" placeholder="是否购买套餐" multiple="multiple" class="table-search">
                        <el-option label="购买" value="1"></el-option>
                        <el-option label="未购买" value="0"></el-option>
                    </el-select>
                </el-col>
            </el-row>


            <div>
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
                <!--
                <el-button type="primary" class="table-button" icon="el-icon-s-check" @click="checkCustomer">审核</el-button>
                -->
            </div>
        </div>

		<!-- table数据 -->
        <data-tables-server
            border
            :total="total"
            :loading="loading"
            :data="tableData"
            :action-col="actionCol"
            :pagination-props="{ pageSizes: [10, 15, 20, 10000] }"
            @query-change="loadData">

            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>
            
            <el-table-column prop="package_count" label="是否购买套餐">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.package_count <= 0" type="danger">未购买</el-tag>
                    <el-tag v-else type="success">有套餐</el-tag>
                </template>
            </el-table-column>

            <el-table-column prop="auth" label="是否认证">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.auth == 0" type="danger">未认证</el-tag>
                    <el-tag v-else type="success">认证用户</el-tag>
                </template>
            </el-table-column>

            <el-table-column prop="is_seller" label="核销">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.is_seller == 0" type="danger">无核销权限</el-tag>
                    <el-tag v-else type="success">核销</el-tag>
                </template>
            </el-table-column>

            <el-table-column prop="is_partner" label="是否合作商家">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.is_partner == 0" type="danger">非合作商家</el-tag>
                    <el-tag v-else type="success">合作商家</el-tag>
                </template>
            </el-table-column>

            <el-table-column prop="is_agent" label="代理商">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.is_agent == 0" type="danger">非代理商</el-tag>
                    <el-tag v-else type="success">代理商</el-tag>
                </template>
            </el-table-column>

            <el-table-column prop="type" label="是否经纪人">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.type == 1" type="danger">普通用户</el-tag>
                    <el-tag v-else type="success">经纪人</el-tag>
                </template>
            </el-table-column>

            <el-table-column prop="type_auth" label="经纪人认证">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.type_auth == 1" type="success">经纪人认证</el-tag>
                    <el-tag v-else type="danger">未认证</el-tag>
                </template>
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
            pageSize: "20",
            page: "1",
            total: 0,
            conditionNickname: '',
            conditionPhone: '',
            conditionBuyer: [],
            conditionAuth: [],
            conditionTime: '',
            conditionSeller: '',
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
                label: "订单数",
                prop: "order_count",
            }, {
                label: "推荐人数",
                prop: "recommend_count",
            }, {
                label: "收藏数",
                prop: "collection_count",
            }, {
                label: "创建时间",
                prop: "created_at",
            }],

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '600px',
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
                    label: '切换能否核销'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-refresh'
                    },
                    handler: row => {
                        this.toggleAgent(row)
                    },
                    label: '标记代理商'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-refresh'
                    },
                    handler: row => {
                        this.togglePartner(row)
                    },
                    label: '标记合作商家'
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
          this.search({
            page: this.page,
            pageSize: this.pageSize,
          })
      },

      methods: {

          fetchCustomers() {
            http({
                url: Api.customers,
            }).then(response => {

                /*
                for (let i = 0; i < response.data.data.length; i++) {
                    response.data.data.data[i]['auth'] =  response.data.data.data[i]['auth'] == "1" ? "认证" : "未认证";
                    response.data.data.data[i]['is_seller'] =  response.data.data.data[i]['is_seller'] == "1" ? "核销" : "无核销权限";
                }
                */

                this.tableData = response.data.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionNickname = ''
            this.conditionPhone = ''
            this.conditionTime = ''
            this.conditionAuth = []
            this.conditionSeller =[]
          },

	  async loadData(queryInfo) {
            await this.search(queryInfo)
	  },

          //查询
      search(queryInfo) {
	    this.loading = true
            this.tableData = []
            http({
                url: Api.searchCustomer,
                method: "post",
                data: {
                    'phone': this.conditionPhone,
                    'nickname': this.conditionNickname,
                    'auth': this.conditionAuth,
                    'time': this.conditionTime,
                    'is_seller': this.conditionSeller,
                    'is_buyer': this.conditionBuyer,
                    'page': queryInfo.page,
                    'pageSize': queryInfo.pageSize,
                }
            }).then(response => {
                this.loading = false

                /*
                for (let i = 0; i < response.data.data.length; i++) {
                    response.data.data[i]['auth'] =  response.data.data[i]['auth'] == "1" ? "认证" : "未认证";
                    response.data.data[i]['is_seller'] =  response.data.data[i]['is_seller'] == "1" ? "核销" : "无核销权限";
                }
                */

                this.total = response.data.total

                this.tableData = response.data.data
            })
          },
        
          //查看详情
          show(row) {
              this.$router.push({ name: 'showCustomer', params: {"id": row.id} })
          },

          togglePass(row) {

              if (row.is_seller == '0') {
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
                  this.search({
                    page: this.page,
                    pageSize: this.pageSize,
                  })
              })
          },

          toggleAgent(row) {

              if (row.is_agent == 0) {
                var is_agent = 1;
              } else {
                var is_agent = 0;
              }

              http({
                  url: Api.customerToggleIsAgent, 
                  params: {
                      id: row.id,
                      is_agent: is_agent
                  }
              }).then(response => {
                  this.search({
                    page: this.page,
                    pageSize: this.pageSize,
                  })
              })
          },

          togglePartner(row) {

              if (row.is_partner == '0') {
                var is_partner = 1;
              } else {
                var is_partner = 0;
              }

              http({
                  url: Api.customerToggleIsPartner, 
                  params: {
                      id: row.id,
                      is_partner: is_partner
                  }
              }).then(response => {
                  this.search({
                    page: this.page,
                    pageSize: this.pageSize,
                  })
              })
          },

          //禁止
          ban(row) {
            //todo
            http({
                url: Api.banCustomer + row.id, 
                method: "post",
            }).then(response => {
                this.$notify({
                    type: 'info',
                    message: '已禁止'
                });
            })
          },

          checkCustomer() {
              this.$router.push({ name: 'customerCheckList' })
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

