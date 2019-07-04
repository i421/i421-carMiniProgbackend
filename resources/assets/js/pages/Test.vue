<template>
    <div>
	  <div style="margin-top: 20px" v-for="(item,index,key) in tags" :key="key">
		  <p>{{ index}}</p>
		<el-radio-group v-model="selected[index]" size="small" @change="test">
            <el-radio-button :label="v.id" v-for="(v, i, k) in item" :key="k">{{ v.name }}</el-radio-button>
		</el-radio-group>
	  </div>
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
		}
      }
  }
</script>

<style>
</style>
