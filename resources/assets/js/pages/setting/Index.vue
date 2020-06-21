<template>
    <div>
	<el-tag size="medium" style="display: inline-block; margin-bottom: 20px;">轮播图设置</el-tag>

        <div id="tableTools">
            <el-button type="primary" size="small" class="table-button" icon="el-icon-plus" @click="addCarousel">新增轮播图</el-button>
        </div>
		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="轮播图" prop="path" width="180">
                <template slot-scope="scope">
                    <el-image style="width: 60px; height: 60px" :src="scope.row.path"></el-image>
                </template>
            </el-table-column>

            <el-table-column label="类型" prop="type" width="120">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.type == 1" type="success">车辆详情</el-tag>
                    <el-tag v-else-if="scope.row.type == 2" type="primary">三方网址</el-tag>
                    <el-tag v-else type="warning">拼团广告位</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="链接" prop="link" width="280">
            </el-table-column>

        </data-tables>

        <div class="scorecontainer">
            <el-tag size="medium" style="display: inline-block; margin-bottom: 20px;">积分设置</el-tag>
            <div style="width: 400px;">
                <el-input placeholder="" v-model.number="storeScore" style="margin-bottom: 10px">
                <template slot="prepend">新用户积分</template>
                </el-input>	
                <el-input placeholder="" v-model.number="recommendScore" style="margin-bottom: 10px">
                <template slot="prepend">推荐用户积分</template>
                </el-input>	
            <el-button @click="updateScore" type="primary" size="small">更新设置</el-button>
            </div>
        </div>
        <!--
        <div class="moneycontainer">
            <el-tag size="medium" style="display: inline-block; margin-bottom: 20px;">积分设置</el-tag>
            <div style="width: 400px;">
                <el-input placeholder="" v-model.number="agentReturnMoney" style="margin-bottom: 10px">
                <template slot="prepend">代理商返佣比例</template>
                </el-input>	
                <el-input placeholder="" v-model.number="relationReturnMoney" style="margin-bottom: 10px">
                    <template slot="prepend">推荐关系返佣比例</template>
                </el-input>	
                <el-input placeholder="" v-model.number="partnerCannotRecycleRatio" style="margin-bottom: 10px">
                    <template slot="prepend">合作商家不能提现比例</template>
                </el-input>	
            <el-button @click="updateMoney" type="primary" size="small">更新设置</el-button>
            </div>
        </div>
        -->
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data() {
          return {
            tableData: [],
            storeScore: 0,
            recommendScore: 0,
            relationReturnMoney: 0,
            agentReturnMoney: 0,
            partnerCannotRecycleRatio: 0,
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
                    label: '编辑'
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
          this.fetchCarousel()
          this.fetchScore()
          this.fetchMoney()
      },

      methods: {
        fetchCarousel() {
            http({
                url: Api.settingSetCarousel,
                method: 'get',
            }).then(response => {
                this.tableData = response.data.data
            }).catch(err => {
                console.log(err)
            })
        },

        fetchScore() {
            http({
                url: Api.settingShowScore,
                method: 'get',
            }).then(response => {
                this.storeScore = response.data.data.store
                this.recommendScore = response.data.data.recommend
            }).catch(err => {
                console.log(err)
            })
        },

        fetchMoney() {
            http({
                url: Api.settingShowMoney,
                method: 'get',
            }).then(response => {
                this.agentReturnMoney = response.data.data.agent_return_money
                this.relationReturnMoney = response.data.data.relation_return_money
                this.partnerCannotRecycleRatio = response.data.data.partner_cannot_recycle_ratio
            }).catch(err => {
                console.log(err)
            })
        },

        updateScore() {
            http({
                url: Api.settingUpdateScore,
                method: 'get',
                params: {value: [this.storeScore, this.recommendScore]}
            }).then(response => {
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })
                this.fetchScore()
            }).catch(err => {
                console.log(err)
            })
        },

        updateMoney() {
            http({
                url: Api.settingUpdateMoney,
                method: 'get',
                params: {value: [this.agentReturnMoney, this.relationReturnMoney, this.partnerCannotRecycleRatio]}
            }).then(response => {
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })
                this.fetchMoney()
            }).catch(err => {
                console.log(err)
            })
        },

        //添加轮播图
        addCarousel() {
            this.$router.push({ name: 'createSettingCarousel' })
        },

        //查看详情
        show(row) {
            this.$router.push({ name: 'showSettingCarousel', params: {"id": row.uuid} })
        },

        //删除
        destroy(row) {

		  this.$confirm('此操作将永久该轮播图, 是否继续?', '提示', {
		  	confirmButtonText: '确定',
		  	cancelButtonText: '取消',
		  	type: 'warning'
		  }).then(() => {

		  	http({
		  		method: 'delete',
		  		url: Api.destroySettingCarousel + row.uuid,
		  	}).then(response => {
		  		this.$notify.success({
		  			'title': "提示",
		  			'message': response.data.msg
		  		})
          	    this.fetchCarousel()
		  	})

		  }).catch(() => {
		  	this.$notify({
		  		type: 'info',
		  		message: '已取消删除'
		  	});
		  })
        }
      }
  }
</script>

<style>
#tableTools {
    display: block;
}
#tableTools .table-button {
    margin: 0 0 30px 0px;
}
.scorecontainer {
    margin: 50px 0 30px 0px;
}
.scoreTag {
    margin-bottom: 30px;
}
</style>
