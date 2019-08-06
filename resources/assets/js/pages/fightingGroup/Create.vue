<template>
    <div>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="80px" style="width:100%">

                    <el-form-item label="标题" prop="title"
                        :rules="[
                            { required: true, message: '标题不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.title"></el-input>
                    </el-form-item>

                    <el-form-item label="副标题" prop="sub_title"
                        :rules="[
                            { required: true, message: '副标题不能为空', trigger: 'blur' },
                            { type: 'string', message: '必须为字符串', trigger: ['blur', 'change'] },
                        ]"
                    >
                        <el-input v-model="form.sub_title"></el-input>
                    </el-form-item>

					<el-form-item label="图文消息" prop="content"
                        :rules="[
                            { required: true, message: '内容不能为空', trigger: 'blur' },
                        ]"
                    >
						<quill-editor ref="formEditor"
							v-model="form.content"
							:options="editorOption"
							@blur="onEditorBlur($event)"
							@focus="onEditorFocus($event)"
							@ready="onEditorReady($event)">
						</quill-editor>
                    </el-form-item>

					<el-form-item label="发布时间" prop="start_time" style="margin-top: 100px"
                        :rules="[
                            { required: true, message: '发布时间不能为空', trigger: 'blur' },
                        ]"
                    >
						<el-date-picker
							v-model="form.start_time"
							type="datetime"
                            value-format="yyyy-MM-dd HH:mm:ss"
							placeholder="选择日期">
						</el-date-picker>
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
              form: {
                  title: '',
                  sub_title: '',
                  content: '',
                  start_time: '',
              },
			  editorOption: {
			    modules: {
					toolbar: [
					  ['bold', 'italic', 'underline', 'strike'],
					  ['blockquote', 'code-block'],
					  [{ 'header': 1 }, { 'header': 2 }],
					  [{ 'list': 'ordered' }, { 'list': 'bullet' }],
					  [{ 'script': 'sub' }, { 'script': 'super' }],
					  [{ 'indent': '-1' }, { 'indent': '+1' }],
					  [{ 'direction': 'rtl' }],
					  [{ 'size': ['small', false, 'large', 'huge'] }],
					  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
					  [{ 'font': [] }],
					  [{ 'color': [] }, { 'background': [] }],
					  [{ 'align': [] }],
					  ['clean'],
					  ['link', 'image', 'video']
					],
			    }
			  }
          }
      },

	  computed: {
	    editor() {
			return this.$refs.formEditor.quill
	    },
	  },

      created () {
      },

      methods: {
        submitUpload() {
			this.$refs['form'].validate((valid) => {
				if (valid) {
                    let formData = new FormData()
                    formData.append('title', this.form.title)
                    formData.append('sub_title', this.form.sub_title)
                    formData.append('content', this.form.content)
                    formData.append('start_time', this.form.start_time)
                    http({
                        url: Api.storeMessage,
                        method: 'post',
                        data: formData
                    }).then(response => {
                        this.$notify.success({
                            'title': "提示",
                            'message': response.data.msg
                        })

                        this.$router.push({ name: 'message'})

                    }).catch(err => {
                        console.log(err)
                    })
				} else {
                    console.log('err')
				}
			});
        },

        back() {
            this.$router.push({ name: 'message'})
        },

		onEditorBlur(editor) {
		  console.log('editor blur!', editor)
		},

		onEditorFocus(editor) {
		  console.log('editor focus!', editor)
		},

		onEditorReady(editor) {
		  console.log('editor ready!', editor)
		}
      }
  }
</script>

<style>
.submitButton {
    z-index: 999;
}
.quill-code {
  border: none;
  height: 200px;
  > code {
    width: 100%;
    margin: 0;
    padding: 1rem;
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0;
    height: 5rem;
    overflow-y: auto;
    resize: vertical;
  }
}
.quill-editor {
  height: 400px;
}
</style>
