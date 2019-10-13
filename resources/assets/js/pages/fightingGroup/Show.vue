<template>
    <div>
        <el-row>
            <el-col>
                <el-form v-if="groupForm.group_type == 1" ref="groupForm" :model="groupForm" label-width="100px">
                    <el-form-item label="起止时间" prop="time_range"
                        :rules="[
                            { required: true, message: '起止时间不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-date-picker
                            v-model="groupForm.time_range"
                            type="datetimerange"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期">
                        </el-date-picker>
                    </el-form-item>

                    <el-form-item label="拼团价" prop="group_price"
                        :rules="[
                            { required: true, message: '拼团价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="groupForm.group_price" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">更新</el-button>
                        <el-button @click="back">返回列表</el-button>
                    </el-form-item>

                </el-form>

                <el-form v-else ref="groupForm" :model="groupForm" label-width="100px">
                    <el-form-item label="数量" prop="total_num"
                        :rules="[
                            { required: true, message: '数量不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="groupForm.total_num" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="拼团价" prop="group_price"
                        :rules="[
                            { required: true, message: '拼团价不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="groupForm.group_price" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="优惠设置" prop="off"
                        :rules="[
                            { required: true, message: '优惠设置不能为空', trigger: 'blur' },
                            { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model.number="groupForm.off" width="60px"></el-input>
                    </el-form-item>

                    <el-form-item label="截止时间" prop="time_range"
                        :rules="[
                            { required: true, message: '时间不能为空', trigger: 'blur' },
                        ]"
                    >
                        <el-date-picker
                            v-model="groupForm.time_range"
                            type="datetimerange"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期">
                        </el-date-picker>
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
            groupForm: {
                id: '',
                total_num: '',
                type: '',
                time_range: '',
                group_price: '',
                off: '',
            },
          }
      },

      created () {
          this.fetchFightingGroup();
      },

      methods: {

        fetchFightingGroup() {
          http({
              url: Api.showFightingGroup + this.$route.params.id,
          }).then(response => {
              this.groupForm = response.data.data
              this.groupForm.time_range = [response.data.data.start_time, response.data.data.end_time]
          })
        },

        onSubmit() {
            http({
                url: Api.updateFightingGroup + this.$route.params.id,
                method: 'put',
                data: this.groupForm
            }).then(response => {
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })
                this.$router.push({ name: 'fightingGroup'})
            }).catch(err => {
                console.log(err)
            })
        },

        back() {
            this.$router.push({ name: 'fightingGroup'})
        },
      }
  }
</script>

<style>
.submitButton {
    z-index: 999;
}
</style>
