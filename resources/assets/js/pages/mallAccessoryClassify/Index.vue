<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="padding-right: 5px">
                    <div style="width: 100%; min-width: 200px">
                        <el-input class="table-search" v-model="conditionName" placeholder="配件名"></el-input>
                    </div>
                </el-col>
            </el-row>

            <div class="searchControl">
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-plus" @click="addMallAccessory">新增</el-button>
            </div>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="分类标题" prop="name">
            </el-table-column>

            <el-table-column label="上级分类" prop="p_name">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.p_name == ''" type="primary">一级</el-tag>
                    <el-tag v-else type="warning">{{ scope.row.p_name }}</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="分类级别" prop="type">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.type == 1" type="danger">一级分类</el-tag>
                    <el-tag v-else type="warning">二级分类</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="分类下的配件数" prop="count">
            </el-table-column>

            <el-table-column label="权重" prop="height">
            </el-table-column>

        </data-tables>

		<!--添加角色表单-->
		<el-dialog title="添加分类" :visible.sync="dialogFormVisible">
		  <el-form :model="form" ref="form">
			<el-form-item label="名称" :label-width="formLabelWidth" prop="name"
				:rules="[
					{required: true, message: '名称不能为空'}
				]"
            >
			  <el-input v-model="form.name" autocomplete="off"></el-input>
			</el-form-item>

			<el-form-item label="类型" :label-width="formLabelWidth" prop="type"
				:rules="[
					{required: true, message: '类别必须'}
				]"
            >
              <el-select v-model="form.type" placeholder="请选择">
                  <el-option label="一级分类" value="0"> </el-option>
                  <el-option
                      v-for="mallaccessoryClassify in mallaccessoryClassifies"
                      :key="mallaccessoryClassify.id"
                      :label="mallaccessoryClassify.name"
                      :value="mallaccessoryClassify.id">
                  </el-option>
              </el-select>
			</el-form-item>

			<el-form-item label="权重" :label-width="formLabelWidth"
                :rules="[
                    { required: true, message: '权重必须', trigger: 'blur' },
                ]"
            >
			  <el-input v-model="form.height" autocomplete="off"></el-input>
			</el-form-item>

            <div v-if="form.type != 0">
            <el-form-item label="图片" prop="img"
                :rules="[
                    { required: true, message: '图片', trigger: 'blur' },
                ]"
            >
                <el-upload
                    class="upload-demo"
                    ref="upload"
                    drag
                    :onChange="addFile"
                    :on-remove="removeFile"
                    action=""
                    :limit="1"
                    :auto-upload="false">
                    <i class="el-icon-upload"></i>
                    <div slot="tip" class="el-upload__tip">只能上传一张jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>
            </div>

		  </el-form>
		  <div slot="footer" class="dialog-footer">
			<el-button @click="cancelClassify">取 消</el-button>
			<el-button type="primary" @click="addClassify('form')">确 定</el-button>
		  </div>
		</el-dialog>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data () {
          return {
			dialogFormVisible: false,
            formLabelWidth: "80",
            conditionName: '',
			tableData: [],
            mallaccessoryClassifies: [],
            form: {
                name: '',
                type: '',
                p_name: '',
                p_id: '',
                img: '',
                height: '',
            },
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
                    },
                    handler: row => {
                        this.show(row)
                    },
                    label: '编辑'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
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
          this.search()
          this.fetchMallAccessoryClassify()
      },
      methods: {
          fetchMallAccessoryClassify() {
              http({
                  url: Api.primaryMallAccessoryClassifies,
              }).then(response => {
                  this.mallaccessoryClassifies = response.data.data
              }).catch(err => {
                  console.log(err)
              })
          },

          search() {
            http({
                url: Api.searchMallAccessoryClassify,
                method: "post",
                data: {
                    'name': this.conditionName,
                }
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionName = ''
          },

          addMallAccessory() {
            this.dialogFormVisible = true
          },

          addClassify() {
			this.$refs['form'].validate((valid) => {
                if (valid) {
                    let formData = new FormData()
                    formData.append('name', this.form.name)
                    formData.append('type', this.form.type)
                    formData.append('height', this.form.height)
                    if (this.form.type == 0) {
                        formData.append('p_id', 0)
                    }
                    if (typeof(this.form.img) == 'object') {
                        formData.append('img', this.form.img)
                    }

                    http({
						url: Api.storeMallAccessoryClassify,
                        method: 'post',
                        data: formData
                    }).then(response => {
                        this.$refs['form'].resetFields();
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })

                        this.search();
                        this.dialogFormVisible = false

                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    console.log('err')
                }
			});
          },

          cancelClassify() {
            this.dialogFormVisible = false
          },

          addFile(file, fileList) {
              this.form.img = file.raw;
          },

          removeFile(file, fileList) {
              this.form.img = {};
          },

          show(row) {
              this.$router.push({ name: 'showMallaccessoryclassify', params: {"id": row.id} })
          },

          //删除
          destroy(row) {
            this.$confirm('此操作将删除, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {

                http({
                    method: 'delete',
                    url: Api.deleteMallaccessoryClassify + row.id,
                }).then(response => {
                    this.$notify.success({
                        'title': "提示",
                        'message': response.data.msg
                    })
                    this.search()
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
#tableTools .table-search {
    margin: 0 10px 15px 0px;
}
.upload-demo .el-upload__input {
	margin-top: -30px;
}
.upload-demo {
    margin-bottom: 20px;
    max-height: 320px;
}
.submitButton {
    z-index: 999;
    margin: 0 auto;
}
.el-upload-list {
    height: 50px;
}
</style>
