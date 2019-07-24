<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="100px" style="width:460px">

                    <el-form-item label="经销商名" prop="name"
                        :rules="[
                            { required: true, message: '名称不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="手机号" label-width="100px" prop="phone"
                        :rules="[
					        {type: 'number', message: '必须为数字'},
                        ]"
                    >
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>

                    <el-form-item label="地址" label-width="100px" prop="address">
                        <el-input v-model="form.address"></el-input>
                    </el-form-item>

                    <el-form-item label="详细地址" label-width="100px" prop="detail_address">
                        <el-input v-model="form.detail_address"></el-input>
                    </el-form-item>

                    <el-form-item label="经度" label-width="100px" prop="lat">
                        <el-input v-model="form.lat"></el-input>
                    </el-form-item>

                    <el-form-item label="纬度" label-width="100px" prop="lng">
                        <el-input v-model="form.lng"></el-input>
                    </el-form-item>

                    <el-form-item label="订单数" label-width="100px" prop="order_count">
                        <el-input v-model="form.order_count"></el-input>
                    </el-form-item>

                    <el-form-item label="门店图" label-width="100px">
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="previewShopLogo"
                            fit="fit">
                        </el-image>
                    </el-form-item>

                    <el-form-item label="更新门店图" label-width="100px">
                        <el-upload
                            class="upload-demo"
                            ref="uploadShop"
                            drag
                            :onChange="addShopFile"
                            action=""
                            :limit="1"
                            :auto-upload="false">
                            <i class="el-icon-upload"></i>
                            <div slot="tip" class="el-upload__tip">只能上传一张jpg/png文件，且不超过500kb</div>
                        </el-upload>
                    </el-form-item>


                    <el-form-item label="营业执照" label-width="100px">
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="previewLicenseLogo"
                            fit="fit">
                        </el-image>
                    </el-form-item>

                    <el-form-item label="更新营业执照" label-width="100px">
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
                        立即更新
                    </el-button>
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
                  address: '',
                  address_id: '',
                  detail_address: '',
                  lat: '',
                  lng: '',
                  license_url: {},
                  img_url: {},
              },
              previewShopLogo: '',
              previewLicenseLogo: '',
          }
      },

      created () {
          this.fetchShop();
      },

      methods: {

        fetchShop() {
          http({
              url: Api.showShop + this.$route.params.id,
          }).then(response => {
              this.form = response.data.data
              this.previewShopLogo = response.data.data.img_url
              this.previewLicenseLogo = response.data.data.license_url
          })
        },

        submitUpload() {
            let formData = new FormData()
            formData.append('name', this.form.name)
            formData.append('phone', this.form.phone)
            formData.append('lat', this.form.lat)
            formData.append('lng', this.form.lng)
            formData.append('address_id', this.form.address_id)
            formData.append('detail_address', this.form.detail_address)

            http({
                url: Api.updateShop + this.$route.params.id,
                method: 'post',
                data: formData
            }).then(response => {
                this.form.img_url = {}
                this.form.license_url = {}
                this.form.name = ''
                this.form.phone = ''
                this.form.lat = ''
                this.form.lng = ''
                this.form.address_id = ''
                this.form.detail_address = ''
                this.$refs.upload.clearFiles()
                this.fetchShop()
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })
            }).catch(err => {
                console.log(err)
            })
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
      }
  }
</script>

<style>
.upload-demo .el-upload__input {
	margin-top: -30px;
}
.upload-demo {
    margin-bottom: 10px;
    max-height: 320px;
}
.submitButton {
    z-index: 999;
}
.el-upload-list {
    height: 50px;
}
</style>
