<template>
    <div>
	  <div style="margin-top: 20px" v-for="(item,index,key) in tags" :key="key">
		  <p>{{ index}}</p>
		<el-radio-group v-model="selected[index]" size="small" @change="test">
            <el-radio-button :label="v.id" v-for="(v, i, k) in item" :key="k">{{ v.name }}</el-radio-button>
		</el-radio-group>
	  </div>

      <el-form ref="form" :model="form" label-width="80px" style="width:440px">
            <el-form-item label="测试图片" prop="id_card_front_path">
                <el-upload
                    class="upload-demo"
                    ref="upload"
                    drag
                    :onChange="addFrontFile"
                    action=""
                    :limit="1"
                    :auto-upload="false">
                    <i class="el-icon-upload"></i>
                    <div slot="tip" class="el-upload__tip">只能上传一张jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>

            <el-form-item label="测试图片" prop="id_card_back_path">
                <el-upload
                    class="upload-demo"
                    ref="upload"
                    drag
                    :onChange="addBackFile"
                    action=""
                    :limit="1"
                    :auto-upload="false">
                    <i class="el-icon-upload"></i>
                    <div slot="tip" class="el-upload__tip">只能上传一张jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>
      </el-form>
        <el-button style="margin-left: 50px;"
            size="small"
            type="primary"
            @click="submitUpload">
            立即创建
        </el-button>
    </div>
</template>

<script>
  import { http } from './../utils/fetch'
  import Api from './../config'
  export default {
	  data() {
		return {
			tags: [],
			selected: [],
            form: {
                openid: '',
                id_card_front_path: '',
                id_card_back_path: '',
            }
        }
      },

	  created() {
		this.fetchTag();
	  },

      methods: {
        //获取角色列表
        fetchTag () {
            http({
                url: Api.tag,
            }).then(response => {
				this.tags = response.data.data
            })
        },

		test() {
			console.log(this.selected)
		},

        submitUpload() {
            let formData = new FormData()
            formData.append('openid', "asdfasdf")
            formData.append('id_card_front_path', this.form.id_card_front_path)
            formData.append('id_card_back_path', this.form.id_card_back_path)
            http({
                url: 'api/v1/customer/upload/idcard',
                method: 'post',
                data: formData
            }).then(response => {
                this.$notify.success({
                    'title': "提示",
                    'message': response.data.msg
                })

            }).catch(err => {
                console.log(err)
            })
        },
        addBackFile(file, fileList) {
            this.form.id_card_back_path = file.raw;
        },
        addFrontFile(file, fileList) {
            this.form.id_card_front_path = file.raw;
        },
      }
  }
</script>

<style>
.el-upload-list {
    height: 100px;
}
</style>
