<template>
    <div>
        <el-row>
            <el-form ref="form" :model="form" label-width="100px">
                <el-col :span="10" style="border: 1px #ccc solid; padding:20px">
                    <el-tag type="primary">必选参数</el-tag>

                    <el-form-item label="头图" prop="avatar"
                        :rules="[
                            { required: true, message: '头图不能为空', trigger: 'blur' },
                        ]"
					>
                        <el-upload
                            class="upload-demo"
                            ref="uploadCarAvatar"
                            drag
                            :onChange="addCarAvatarFile"
                            :on-remove="removeCarAvatarFile"
                            action=""
                            :limit="1"
                            :auto-upload="false">
                            <i class="el-icon-upload"></i>
                            <div slot="tip" class="el-upload__tip">只能上传1张jpg/png文件，且不超过500kb</div>
                        </el-upload>
                    </el-form-item>

                    <el-form-item label="标题" prop="name"
                        :rules="[
                            { required: true, message: '汽车标题不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>

                    <el-form-item label="品牌" prop="brand_id"
                        :rules="[
                            {required: true, message: '品牌不能空', trigger: 'change'},
                        ]"
                    >
                        <el-select v-model="form.brand_id" placeholder="请选择">
                            <el-option
                                v-for="brand in brands"
                                :key="brand.id"
                                :label="brand.name"
                                :value="brand.id">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="裸车价" prop="car_price"
                        :rules="[
                            { required: true, message: '裸车价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.car_price"></el-input>
                    </el-form-item>

                    <el-form-item label="指导价" prop="guide_price"
                        :rules="[
                            { required: true, message: '指导价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.guide_price"></el-input>
                    </el-form-item>

                    <el-form-item label="落地价" prop="final_price"
                        :rules="[
                            { required: true, message: '裸车价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.final_price"></el-input>
                    </el-form-item>

                    <el-form-item label="首付" prop="down_payment"
                        :rules="[
                            { required: true, message: '首付不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.down_payment"></el-input>
                    </el-form-item>

                    <el-form-item label="24分期" prop="staging24"
                        :rules="[
                            { required: true, message: '分期价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.staging24"></el-input>
                    </el-form-item>

                    <el-form-item label="36分期" prop="staging36"
                        :rules="[
                            { required: true, message: '分期价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.staging36"></el-input>
                    </el-form-item>

                    <el-form-item label="48分期" prop="staging48"
                        :rules="[
                            { required: true, message: '分期价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.staging48"></el-input>
                    </el-form-item>

                    <el-form-item label="综合排序" prop="height"
                        :rules="[
                            { required: true, message: '不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.height"></el-input>
                    </el-form-item>

                    <el-form-item label="轮播图" prop="carousel"
                        :rules="[
                            { required: true, message: '轮播图不能为空', trigger: 'blur' },
						]"
					>
                        <el-upload
                            class="upload-demo"
                            ref="uploadCarousel"
                            drag
                            action=""
                            :onChange="addCarCarouselFile"
                            :on-remove="removeCarCarouselFile"
                            multiple
							:file-list="form.carousel"
                            :auto-upload="false"
                        >
                            <i class="el-icon-upload"></i>
                            <div slot="tip" class="el-upload__tip">只能上传1张jpg/png文件，且不超过500kb</div>
                        </el-upload>
                    </el-form-item>
                </el-col>

                <el-col :span="12" :offset="1" style="border: 1px #ccc solid; padding:20px">
                    <el-tag type="primary">可选参数</el-tag>

                    <el-form-item :label="index" v-for="(item, index, key) in tags" :key="key">
                        <el-radio-group v-model="selected[index]" size="small" @change="updateSelect(index)">
                            <el-radio-button
                                :label="v.id"
                                v-for="(v, i, k) in item"
                                :key="k"
                            >
                                {{ v.name }}
                            </el-radio-button>
                        </el-radio-group>
                    </el-form-item>

                    <el-button type="primary" @click="addModelRow" size="small">车型列表</el-button>

					<table class="table">
						<thead>
							<tr>
                                <td><strong>车型</strong></td>
								<td><strong>价格</strong></td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in form.model">
								<td><input type="text" v-model="row.key"></td>
								<td><input type="text" v-model="row.value"></td>
								<td>
                                    <a v-on:click="removeModelElement(index);" style="cursor: pointer">移除车型</a>
								</td>
							</tr>
						</tbody>
					</table>

                    <el-button type="primary" @click="addRow" size="small">添加配置</el-button>

					<table class="table">
						<thead>
							<tr>
								<td><strong>配置项</strong></td>
								<td><strong>配置值</strong></td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in form.customize">
								<td><input type="text" v-model="row.key"></td>
								<td><input type="text" v-model="row.value"></td>
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
              brands: [],
              tags: [],
              selected: [],
              form: {
                  name: '',
                  avatar: '',
                  guide_price: '',
                  final_price: '',
                  car_price: '',
                  height: '',
                  selected: [],
                  brand_id: '',
                  customize: [],
                  model: [],
                  carousel: [],
                  down_payment: 0,
                  staging24: 0,
                  staging36: 0,
                  staging48: 0,
              }
          }
      },

      created () {
          this.fetchBrand()
          this.fetchTag()
      },

      methods: {

        fetchBrand() {
            http({
                url: Api.brands,
            }).then(response => {
                this.brands = response.data.data
            }).catch(err => {
                console.log(err)
            })
        },

        fetchTag() {
            http({
                url: Api.classifyTag,
            }).then(response => {
                this.tags = response.data.data
            }).catch(err => {
                console.log(err)
            })
        },

		addRow: function() {
			var elem = document.createElement('tr');
			this.form.customize.push({
				key: "",
				value: "",
			});
		},

		removeElement: function(index) {
			this.form.customize.splice(index, 1);
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
                    formData.append('brand_id', this.form.brand_id)
                    formData.append('avatar', this.form.avatar)
                    formData.append('down_payment', this.form.down_payment)
                    formData.append('guide_price', this.form.guide_price)
                    formData.append('car_price', this.form.car_price)
                    formData.append('height', this.form.height)
                    formData.append('final_price', this.form.final_price)
                    formData.append('customize', JSON.stringify(this.form.customize))
                    formData.append('model', JSON.stringify(this.form.model))
                    formData.append('attr', JSON.stringify(this.form.selected))
                    formData.append('staging48', this.staging48)
                    formData.append('staging24', this.staging24)
                    formData.append('staging36', this.staging36)

                    for (let i = 0; i < this.form.carousel.length; i++) {
                        formData.append('carousel[]', this.form.carousel[i])
                    }
                    console.log(formData)

                    http({
                        url: Api.storeCar,
                        method: 'post',
                        data: formData
                    }).then(response => {
                        this.$refs['form'].resetFields();
                        this.$refs.uploadCarAvatar.clearFiles()
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })

                        this.$router.push({ name: 'car' })

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
            this.$refs.uploadCarAvatar.clearFiles()
        },

        addCarAvatarFile(file, fileList) {
            this.form.avatar = file.raw
        },

        removeCarAvatarFile(file, fileList) {
            this.form.avatar = {}
        },

        addCarCarouselFile(file, fileList) {
            this.form.carousel.push(file.raw)
        },

        removeCarCarouselFile (file, fileList) {
            for(let i = 0; i < this.form.carousel.length; i++) {
                if (this.form.carousel[i].uid == file.uid) {
                    this.form.carousel.splice(i, 1)
                }
            }
        },

        back() {
            this.$router.push({ name: 'car'})
        },

        updateSelect (index) {
            let obj = new Object()
            for (let i in this.selected) {
                obj[i] = this.selected[i]
            }
            this.form.selected= obj
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
    margin: 0 auto;
}
.el-upload-list {
    height: 50px;
}
</style>
