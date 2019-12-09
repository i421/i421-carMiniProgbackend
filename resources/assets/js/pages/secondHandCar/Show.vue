<template>
    <div>
        <el-row>
            <el-form ref="form" :model="form" label-width="100px">
                <el-col :span="24" style="max-width: 500px; padding:20px">

                    <el-form-item label="经销商" prop="shop_id"
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

                    <el-form-item label="汽车名称" prop="name"
                        :rules="[
                            { required: true, message: '汽车标题不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="车型" prop="type"
                        :rules="[
                            { required: true, message: '车型不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.type"></el-input>
                    </el-form-item>

                    <el-form-item label="内容" prop="desc"
                        :rules="[
                            { required: true, message: '内容', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.desc"></el-input>
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

                    <el-form-item label="详细地址" prop="address"
                        :rules="[
                            { required: true, message: '详细地址不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.address"></el-input>
                    </el-form-item>

                    <el-form-item label="汽车图" prop="imgs">
                        <el-carousel>
                            <el-carousel-item v-for="item in imgs" :key="item">
                                <el-image
                                    :src="item"
                                    :preview-src-list="[item]"
                                    fit="fit">
                                </el-image>
                            </el-carousel-item>
                        </el-carousel>

                        <el-button size="small" style="margin-left: 10px" @click="updateImgFiles" icon="el-icon-upload">上传</el-button>
                    </el-form-item>

                    <el-form-item label="下架时间" prop="end_time"
                        :rules="[
                            { required: true, message: '下架时间不能为空', trigger: 'blur' },
						]"
					>
						<el-date-picker
						  v-model="form.end_time"
						  type="datetime"
						  placeholder="选择日期"
						  format="yyyy-MM-dd HH:mm:ss"
						  value-format="yyyy-MM-dd HH:mm:ss">
						</el-date-picker>
                    </el-form-item>

                </el-col>
            </el-form>

            <el-col>
                <div class="submitButton">
                    <el-button
                        size="small"
                        type="primary"
                        @click="submitUpload">
                        立即创建
                    </el-button>
                    <el-button @click="back">返回列表</el-button>
                </div>
            </el-col>

        </el-row>

        <div>
          <el-dialog title="更新汽车图" :visible.sync="imgDialogVisible">
              <div style="text-align: center; margin: 0 auto">
                <el-upload
                    class="upload-demo"
                    ref="uploadImg"
                    drag
                    action=""
                    :onChange="addImgFile"
                    :on-remove="removeImgFile"
                    multiple
                    :auto-upload="false"
                >
                    <i class="el-icon-upload"></i>
                    <div slot="tip" class="el-upload__tip">只能jpg/png文件</div>
                </el-upload>
              </div>

			  <span slot="footer" class="dialog-footer">
				<el-button @click="imgDialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="imgDialogVisible = false">确 定</el-button>
			  </span>
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
              previewImgLogo: '',
              imgDialogVisible: false,
              imgs: [],
              shops: [],
              form: {
                  name: '',
                  type: '',
                  shop_id: '',
                  desc: '',
                  phone: '',
                  lat: '',
                  lng: "",
                  address: '',
                  end_time: '',
                  img: [],
              }
          }
      },

      created () {
          this.fetchSecondHandCar()
          this.fetchShop()
      },

      methods: {

        fetchSecondHandCar() {
            http({
                url: Api.showSecondHandCar + this.$route.params.id,
            }).then(response => {
                this.form = response.data.data
                this.imgs = response.data.data.img
                this.form.img = []
            }).catch(err => {
                console.log(err)
            })
        },

        fetchShop() {
            http({
                url: Api.shops,
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
                    formData.append('shop_id', this.form.shop_id)
                    formData.append('type', this.form.type)
                    formData.append('desc', this.form.desc)
                    formData.append('phone', this.form.phone)
                    formData.append('lat', this.form.lat)
                    formData.append('lng', this.form.lng)
                    formData.append('end_time', this.form.end_time)
                    formData.append('address', this.form.address)

                    for (let i = 0; i < this.form.img.length; i++) {
                        formData.append('img[]', this.form.img[i])
                    }

                    http({
                        url: Api.updateSecondHandCar + this.$route.params.id,
                        method: 'post',
                        data: formData
                    }).then(response => {
                        this.$refs['form'].resetFields();
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })

                        this.$router.push({ name: 'secondHandCarList' })

                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    console.log('err')
                }
			});
        },

        addImgFile(file, fileList) {
            this.form.img.push(file.raw)
        },

        removeImgFile (file, fileList) {
            for(let i = 0; i < this.form.img.length; i++) {
                if (this.form.img[i].uid == file.uid) {
                    this.form.img.splice(i, 1)
                }
            }
        },

        back() {
            this.$router.push({ name: 'secondHandCarList'})
        },

        //更新轮播图
        updateImgFiles() {
            this.imgDialogVisible = true
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
.el-dialog__body .upload-demo {
    height: 500px;
}
</style>
