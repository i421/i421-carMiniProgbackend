<template>
    <div>
        <el-tag type="success">帖子信息</el-tag>
        <el-row>
            <el-col>
                <el-form ref="form" :model="form" label-width="100px" style="width:460px">

                    <el-form-item label="标题" prop="title">
                        <el-input v-model="form.title"></el-input>
                    </el-form-item>

                    <el-form-item label="内容" label-width="100px" prop="content">
                        <el-input type="textarea" v-model="form.content"></el-input>
                    </el-form-item>

                    <el-form-item label="发布时间" prop="publish_at">
                        <el-input  v-model="form.publish_at"></el-input>
                    </el-form-item>

                    <el-form-item label="发布人" prop="nickname">
                        <el-input  v-model="form.nickname"></el-input>
                    </el-form-item>

                    <el-form-item label="轮播图" prop="imgs">
                        <el-carousel>
                            <el-carousel-item v-for="item in imgs" :key="item">
                                <el-image
                                    :src="item"
                                    :preview-src-list="[item]"
                                    fit="fit">
                                </el-image>
                            </el-carousel-item>
                        </el-carousel>

                    </el-form-item>

                </el-form>
            </el-col>
        </el-row>

        <el-tag type="success">评论信息</el-tag>
		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">

            <el-table-column label="序号" prop="id" width="80">
            </el-table-column>

            <el-table-column label="内容" prop="content" width="180">
            </el-table-column>

            <el-table-column label="发布人" prop="nickname" width="180">
            </el-table-column>

            <el-table-column label="状态" prop="status">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.status == 1" type="primary">正常</el-tag>
                    <el-tag v-else type="danger">禁止</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="发布时间" prop="created_at">
            </el-table-column>
        </data-tables>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data() {
          return {
			tableData: [],
            imgs:[],
            form: {
                id: '',
                nickname: '',
                title: '',
                content: '',
                publish_at: '',
                imgs: [],
                comments: ''
            },
            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '400px',
                },

                buttons: [{
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-edit'
                    },
                    handler: row => {
                        this.ban(row)
                    },
                    label: '禁止'
                }]
            },
          }
      },

      created () {
          this.fetchForum();
      },

      methods: {

        fetchForum() {
          http({
              url: Api.showForum + this.$route.params.id,
          }).then(response => {
              this.form = response.data.data
              this.imgs = response.data.data.imgs
              this.tableData = response.data.data.comments
          })
        },

        back() {
            this.$router.push({ name: 'forum'})
        },

        ban(row) {
          http({
              url: Api.banComment + row.id,
              method: 'post',
          }).then(response => {
              this.fetchForum()
          })
        },
      }
  }
</script>

<style>
.submitButton {
    z-index: 999;
}
</style>
