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
                            { required: true, message: '手机号不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>

                    <el-form-item label="地址" prop="province"
                        :rules="[
                            { required: true, message: '地址不能为空', trigger: 'blur' },
                        ]"
					>
                        <v-distpicker
                            @province="selectProvince"
                            @city="selectCity"
                            @area="selectArea"
                            :province="currentProvince"
                            :city="currentCity"
                            :area="currentArea"
                        >
                        </v-distpicker>
                    </el-form-item>

                    <el-form-item label="详细地址" label-width="100px" prop="detail_address"
                        :rules="[
                            { required: true, message: '详细地址不能为空', trigger: 'blur' },
					        {type: 'string', message: '字符串'},
                        ]"
                    >
                        <el-input v-model="form.detail_address"></el-input>
                    </el-form-item>

                    <el-form-item label="经度" label-width="100px" prop="lat"
                        :rules="[
                            { required: true, message: '经度不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.lat"></el-input>
                    </el-form-item>

                    <el-form-item label="纬度" label-width="100px" prop="lng"
                        :rules="[
                            { required: true, message: '纬度不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.lng"></el-input>
                    </el-form-item>

                    <el-form-item label="订单数" label-width="100px" prop="order_count">
                        <el-input v-model="form.order_count" disabled></el-input>
                    </el-form-item>

                    <el-form-item label="门店图" prop="img_url"
                        :rules="[
                            { required: true, message: '门店图不能为空', trigger: 'blur' },
                        ]"
					>
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="previewShopLogo"
                            :preview-src-list="[previewShopLogo]"
                            fit="fit">
                        </el-image>
                        <el-button size="small" style="margin-left: 10px" @click="updateShopLogo" icon="el-icon-upload">上传</el-button>
                    </el-form-item>

                    <el-form-item label="营业执照" prop="license_url"
                        :rules="[
                            { required: true, message: '营业执照不能为空', trigger: 'blur' },
                        ]"
					>
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="previewLicenseLogo"
                            :preview-src-list="[previewLicenseLogo]"
                            fit="fit">
                        </el-image>
                        <el-button size="small" @click="updateLicenseLogo" icon="el-icon-upload">上传</el-button>
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
          <el-dialog title="更新门店图" :visible.sync="imgDialogVisible">
              <div style="text-align: center; margin: 0 auto">
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
              </div>
          </el-dialog>
          <el-dialog title="更新营业执照" :visible.sync="licenseDialogVisible">
              <div style="text-align: center; margin: 0 auto">
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
              imgDialogVisible: false,
              licenseDialogVisible: false,
              currentProvince: '',
              currentCity: '',
              currentArea: '',
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
              this.currentProvince = this.form.province.value
              this.currentCity = this.form.city.value
              this.currentArea = this.form.area.value
              this.previewShopLogo = response.data.data.img_url
              this.previewLicenseLogo = response.data.data.license_url
          })
        },

        submitUpload() {
            let formData = new FormData()
            formData.append('name', this.form.name)
            formData.append('phone', this.form.phone)
            formData.append('province', JSON.stringify(this.form.province))
            formData.append('city', JSON.stringify(this.form.city))
            formData.append('area', JSON.stringify(this.form.area))
            formData.append('lat', this.form.lat)
            formData.append('lng', this.form.lng)
            formData.append('detail_address', this.form.detail_address)

            if (typeof(this.form.img_url) == 'object') {
                formData.append('img_url', this.form.img_url)
            }

            if (typeof(this.form.license_url) == 'object') {
                formData.append('license_url', this.form.license_url)
            }

            http({
                url: Api.updateShop + this.$route.params.id,
                method: 'post',
                data: formData
            }).then(response => {
                this.fetchShop()
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })
                this.$router.push({ name: 'shop' })
            }).catch(err => {
                console.log(err)
            })
        },

        addShopFile(file, fileList) {
            this.form.img_url = file.raw;
            this.previewShopLogo = URL.createObjectURL(file.raw);
            this.imgDialogVisible = false
        },

        addLicenseFile(file, fileList) {
            this.form.license_url = file.raw;
            this.previewLicenseLogo = URL.createObjectURL(file.raw);
            this.licenseDialogVisible = false
        },

        back() {
            this.$router.push({ name: 'shop'})
        },

        //更新门店图
        updateShopLogo() {
            this.imgDialogVisible = true
        },

        //更新营业执照
        updateLicenseLogo() {
            this.licenseDialogVisible = true
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
