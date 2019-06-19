<template>
  <div>
      <el-row class="topbar-wrap">
          <el-col :span="3">
            <div class="topbar-logo topbar-btn">
              <img style="height: 65px" src="../../static/logo.png">
            </div>
          </el-col>
          
          <el-col :span="21">
            <div class="topbar-title topbar-btn">
              <span>后台管理系统</span>
            </div>
            <div class="topbar-account topbar-btn">
              <el-dropdown trigger="click">
                <span class="el-dropdown-link userinfo-inner">
                    <el-button type="info" icon="el-icon-user" circle></el-button>
                </span>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item @click.native="userinfo">个人信息</el-dropdown-item>
                  <el-dropdown-item @click.native="editpwd">修改密码</el-dropdown-item>
                  <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
                </el-dropdown-menu>
              </el-dropdown>
            </div>
          </el-col>
      </el-row>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {
    data() {
      return {
        sysUserName: '',
        sysUserAvatar: '',
        collapsed: false,
      }
    },
    mounted() {
      //var userSession = this.getCookie('session');
      //if(userSession) {
      //  this.sysUserName = userSession || '';
      //}
    },
    methods: {
      //退出
      logout() {
        this.$confirm('确认要退出吗？','提示',{}).then(() => {
          this.$fetch('m/logout').then((res) =>{
            if(res.errCode == 200) {
              //this.delCookie('session');
              //this.delCookie('u_uuid');
              //this.$router.push({path: '/', query: {redirect: this.$router.currentRoute.fullPath}});
            } else {
              console.log(res.errMsg);
            }
          });
        }).catch(() => {
        });
      },
      //个人信息
      userinfo() {
        this.$router.push('/userinfo');
      },
      //修改密码
      editpwd() {
        this.$router.push('/editpwd');
      }
    }
  }
</script>

<style>
.topbar-wrap {
    padding: 0;
    height: 66px;
    background: rgb(86, 95, 104);
    line-height: 66px
}
.topbar-btn {
    color:#fff
}
.topbar-logo {
    height:66px;
    padding-left: 30px;
}
.topbar-logo, .topbar-title {
    float:left;
    border-right:1px solid rgb(86, 95, 104);
    text-align:center
}
.topbar-title {
    width:129px
}
.topbar-account {
    float:right;
    height: 66px;
    padding-right:9pt;
    font-size:9pt
}
.userinfo-inner {
    height: 100%;
    display: inline-block;
    padding-top: 13px;
    padding-right: 10px;
}
</style>
