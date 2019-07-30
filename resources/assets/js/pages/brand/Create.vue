<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="80px" style="width:440px">

                    <el-form-item label="名称" prop="name"
                        :rules="[
                            { required: true, message: '名称不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="首字母" prop="head"
                        :rules="[
                            { required: true, message: '首字母不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.head"></el-input>
                    </el-form-item>

                    <el-form-item label="品牌图" prop="logo"
                        :rules="[
                            { required: true, message: '品牌图不能为空', trigger: 'blur' },
                        ]"
                    >
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
                    </el-form-item>

                </el-form>
            </el-col>

            <el-col>
                <div class="submitButton">
                    <el-button style="margin-left: 50px;"
                        size="small"
                        type="primary"
                        @click="submitUpload">
                        立即创建
                    </el-button>
                    <el-button @click="cancleUpload">重置</el-button>
                    <el-button @click="back">返回列表</el-button>
                </div>
            </el-col>

        </el-row>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data() {
          return {
              fileList: [],
              form: {
                  name: '',
                  head: '',
                  logo: {},
              }
          }
      },

      created () {
      },

      methods: {
        submitUpload() {
			this.$refs['form'].validate((valid) => {
				if (valid) {
                    let formData = new FormData()
                    formData.append('name', this.form.name)
                    formData.append('head', this.form.head)
                    formData.append('logo', this.form.logo)
                    http({
                        url: Api.storeBrand,
                        method: 'post',
                        data: formData
                    }).then(response => {
                        this.form.logo = {}
                        this.form.name = '' 
                        this.form.head = '' 
                        this.$refs.upload.clearFiles()
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })

                    }).catch(err => {
                        console.log(err)
                    })
				} else {
                    console.log('err')
				}
			});
        },

        cancleUpload() {
            this.$refs.upload.clearFiles()
            this.$refs['form'].resetFields();
        },

        addFile(file, fileList) {
            this.form.logo = file.raw;
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
    height: 100px;
}
</style>
