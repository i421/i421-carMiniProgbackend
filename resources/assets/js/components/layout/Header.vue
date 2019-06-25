<template>
  <div>
      <el-row class="topbar-wrap">
        <div class="topbar-title">
            <span><p>后台管理系统</p></span>
        </div>
        <div class="topbar-account topbar-btn">
          <el-dropdown trigger="click">
            <span class="el-dropdown-link userinfo-inner">
                <el-button size="small" icon="el-icon-user" circle></el-button>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item @click.native="userinfo">个人信息</el-dropdown-item>
              <el-dropdown-item @click.native="editpwd">修改密码</el-dropdown-item>
              <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </el-row>
  </div>
</template>
<script type="text/ecmascript-6">

  export default {
    data() {
      return {
        collapsed: false,
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
</style>
