<template>
    <div>
        总人数:<dynamic-number v-bind:number="total_customer">人</dynamic-number>
        认证人数:<dynamic-number v-bind:number="auth_customer">人</dynamic-number>
        待认证人数:<dynamic-number v-bind:number="wait_auth_customer">人</dynamic-number>
    </div>
</template>

<script>
    import DynamicNumber from './../../components/animation/DynamicNumber.vue';
    import { http } from './../../utils/fetch'
    import Api from './../../config'

    export default {

	  data() {
		return {
            total_customer: 0,
            auth_customer: 0,
            wait_auth_customer: 0,
        }
      },

      components: {
          DynamicNumber
      },

      created () {
          this.dashboard()
      },

      methods: {
        dashboard () {
            http({
                url: Api.dashboard,
            }).then(response => {
                this.total_customer = response.data.data.total_customer
                this.auth_customer = response.data.data.auth_customer
                this.wait_auth_customer = response.data.data.wait_auth_customer
            })
        }
    }
  }
</script>

<style>
</style>
