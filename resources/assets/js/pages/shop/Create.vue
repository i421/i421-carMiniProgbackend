<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="80px" style="width:440px">

                    <el-form-item label="经销商名" prop="name"
                        :rules="[
                            { required: true, message: '名称不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="手机号" prop="phone"
                        :rules="[
                            { required: true, message: '手机号不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>

                    <el-form-item label="地址">
                        <v-distpicker @province="selectProvince" @city="selectCity" @area="selectArea"></v-distpicker>
                    </el-form-item>

                    <el-form-item label="详细地址" prop="detail_address"
                        :rules="[
                            { required: true, message: '详细地址不能为空', trigger: 'blur' },
					        {type: 'string', message: '字符串'},
                        ]"
                    >
                        <el-input v-model="form.detail_address"></el-input>
                    </el-form-item>

                    <el-form-item label="经度" prop="lat"
                        :rules="[
                            { required: true, message: '经度不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.lat"></el-input>
                    </el-form-item>

                    <el-form-item label="纬度" prop="lng"
                        :rules="[
                            { required: true, message: '纬度不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.lng"></el-input>
                    </el-form-item>

                    <el-form-item label="门店图">
                        <el-upload
                            class="upload-demo"
                            ref="uploadShop"
                            drag
                            :onChange="addShopFile"
                            action=""
                            :limit="1"
                            :auto-upload="false">
                            <i class="el-icon-upload"></i>
                            <div slot="tip" class="el-upload__tip">只能上传1张jpg/png文件，且不超过500kb</div>
                        </el-upload>
                    </el-form-item>

                    <el-form-item label="营业执照">
                        <el-upload
                            class="upload-demo"
                            ref="uploadLicense"
                            drag
                            :onChange="addLicenseFile"
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
                    <el-button @click="resetUpload">重置</el-button>
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
                  phone: '',
                  lat: '',
                  lng: '',
                  detail_address: '',
                  province: '',
                  city: '',
                  area: '',
                  img_url: [],
                  license_url: {},
              }
          }
      },

      created () {
      },

      methods: {
        submitUpload() {
            let formData = new FormData()
            formData.append('name', this.form.name)
            formData.append('phone', this.form.phone)
            formData.append('lat', this.form.lat)
            formData.append('lng', this.form.lng)
            formData.append('detail_address', this.form.detail_address)
            formData.append('province', JSON.stringify(this.form.province))
            formData.append('city', JSON.stringify(this.form.city))
            formData.append('area', JSON.stringify(this.form.area))
            formData.append('img_url', this.form.img_url)
            formData.append('license_url', this.form.license_url)

            http({
                url: Api.storeShop,
                method: 'post',
                data: formData
            }).then(response => {
                //this.$refs[form].resetFields();
                this.$refs.uploadShop.clearFiles()
                this.$refs.uploadLicense.clearFiles()
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })

                this.$router.push({ name: 'shop' })


            }).catch(err => {
                console.log(err)
            })
        },

        resetUpload() {
            this.$refs[form].resetFields();
            this.$refs.uploadShop.clearFiles()
            this.$refs.uploadLicense.clearFiles()
        },

        addShopFile(file, fileList) {
            this.form.img_url = file.raw;
        },

        addLicenseFile(file, fileList) {
            this.form.license_url = file.raw;
        },

        back() {
            this.$router.push({ name: 'shop'})
        },

        selectProvince(value) {
            this.form.province = value
        },
        selectCity(value) {
            this.form.city = value
        },
        selectArea(value) {
            this.form.area = value
        }
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
}
.el-upload-list {
    height: 50px;
}
</style>
