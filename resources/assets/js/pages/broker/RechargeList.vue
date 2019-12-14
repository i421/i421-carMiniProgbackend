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
				<el-button type="primary" class="table-button" icon="el-icon-plus" @click="addScore">添加</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
            </div>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>
        </data-tables>

		<!--添加加分表单-->
		<el-dialog id="addScoreForm" title="添加加分" :visible.sync="dialogFormVisible">
		  <el-form :model="form" ref="form">
			<el-form-item label="经纪人(手机号)" :label-width="formLabelWidth"  prop="customer_id"
				:rules="[
					{required: true, message: '经纪人不能为空'}
				]"
            >
			<el-autocomplete
			  popper-class="my-autocomplete"
			  v-model="state"
			  :fetch-suggestions="querySearch"
			  placeholder="请输入内容(根据手机号过滤)"
			  @select="handleSelect">
			  <i
				class="el-icon-edit el-input__icon"
				slot="suffix"
				@click="handleIconClick">
			  </i>
			  <template slot-scope="{ item }">
				<div class="nickname">昵称: {{ item.nickname }}</div>
				<span class="phone">手机号: {{ item.phone }}</span>
`				<el-divider></el-divider>
			  </template>
			</el-autocomplete>
			</el-form-item>

			<el-form-item label="加分数" :label-width="formLabelWidth"
				:rules="[
					{required: true, message: '加分数不能为空'}
				]"
            >
			  <el-input v-model.number="form.score" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="加分说明" prop="content" :label-width="formLabelWidth"
				:rules="[
					{required: true, message: '加分说明不能为空'}
				]"
            >
			  <el-input v-model="form.content" autocomplete="off"></el-input>
			</el-form-item>

		  </el-form>
		  <div slot="footer" class="dialog-footer">
			<el-button @click="cancleAddScore">取 消</el-button>
			<el-button type="primary" @click="submitAddScore('form')">确 定</el-button>
		  </div>
		</el-dialog>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
	  data() {
		return {
			brokers: [],
			state: '',
			dialogFormVisible: false,
			formLabelWidth: '180px',
            conditionNickname: '',
            conditionPhone: '',
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
                label: "积分增加数",
                prop: "score",
            }, {
                label: "增加说明",
                prop: "content",
            }, {
                label: "时间",
                prop: "created_at",
            }],
			form: {
				customer_id: '',
				score: '',
				content: '',
			},

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '400px',
                },

                buttons: [{
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
          this.fetchBrokerRechargeScoreList()
      },

      methods: {

          fetchBrokerRechargeScoreList() {
            http({
                method: 'post',
                url: Api.brokerRechargeScoreList,
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
                url: Api.brokerRechargeScoreList,
                method: "post",
                data: {
                    'phone': this.conditionPhone,
                    'nickname': this.conditionNickname,
                    'time': this.conditionTime,
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
                    url: Api.brokerDeleteScore + row.id,
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
		  
          addScore() {
		  	this.dialogFormVisible = true
          },

		  handleSelect(item) {
			this.state = item.phone
			this.form.customer_id = item.id
		  },

		  handleIconClick(ev) {
			console.log("icon click");
		  },

		  querySearch(queryString, cb) {

            http({
                url: Api.searchBroker,
                method: "post",
                data: {
                    'phone': queryString,
                }
            }).then(response => {
				var brokers = response.data.data
				var results = queryString ? brokers.filter(this.createFilter(queryString)) : brokers;
				cb(results)
            })

		  },

		createFilter(queryString) {
			return (broker) => {
				return (broker.phone.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
			};
		},

		cancleAddScore() {
			this.dialogFormVisible = false;
		},

        submitAddScore (form) {
            this.$refs[form].validate((valid) => {
              if (valid) {
                http({
                    method: 'post',
                    url: Api.brokerAddScore,
                    data: this.form
                }).then(response => {
					this.$notify.success({
						'title': "提示",
						'message': response.data.msg
					})
            	    this.search()
                    this.$refs[form].resetFields();
                }).catch(err => {
                    console.log(err)
                })

			    this.dialogFormVisible = false;
              } else {
                return false;
              }
            })
        },
      },
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
.my-autocomplete {
  li {
    line-height: normal;
    padding: 7px;

    .nickname {
      text-overflow: ellipsis;
      overflow: hidden;
    }
    .phone {
      font-size: 8px;
      color: #b4b4b4;
    }

    .highlighted .phone {
      color: #ddd;
    }
  }
}
#addScoreForm > div > div.el-dialog__body > form > div.el-form-item.is-error.is-required > div > div.el-autocomplete > div > input {
	width: 100%;
	min-width: 300px;
}
</style>
