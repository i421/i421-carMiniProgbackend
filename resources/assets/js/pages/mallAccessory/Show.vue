<template>
    <div>
        <el-row>
            <el-form ref="form" :model="form" label-width="100px">
                <el-col :span="10" style="border: 1px #ccc solid; padding:20px">
                    <el-form-item label="头图" prop="avatar"
                        :rules="[
                            { required: true, message: '头图不能为空', trigger: 'blur' },
                        ]"
					>
                        <el-image
                            style="width: 100px; height: 100px"
                            lazy
                            :src="previewAvatarLogo"
                            :preview-src-list="[previewAvatarLogo]"
                            fit="fit">
                        </el-image>

                        <el-button size="small" style="margin-left: 10px" @click="updateAvatarFile" icon="el-icon-upload">上传</el-button>
                    </el-form-item>

                    <el-form-item label="标题" prop="name"
                        :rules="[
                            { required: true, message: '标题不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="规格" prop="size"
                        :rules="[
                            { required: true, message: '规格不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.size"></el-input>
                    </el-form-item>

                    <el-form-item label="积分价" prop="score_price"
                        :rules="[
                            { required: true, message: '积分价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.score_price"></el-input>
                    </el-form-item>

                    <el-form-item label="原价" prop="price"
                        :rules="[
                            { required: true, message: '原价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.price"></el-input>
                    </el-form-item>

                    <el-form-item label="分类" prop="mall_accessory_classify_id"
                        :rules="[
                            {required: true, message: '分类不能空', trigger: 'change'},
                        ]"
                    >
                        <el-select v-model="form.mall_accessory_classify_id" placeholder="请选择">
                            <el-option
                                v-for="mallAccessoryClassify in mallAccessoryClassifies"
                                :key="mallAccessoryClassify.id"
                                :label="mallAccessoryClassify.p_name + ' > ' +  mallAccessoryClassify.name"
                                :value="mallAccessoryClassify.id">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="轮播图" prop="carousel" >
                        <el-carousel>
                            <el-carousel-item v-for="item in carousels" :key="item">
                                <el-image
                                    :src="item"
                                    :preview-src-list="[item]"
                                    fit="fit">
                                </el-image>
                            </el-carousel-item>
                        </el-carousel>
                        <el-button size="small" style="margin-left: 10px" @click="updateCarouselFiles" icon="el-icon-upload">上传</el-button>
                    </el-form-item>
                </el-col>

                <el-col :span="12" :offset="1" style="border: 1px #ccc solid; padding:20px">

                    <el-form-item label="配件详情" prop="imgs">
                        <el-carousel>
                            <el-carousel-item v-for="item in imgs" :key="item">
                                <el-image
                                    :src="item"
                                    :preview-src-list="[item]"
                                    fit="fit">
                                </el-image>
                            </el-carousel-item>
                        </el-carousel>

                        <el-button size="small" style="margin-left: 10px" @click="updateImgsFiles" icon="el-icon-upload">上传</el-button>
                    </el-form-item>

                    <el-button type="primary" @click="addRow" size="small">添加配置项</el-button>

					<table class="table">
						<thead>
							<tr>
								<td><strong>配置项</strong></td>
								<td><strong>配置值(不同的值之间用英文逗号隔开)</strong></td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in form.detail">
								<td><input type="text" v-model="row.key"></td>
								<td><input type="text" style="min-width: 400px" v-model="row.value"></td>
								<td>
                                    <a v-on:click="removeElement(index);" style="cursor: pointer">移除配置项</a>
								</td>
							</tr>
						</tbody>
					</table>
                </el-col>
            </el-form>

            <el-col>
                <div class="submitButton">
                    <el-button
                        size="small"
                        type="primary"
                        @click="submitUpload">
                        保存
                    </el-button>
                    <el-button @click="back">返回列表</el-button>
                </div>
            </el-col>
        </el-row>

        <div>
          <el-dialog title="更新头图" :visible.sync="avatarDialogVisible">
              <div style="text-align: center; margin: 0 auto">
                    <el-upload
                        class="upload-demo"
                        ref="uploadAvatar"
                        drag
                        :onChange="addAvatarFile"
                        action=""
                        :limit="1"
                        :auto-upload="false">
                        <i class="el-icon-upload"></i>
                        <div slot="tip" class="el-upload__tip">只能上传一张jpg/png文件，且不超过500kb</div>
                    </el-upload>
              </div>

			  <span slot="footer" class="dialog-footer">
				<el-button @click="avatarDialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="avatarDialogVisible = false">确 定</el-button>
			  </span>
          </el-dialog>


          <el-dialog title="更新轮播图" :visible.sync="carouselDialogVisible">
              <div style="text-align: center; margin: 0 auto">
                <el-upload
                    class="upload-demo"
                    ref="uploadCarousel"
                    drag
                    action=""
                    :onChange="addCarouselFile"
                    :on-remove="removeCarouselFile"
                    multiple
                    :auto-upload="false"
                >
                    <i class="el-icon-upload"></i>
                    <div slot="tip" class="el-upload__tip">只能jpg/png文件</div>
                </el-upload>
              </div>

			  <span slot="footer" class="dialog-footer">
				<el-button @click="carouselDialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="carouselDialogVisible = false">确 定</el-button>
			  </span>
          </el-dialog>

          <el-dialog title="更新多图" :visible.sync="imgDialogVisible">
              <div style="text-align: center; margin: 0 auto">
                <el-upload
                    class="upload-demo"
                    ref="uploadImg"
                    drag
                    action=""
                    :onChange="addImgsFile"
                    :on-remove="removeImgsFile"
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
              mallAccessoryClassifies: [],
              previewAvatarLogo: '',
              avatarDialogVisible: false,
              previewCarouselLogo: '',
              previewImgLogo: '',
              carouselDialogVisible: false,
              imgDialogVisible: false,
              selected: [],
              carousels: [],
              imgs: [],
              form: {
                  name: '',
                  size: '',
                  avatar: '',
                  mall_accessory_classify_id: '',
                  price: '',
                  score_price: '',
                  detail: [],
                  count: '',
                  carousel: [],
                  imgs: [],
              }
          }
      },

      created () {
          this.fetchMallAccessory()
          this.fetchMallAccessoryClassify()

      },

      methods: {

        fetchMallAccessoryClassify() {
            http({
                url: Api.secondMallAccessoryClassifies,
            }).then(response => {
                this.mallAccessoryClassifies = response.data.data
            }).catch(err => {
                console.log(err)
            })
        },

        fetchMallAccessory() {
            http({
                url: Api.mallAccessory + this.$route.params.id,
            }).then(response => {
                this.form = response.data.data
                this.previewAvatarLogo = response.data.data.full_avatar;
                this.previewCarCarouselLogo = response.data.data.carousel;
                this.imgs = response.data.data.imgs;
                this.carousels = response.data.data.carousel
                this.form.imgs = []
                this.form.carousel = []
            }).catch(err => {
                console.log(err)
            })
        },

		addRow: function() {
			var elem = document.createElement('tr');
			this.form.detail.push({
				key: "",
				value: "",
			});
		},

		removeElement: function(index) {
			this.form.detail.splice(index, 1);
		},

		addModelRow: function() {
			var elem = document.createElement('tr');
			this.form.model.push({
				key: "",
				value: "",
			});
		},

		removeModelElement: function(index) {
			this.form.model.splice(index, 1);
		},

        submitUpload() {
			this.$refs['form'].validate((valid) => {
                if (valid) {
                    let formData = new FormData()
                    formData.append('name', this.form.name)
                    formData.append('size', this.form.size)
                    formData.append('mall_accessory_classify_id', this.form.mall_accessory_classify_id)
                    formData.append('price', this.form.price)
                    formData.append('score_price', this.form.score_price)
                    formData.append('count', this.form.count)
                    formData.append('detail', JSON.stringify(this.form.detail))

                    if (typeof(this.form.avatar) == 'object') {
                        console.log("object")
                        formData.append('avatar', this.form.avatar)
                    }

                    for (let i = 0; i < this.form.carousel.length; i++) {
                        console.log(this.form.carousel[i])
                        formData.append('carousel[]', this.form.carousel[i])
                    }

                    for (let i = 0; i < this.form.imgs.length; i++) {
                        console.log(this.form.imgs[i])
                        formData.append('imgs[]', this.form.imgs[i])
                    }

                    http({
                        url: Api.updateMallAccessory + this.$route.params.id,
                        method: 'post',
                        data: formData
                    }).then(response => {
                        this.$refs['form'].resetFields();
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })

                        this.$router.push({ name: 'mallaccessory' })

                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    console.log('err')
                }
			});
        },

        addAvatarFile(file, fileList) {
            this.form.avatar = file.raw
            this.previewAvatarLogo = URL.createObjectURL(file.raw);
        },

        addCarouselFile(file, fileList) {
            this.form.carousel.push(file.raw)
        },

        removeCarouselFile (file, fileList) {
            for(let i = 0; i < this.form.carousel.length; i++) {
                if (this.form.carousel[i].uid == file.uid) {
                    this.form.carousel.splice(i, 1)
                }
            }
        },

        addImgsFile(file, fileList) {
            this.form.imgs.push(file.raw)
        },

        removeImgsFile (file, fileList) {
            for(let i = 0; i < this.form.imgs.length; i++) {
                if (this.form.imgs[i].uid == file.uid) {
                    this.form.imgs.splice(i, 1)
                }
            }
        },

        back() {
            this.$router.push({ name: 'mallaccessory'})
        },

        updateSelect (index) {
            let obj = new Object()
            for (let i in this.selected) {
                obj[i] = this.selected[i]
            }
            this.form.attr= obj
        },

        //更新汽车头图
        updateAvatarFile() {
            this.avatarDialogVisible = true
        },

        //更新轮播图
        updateCarouselFiles() {
            this.carouselDialogVisible = true
        },

        //更新配件详情
        updateImgsFiles() {
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
