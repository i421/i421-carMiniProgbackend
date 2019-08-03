<template>
    <div>
        <el-steps :space="200" :active="1" finish-status="success">
            <el-step title="已完成"></el-step>
            <el-step title="进行中"></el-step>
            <el-step title="步骤 3"></el-step>
        </el-steps>
    </div>
</template>

<script>
  import { http } from './../utils/fetch'
  export default {
      created () {
        //console.log(this.$store.state.auth_user)
        //this.Test()
      },
      methods: {
        Test () {
            http({
                url: "/api/v1/test",
            }).then(response => {
                //console.log(response)
            })
        }
    }
  }
</script>

<style>
</style>
