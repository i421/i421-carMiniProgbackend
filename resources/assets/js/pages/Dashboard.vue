<template>
    <div>
        <el-row>
            dashboard
        </el-row>
    </div>
</template>

<script>
  import { http } from './../utils/fetch'
  export default {
      created () {
        //console.log(this.$store.state.auth_user)
        this.Test()
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
