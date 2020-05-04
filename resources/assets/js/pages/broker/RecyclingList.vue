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

                <el-col :span="8" style="margin-right: 5px;">
                    <el-select v-model="conditionStatus" placeholder="打款状态" multiple="multiple" class="table-search">
                        <el-option label="已打款" value="1"></el-option>
                        <el-option label="未打款" value="0"></el-option>
                    </el-select>
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
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
            </div>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="序号" prop="id">
            </el-table-column>

            <el-table-column label="OpenId" prop="openid">
            </el-table-column>

            <el-table-column label="手机号" prop="phone">
            </el-table-column>
            
            <el-table-column label="昵称" prop="nickname">
            </el-table-column>

            <el-table-column label="分数" prop="score">
            </el-table-column>

            <el-table-column label="收款码" prop="full_wechat_payment_code" width="180">
                <template slot-scope="scope">
                    <el-image
                        style="width: 60px; height: 60px" lazy
                        :src="scope.row.broker_info.full_wechat_payment_code"
                        :preview-src-list="[scope.row.broker_info.full_wechat_payment_code]"
                    ></el-image>
                </template>
            </el-table-column>


			<el-table-column label="状态" prop="status" width="130">
				<template slot-scope="scope">
					<el-tag v-if="scope.row.status == 1" type="success">已打款</el-tag>
					<el-tag v-else type="error">未打款</el-tag>
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
            conditionNickname: '',
            conditionPhone: '',
            conditionTime: '',
            conditionStatus: [],
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
                label: "提取积分数",
                prop: "score",
            }, {
                label: "状态",
                prop: "status",
            }, {
                label: "操作时间",
                prop: "created_at",
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
                        this.toggleStatus(row)
                    },
                    label: '切换打款状态'
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
          this.fetchBrokerRecyclingScoreList()
      },

      methods: {

          fetchBrokerRecyclingScoreList() {
            http({
                method: 'post',
                url: Api.brokerRecyclingScoreList,
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionNickname = ''
            this.conditionPhone = ''
            this.conditionTime = ''
          },

          //查询
          search() {
            http({
                url: Api.brokerRecyclingScoreList,
                method: "post",
                data: {
                    'phone': this.conditionPhone,
                    'nickname': this.conditionNickname,
                    'time': this.conditionTime,
                    'status': this.conditionStatus,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //删除
          destroy(row) {
			this.$confirm('此操作将删除记录, 是否继续?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
                http({
                    url: Api.brokerDeleteRecyclingScore + row.id,
                    method: "delete",
                }).then(response => {
                    this.search()
                })
            }).catch(() => {
                this.$notify({
                    type: 'info',
                    message: '已取消删除'
                });
            })
          },
          
          //查看
          toggleStatus(row) {
			var brokerStatus = 0
			if (row.status == 1) {
				brokerStatus = 0;		
			} else {
				brokerStatus = 1;		
			}

            http({
                url: Api.toggleBrokerRecyclingStatus + row.id,
                method: "post",
                data: {
                    'status': brokerStatus,
                }
            }).then(response => {
				this.search()
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
