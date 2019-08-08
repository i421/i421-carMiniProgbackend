<template>
    <div>
        <el-row>
        </el-row>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data() {
          return {
          }
      },

      created () {
          this.fetchCarousel()
      },

      methods: {
        fetchCarousel() {
            http({
                url: Api.settingSetCarousel,
                method: 'get',
            }).then(response => {
                console.log(JSON.parse(response.data.data))
            }).catch(err => {
                console.log(err)
            })
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
    margin: 0 auto;
}
.el-upload-list {
    height: 50px;
}
</style>
