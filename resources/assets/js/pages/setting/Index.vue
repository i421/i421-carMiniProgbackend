<template>
    <div>
        <div id="tableTools">
            <el-button type="primary" class="table-button" icon="el-icon-plus" @click="addCarousel">新增</el-button>
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
                    <el-tag v-else type="primary">三方网址</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="链接" prop="link" width="280">
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
			tableData: [],
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
    display: inline-block;
}
#tableTools .table-button {
    margin: 0 0 30px 0px;
}
</style>
