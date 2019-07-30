<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="80px" style="width:440px">

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

					<el-button type="primary" @click="addRow">Add row</el-button>

					<table class="table">
						<thead>
							<tr>
								<td><strong>配置项</strong></td>
								<td><strong>配置值</strong></td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in form.info">

								<td><input type="text" v-model="row.key"></td>
								<td><input type="text" v-model="row.value"></td>
								<td>
									<a v-on:click="removeElement(index);" style="cursor: pointer">Remove</a>
								</td>
							</tr>
						</tbody>
					</table>

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
              brands: [],
              form: {
                  name: '',
                  avatar: '',
                  guide_price: '',
                  final_price: '',
                  car_price: '',
                  brand_id: '',
				  info: [],
              }
          }
      },

      created () {
          this.fetchBrand()
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

		addRow: function() {
			var elem = document.createElement('tr');
			this.form.info.push({
				key: "",
				value: "",
			});
		},

		removeElement: function(index) {
			this.form.info.splice(index, 1);
		},

        submitUpload() {
			this.$refs['form'].validate((valid) => {
				if (valid) {
					let formData = new FormData()
					formData.append('name', this.form.name)
					formData.append('avatar', this.form.avatar)
					formData.append('guide_price', this.form.guide_price)
					formData.append('car_price', this.form.car_price)
					formData.append('final_price', this.form.final_price)

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
            this.form.avatar = file.raw;
        },

        back() {
            this.$router.push({ name: 'car'})
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
}
.el-upload-list {
    height: 50px;
}
</style>
