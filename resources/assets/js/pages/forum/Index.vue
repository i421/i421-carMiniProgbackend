<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6">
                    <div style="width: 100%">
                        <el-input class="table-search" v-model="conditionNickname" placeholder="用户名"></el-input>
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

                <el-col :span="6" :offset="5">
                    <div>
                        <el-select v-model="conditionTop" placeholder="是否置顶" multiple="multiple" class="table-search">
                            <el-option label="置顶" value="1"></el-option>
                            <el-option label="非置顶" value="0"></el-option>
                        </el-select>
                    </div>
                </el-col>
            </el-row>
        </div>
        <div>
            <el-row style="display: inline-block; margin: 0 0 15px 0;">
                <div>
                    <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                    <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
                </div>
            </el-row>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="序号" prop="id" width="80">
            </el-table-column>

            <el-table-column label="标题" prop="title">
            </el-table-column>

            <el-table-column label="昵称" prop="nickname">
            </el-table-column>

            <el-table-column label="发布时间" prop="publish_at">
            </el-table-column>

            <el-table-column label="点赞数" prop="like">
            </el-table-column>

            <el-table-column label="评论数" prop="comment">
            </el-table-column>

            <el-table-column label="状态" prop="status" width="80px">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.status == 1" type="primary">正常</el-tag>
                    <el-tag v-else type="danger">禁止</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="置顶" prop="top" width="80px">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.top == 1" type="success">置顶</el-tag>
                    <el-tag v-else type="warning">不置顶</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="创建时间" prop="created_at">
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
            conditionTop: [],
            conditionTime: '',
			tableData: [],

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '300px',
                },

                buttons: [{
                    props: {
                        type: 'primary',
                        size: "mini",
                        icon: ''
                    },
                    handler: row => {
                        this.setTop(row)
                    },
                    label: '置顶'
                }, {
                    props: {
                        type: 'warning',
                        size: "mini",
                        icon: ''
                    },
                    handler: row => {
                        this.show(row)
                    },
                    label: '详情'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: ''
                    },
                    handler: row => {
                        this.toggle(row)
                    },
                    label: '状态切换'
                }]
            },
        }
      },

      created () {
          this.fetchForums()
      },

      methods: {
          //查询
          search() {
            http({
                url: Api.searchForum,
                method: "post",
                data: {
                    'nickname': this.conditionNickname,
                    'top': this.conditionTop,
                    'time': this.conditionTime,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionNickname = ''
            this.conditionTime = ''
            this.conditionTop = []
          },


          fetchForums() {
            http({
                url: Api.forums,
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showForum', params: {"id": row.id} })
          },

          toggle(row) {
            http({
                url: Api.checkForum + row.id,
                method: 'post',
            }).then(response => {
                this.fetchForums()
            })
          },

          setTop(row) {
            http({
                url: Api.topForum + row.id,
                method: 'post',
            }).then(response => {
                this.fetchForums()
            })
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
