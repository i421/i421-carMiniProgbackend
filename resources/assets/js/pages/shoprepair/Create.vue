<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="120px" style="width:480px">

                    <el-form-item label="维修点名称" prop="name"
                        :rules="[
                            { required: true, message: '名称不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="所属经销商" prop="shop_id"
                        :rules="[
                            {required: true, message: '经销商不能空', trigger: 'change'},
                        ]"
                    >
                        <el-select v-model="form.shop_id" placeholder="请选择">
                            <el-option
                                v-for="shop in shops"
                                :key="shop.id"
                                :label="shop.name"
                                :value="shop.id">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="详细地址" prop="address"
                        :rules="[
                            { required: true, message: '地址不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.address"></el-input>
                    </el-form-item>

                    <el-form-item label="手机号" prop="phone"
                        :rules="[
                            { required: true, message: '手机号不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>

                    <el-form-item label="经度" prop="lng"
                        :rules="[
                            { required: true, message: '经度不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.lng"></el-input>
                    </el-form-item>

                    <el-form-item label="维度" prop="lat"
                        :rules="[
                            { required: true, message: '维度不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.lat"></el-input>
                    </el-form-item>

                    <el-form-item label="门店图" prop="img"
                        :rules="[
                            { required: true, message: '门店图不能为空', trigger: 'blur' },
                        ]"
					>
                        <el-upload
                            class="upload-demo"
                            ref="uploadShop"
                            drag
                            :onChange="addShopRepairFile"
                            action=""
                            :limit="1"
                            :auto-upload="false">
                            <i class="el-icon-upload"></i>
                            <div slot="tip" class="el-upload__tip">只能上传1张jpg/png文件，且不超过500kb</div>
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
              shops: [],
              form: {
                  name: '',
                  phone: '',
                  shop_id: '',
                  lat: '',
                  lng: '',
                  address: '',
                  img: [],
              }
          }
      },

      created () {
          this.fetchShop()
      },

      methods: {

        fetchShop() {
            http({
                url: Api.userShop,
            }).then(response => {
                this.shops = response.data.data
            }).catch(err => {
                console.log(err)
            })
        },

        submitUpload() {
			this.$refs['form'].validate((valid) => {
				if (valid) {
					let formData = new FormData()
					formData.append('name', this.form.name)
					formData.append('phone', this.form.phone)
					formData.append('address', this.form.address)
					formData.append('shop_id', this.form.shop_id)
					formData.append('lat', this.form.lat)
					formData.append('lng', this.form.lng)
					formData.append('img', this.form.img)

					http({
						url: Api.storeShopRepair,
						method: 'post',
						data: formData
					}).then(response => {
						this.$refs['form'].resetFields();
						this.$refs.uploadShop.clearFiles()
						this.$notify.success({
							'title': "提示",
							'message': response.data.msg
						})

						this.$router.push({ name: 'shoprepair' })


					}).catch(err => {
						console.log(err)
					})
				} else {
                    console.log('err')
				}
			});
        },

        resetUpload() {
            this.$refs['form'].resetFields();
            this.$refs.uploadShop.clearFiles()
        },

        addShopRepairFile(file, fileList) {
            this.form.img = file.raw;
        },

        back() {
            this.$router.push({ name: 'shop'})
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
