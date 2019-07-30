<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="100px" style="width:460px">

                    <el-form-item label="名称" prop="name"
                        :rules="[
                            { required: true, message: '名称不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="首字母" label-width="100px" prop="head"
                        :rules="[
                            { required: true, message: '首字母不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.head"></el-input>
                    </el-form-item>

                    <el-form-item label="品牌图" label-width="100px" prop="logo"
                        :rules="[
                            { required: true, message: '品牌图不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="previewLogo"
                            :preview-src-list="[previewLogo]"
                            fit="fit">
                        </el-image>
                        <el-button size="small" style="margin-left: 10px" @click="updateBrandLogo" icon="el-icon-upload">上传</el-button>
                    </el-form-item>

                </el-form>
            </el-col>

            <el-col>
                <div class="submitButton">
                    <el-button style="margin-left: 50px;"
                        size="small"
                        type="primary"
                        @click="submitUpload">
                        立即更新
                    </el-button>
                    <el-button @click="back">返回列表</el-button>
                </div>
            </el-col>

        </el-row>

        <div>
          <el-dialog title="更新品牌图" :visible.sync="brandDialogVisible">
              <div style="text-align: center; margin: 0 auto">
                <el-upload
                    class="upload-demo"
                    ref="upload"
                    drag
                    :onChange="addFile"
                    action=""
                    :limit="1"
                    :auto-upload="false">
                    <i class="el-icon-upload"></i>
                    <div slot="tip" class="el-upload__tip">只能上传一张jpg/png文件，且不超过500kb</div>
                </el-upload>
              </div>
          </el-dialog>
        </div>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data() {
          return {
              brandDialogVisible: false,
              fileList: [],
              form: {
                  name: '',
                  head: '',
                  logo: {},
              },
              previewLogo: '',
          }
      },

      created () {
          this.fetchBrand();
      },

      methods: {

        fetchBrand() {
          http({
              url: Api.showBrand + this.$route.params.id,
          }).then(response => {
              this.form = response.data.data
              this.previewLogo = response.data.data.logo
          })
        },

        submitUpload() {
            let formData = new FormData()

            formData.append('name', this.form.name)
            formData.append('head', this.form.head)

            if (typeof(this.form.logo) == 'object') {
                formData.append('logo', this.form.logo)
            }

            http({
                url: Api.updateBrand + this.$route.params.id,
                method: 'post',
                data: formData
            }).then(response => {
                this.fetchBrand()
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })
                this.$router.push({ name: 'brand'})
            }).catch(err => {
                console.log(err)
            })
        },

        updateBrandLogo() {
            this.brandDialogVisible = true
        },

        addFile(file, fileList) {
            this.previewLogo = URL.createObjectURL(file.raw);;
            this.form.logo = file.raw;
            this.brandDialogVisible = false
        },

        back() {
            this.$router.push({ name: 'brand'})
        },
      }
  }
</script>

<style>
.upload-demo .el-upload__input {
	margin-top: -30px;
}
.upload-demo {
    margin-bottom: 50px;
    max-height: 350px;
}
.submitButton {
    z-index: 999;
}
.el-upload-list {
    height: 50px;
}
</style>
