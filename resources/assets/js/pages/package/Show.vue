<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="100px">
                    <el-form-item label="套餐名称" prop="name"
                        :rules="[
                            { required: true, message: '套餐不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.name" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="保养次数" prop="maintenance_count"
                        :rules="[
                            { required: true, message: '保养次数不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.maintenance_count" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="价格" prop="price"
                        :rules="[
                            { required: true, message: '价格不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="form.price" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="汽车档位(上限)" prop="max_price"
                        :rules="[
                            { required: true, message: '上限价格不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.max_price" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="汽车档位(下限)" prop="min_price"
                        :rules="[
                            { required: true, message: '下限价格不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-input v-model="form.min_price" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="描述" prop="desc">
                        <el-input v-model="form.desc" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">更新</el-button>
                        <el-button @click="back">返回列表</el-button>
                    </el-form-item>
                </el-form>
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
            form: {
                id: '',
                name: '',
                price: '',
                maintenance_count: '',
                min_price: '',
                max_price: '',
                desc: '',
            },
          }
      },

      created () {
          this.fetchPackage();
      },

      methods: {

        fetchPackage() {
          http({
              url: Api.showPackage + this.$route.params.id,
          }).then(response => {
              this.form = response.data.data
          })
        },

        onSubmit() {
            http({
                url: Api.updatePackage + this.$route.params.id,
                method: 'post',
                data: this.form
            }).then(response => {
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })
                this.$router.push({ name: 'package'})
            }).catch(err => {
                console.log(err)
            })
        },

        back() {
            this.$router.push({ name: 'package'})
        },
      }
  }
</script>

<style>
.submitButton {
    z-index: 999;
}
</style>
