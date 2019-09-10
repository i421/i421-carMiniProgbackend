<template>
    <div>
        <el-row>
            <el-form ref="form" :model="form" label-width="120px" style="width:500px">
                <el-form-item label="跳转类型" prop="type"
                    :rules="[
                        { required: true, message: '跳转类型不能为空', trigger: 'blur' },
                    ]"
                >
                    <el-select v-model="form.type" placeholder="跳转类型" class="table-search">
                        <el-option label="车辆详情" value="1"></el-option>
                        <el-option label="三方网址" value="2"></el-option>
                        <el-option label="拼团广告位" value="3"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="链接/汽车ID" prop="link"
                    :rules="[
                        { required: true, message: '链接不能为空', trigger: 'blur' },
                    ]"
                >
                    <el-input v-model="form.link"></el-input>
                </el-form-item>

                <el-form-item label="系统轮播图" prop="carousel">
                    <el-image
                        style="width: 200px; height: 200px"
                        :src="previewLogo"
                        :preview-src-list="[previewLogo]"
                        lazy
                        fit="fit">
                    </el-image>
                    <el-button size="small" @click="updateCarouselLogo" icon="el-icon-upload">上传</el-button>
                </el-form-item>

            </el-form>

            <div class="submitButton">
                <el-button
                    size="small"
                    type="primary"
                    @click="submitUpload">
                    更新
                </el-button>
                <el-button @click="back">返回列表</el-button>
            </div>

        </el-row>

        <div>
          <el-dialog title="更新轮播图" :visible.sync="imgDialogVisible">
              <div style="text-align: center; margin: 0 auto">
                    <el-upload
                        class="upload-demo"
                        ref="uploadCarousel"
                        drag
                        action=""
                        :limit="1"
                        :onChange="addCarouselFile"
                        :auto-upload="false"
                    >
                        <i class="el-icon-upload"></i>
                        <div slot="tip" class="el-upload__tip">只能上传1张jpg/png文件</div>
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
              previewLogo: '',
              imgDialogVisible: false,
              form: {
                  carousel: '',
                  type: '',
                  link: '',
              }
          }
      },

      created () {
          this.fetchCarousel()
      },

      methods: {

        fetchCarousel() {
            http({
                url: Api.settingShowCarousel + this.$route.params.id,
                method: 'get',
            }).then(response => {
                this.form = response.data.data
                this.previewLogo = response.data.data.path
            }).catch(err => {
                console.log(err)
            })
        },

        //更新轮播图
        updateCarouselLogo () {
            this.imgDialogVisible = true
        },

        submitUpload() {
			this.$refs['form'].validate((valid) => {
                if (valid) {
                    let formData = new FormData()

                    if (typeof(this.form.carousel) == 'object') {
                        formData.append('carousel', this.form.carousel)
                    } else {
                        formData.append('carousel', this.previewLogo)
                    }
                    formData.append('type', this.form.type)
                    formData.append('link', this.form.link)
                    http({
                        url: Api.settingUpdateCarousel + this.$route.params.id,
                        method: 'post',
                        data: formData
                    }).then(response => {
                        this.$refs['form'].resetFields();
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })

                        this.$router.push({ name: 'setting' })

                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    console.log('err')
                }
			});
        },

        addCarouselFile(file, fileList) {
            this.form.carousel = file.raw
        },

        back() {
            this.$router.push({ name: 'setting'})
        },

        addCarouselFile(file, fileList) {
            this.form.carousel = file.raw;
            this.previewLogo = URL.createObjectURL(file.raw);
            this.imgDialogVisible = false
        },

      }
  }
</script>

<style>
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
