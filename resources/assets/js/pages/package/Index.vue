<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-button type="primary" class="table-button" icon="el-icon-plus" @click="dialogFormVisible = true">添加套餐</el-button>
            </el-row>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="序号" prop="id" width="80">
            </el-table-column>

            <el-table-column label="套餐名称" prop="name">
            </el-table-column>

            <el-table-column label="保养次数" prop="maintenance_count">
            </el-table-column>

            <el-table-column label="价格" prop="price">
            </el-table-column>

            <el-table-column label="汽车档位(下限)" prop="min_price">
            </el-table-column>

            <el-table-column label="汽车档位(上限)" prop="max_price">
            </el-table-column>

            <el-table-column label="创建时间" prop="created_at">
            </el-table-column>

        </data-tables>

		<!--添加角色表单-->
		<el-dialog title="添加套餐" :visible.sync="dialogFormVisible">
		  <el-form :model="form" ref="form">
			<el-form-item label="套餐名称" :label-width="formLabelWidth" prop="name"
				:rules="[
					{required: true, message: '名称不能为空'}
				]"
            >
			  <el-input v-model="form.name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="保养次数" :label-width="formLabelWidth" prop="maintenance_count"
				:rules="[
					{required: true, message: '保养次数不能为空'}
				]"
            >
			  <el-input v-model.number="form.maintenance_count" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="价格" :label-width="formLabelWidth" prop="price"
				:rules="[
					{required: true, message: '价格不能为空'}
				]"
			>
			  <el-input v-model.number="form.price" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="汽车档位(下限)" :label-width="formLabelWidth" prop="min_price"
				:rules="[
					{required: true, message: '汽车档位不能为空'}
				]"
			>
			  <el-input v-model="form.min_price" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="汽车档位(上限)" :label-width="formLabelWidth" prop="max_price"
				:rules="[
					{required: true, message: '汽车档位不能为空'}
				]"
			>
			  <el-input v-model="form.max_price" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="描述" :label-width="formLabelWidth">
			  <el-input v-model="form.desc" autocomplete="off"></el-input>
			</el-form-item>

		  </el-form>
		  <div slot="footer" class="dialog-footer">
			<el-button @click="canclePackage">取 消</el-button>
			<el-button type="primary" @click="addPackage('form')">确 定</el-button>
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
			dialogFormVisible: false,
			formLabelWidth: '120px',
			tableData: [],
			form: {
				name: '',
				maintenance_count: '',
				price: '',
				min_price: '',
				max_price: '',
				desc: '',
			},

            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '200px',
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
                        icon: 'el-icon-delete'
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
          this.fetchPackages()
      },

      methods: {

          fetchPackages() {
            http({
                url: Api.packages,
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showPackage', params: {"id": row.id} })
          },

          destroy(row) {
            http({
                url: Api.destroyPackage + row.id,
                method: 'delete',
            }).then(response => {
                this.fetchPackages()
            })
          },

          //确认
          addPackage (form) {
              this.$refs[form].validate((valid) => {
                if (valid) {
                  http({
                      method: 'post',
                      url: Api.storePackage,
                      data: this.form
                  }).then(response => {
                      this.$notify.success({
                          'title': "提示",
                          'message': response.data.msg
                      })
                      this.fetchPackages()
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

		//取消添加
		canclePackage () {
			this.dialogFormVisible = false;
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
