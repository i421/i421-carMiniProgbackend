<template>
  <div>
      <el-row class="topbar-wrap">
        <div class="topbar-title">
            <span><p>后台管理系统</p></span>
        </div>
        <div class="topbar-account topbar-btn">
          <el-badge is-dot class="item">
              <el-button size="small" icon="el-icon-news" class="headMessage">消息</el-button>
          </el-badge>
          <el-dropdown trigger="click">
            <span class="el-dropdown-link userinfo-inner">
                <el-avatar size="small" :src="avatarUrl"></el-avatar>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item @click.native="userinfo">个人信息</el-dropdown-item>
              <el-dropdown-item @click.native="editpwd">修改密码</el-dropdown-item>
			  <el-dropdown-item @click.native="dialogVisible = true">更新头像</el-dropdown-item>
              <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
        <div style="position: absolute; top: 60px; right: 5px; z-index:999">
            <el-button @click="back" circle size="small" icon="el-icon-arrow-left">后退</el-button>
            <el-button @click="forword" circle size="small" style="margin-left:0px">
                前进<i class="el-icon-arrow-right el-icon--right"></i>
            </el-button>
        </div>

      </el-row>

	  <el-dialog title="用户头像" :visible.sync="dialogVisible">
		  <div style="text-align: center; margin: 0 auto">
			<el-upload
			  class="upload-avatar"
			  :http-request="updateAvatar"
			  ref="upload"
			  drag
			  action="">
			  <i class="el-icon-upload"></i>
			  <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
			  <div class="el-upload__tip" slot="tip">只能上传jpg文件，且不超过2M</div>
			</el-upload>
		  </div>
	  </el-dialog>
  </div>
</template>
<script type="text/ecmascript-6">

  import Api from './../../config'
  import { http } from './../../utils/fetch'

  export default {
    data() {
      return {
        collapsed: false,
		dialogVisible: false,
        avatarUrl: this.$store.state.auth_user.avatar != '' ? this.$store.state.auth_user.avatar : '/images/defaultAatarUrl.png',
      }
    },

    methods: {
      //退出
      logout() {
        this.$confirm('确认要退出吗？','提示',{}).then(() => {
            this.$store.dispatch('doLogout')
            this.$router.push('/login');
        }).catch(() => {
        });
      },

      //个人信息
      userinfo() {
        this.$router.push('/user/info');
      },

      //修改密码
      editpwd() {
        this.$router.push('/reset/password');
      },

      //修改头像
      updateAvatar(param) {
		let formData = new FormData()
		formData.append('avatar', param.file)

		http({
			url: Api.updateAvatar,
			method: 'post',
			data: formData
		}).then(response => {
			//关闭对话框 清除原有数据 成功提示 更新头像
			this.dialogVisible = false
			this.$refs.upload.clearFiles()
			this.$notify.success({
				'title': "提示",
				'message': response.data.msg
			})
            this.$store.dispatch('setAvatar', response.data.data)
		}).catch(err => {
			console.log(err)
		})
      },

      //上一页
      back() {
        this.$router.go(-1)
      },

      //下一页
      forword() {
        this.$router.go(1)
      }
    }
  }
</script>

<style>
.topbar-wrap {
    padding: 0;
    height: 66px;
    background: #00a9e0;
    line-height: 66px;
    color:#fff;
}
.topbar-title {
    float:left;
    text-align:center;
    font-size: 24px;
    height: 66px;
    width:200px;
}
.topbar-account {
    float:right;
    height: 66px;
    padding-right:9pt;
    font-size:9pt;
}
.userinfo-inner {
    height: 100%;
    display: inline-block;
    padding-top: 16px;
    padding-right: 10px;
}
.upload-avatar .el-upload__input {
	margin-top: -30px;
}
.item {
    margin-bottom: 15px;
    margin-right: 20px;
}
.headMessage {
    background-color: #00a9e0;
    border-color: #00a9e0;
    color: #fff;
}
.headMessage:hover {
    background-color: #00a9e0;
    cursor: pointer;
    color: #fff;
}
.headMessage:focus {
    background-color: #00a9e0;
    cursor: pointer;
    color: #fff;
}
</style>
