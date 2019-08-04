<template>
    <div>
		<!-- table工具栏 -->
        <div id="tableTools">
            <el-row>
                <el-col :span="6" style="margin-right: 5px;">
                    <div style="width: 100%;">
                        <el-input class="table-search" v-model="conditionName" placeholder="汽车名"></el-input>
                    </div>
                </el-col>

                <el-col :span="6" style="margin-right: 5px;">
                    <div style="width: 100%">
                        <el-input class="table-search" v-model="conditionBrand" placeholder="汽车品牌"></el-input>
                    </div>
                </el-col>

                <el-col :span="6">
                    <el-select v-model="conditionGroup" placeholder="拼团类型" multiple="multiple" class="table-search">
                        <el-option label="时间拼团" value="1"></el-option>
                        <el-option label="数量拼团" value="2"></el-option>
                    </el-select>
                </el-col>
            </el-row>


            <div class="searchControl">
                <el-button type="primary" class="table-button" icon="el-icon-search" @click="search">查询</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-refresh" @click="clearSearch">清除</el-button>
                <el-button type="primary" class="table-button" icon="el-icon-add" @click="addCar">新增</el-button>
            </div>
        </div>

		<!-- table数据 -->
        <data-tables border :data="tableData" :action-col="actionCol" :pagination-props="{ pageSizes: [10, 15, 20] }">
            <el-table-column label="商品图" prop="img_url" width="180">
                <template slot-scope="scope">
                    <el-image style="width: 60px; height: 60px" :src="scope.row.avatar"></el-image>
                </template>
            </el-table-column>

            <el-table-column label="商品标题" prop="name">
            </el-table-column>

            <el-table-column label="裸车价" prop="car_price">
            </el-table-column>

            <el-table-column label="指导价" prop="guide_price">
            </el-table-column>

            <el-table-column label="落地价" prop="final_price">
            </el-table-column>

            <el-table-column label="所属品牌" prop="brand_name">
            </el-table-column>

            <el-table-column label="收藏数" prop="collection_count">
            </el-table-column>

            <el-table-column label="销量" prop="order_count">
            </el-table-column>
        </data-tables>

        <!-- 拼团设置 -->
        <el-dialog title="拼团设置" :visible.sync="dialogVisible">
            <el-tabs v-model="activeName" @tab-click="handleClick" tab-position="left" style="height: 400px;">

                <el-tab-pane label="时间拼团" name="timeGroup">
                    <el-form ref="timeForm" :model="groupForm" label-width="80px">
                        <el-form-item label="起止时间" prop="time_range"
                            :rules="[
                                { required: true, message: '起止时间不能为空', trigger: 'blur' },
                            ]"
                        >
                            <el-date-picker
                                v-model="groupForm.time_range"
                                type="datetimerange"
                                value-format="yyyy-MM-dd HH:mm:ss"
                                range-separator="至"
                                start-placeholder="开始日期"
                                end-placeholder="结束日期">
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item label="拼团价" prop="group_price"
                            :rules="[
                                { required: true, message: '拼团价不能为空', trigger: 'blur' },
                                { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                            ]"
                        >
                            <el-input v-model.number="groupForm.group_price" width="60px"></el-input>
                        </el-form-item>

                        <el-form-item>
                            <el-button type="primary" @click="onSubmit('1')">立即创建</el-button>
                        </el-form-item>

                    </el-form>
                </el-tab-pane>

                <el-tab-pane label="数量拼团" name="numGroup">
                    <el-form ref="numForm" :model="groupForm" label-width="80px">
                        <el-form-item label="数量" prop="total_num"
                            :rules="[
                                { required: true, message: '数量不能为空', trigger: 'blur' },
                                { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                            ]"
                        >
                            <el-input v-model.number="groupForm.total_num" width="60px"></el-input>
                        </el-form-item>

                        <el-form-item label="拼团价" prop="group_price"
                            :rules="[
                                { required: true, message: '拼团价不能为空', trigger: 'blur' },
                                { type: 'number', message: '必须为数字', trigger: ['blur', 'change'] },
                            ]"
                        >
                            <el-input v-model.number="groupForm.group_price" width="60px"></el-input>
                        </el-form-item>

                        <el-form-item label="截止时间" prop="time_range"
                            :rules="[
                                { required: true, message: '时间不能为空', trigger: 'blur' },
                            ]"
                        >
                            <el-date-picker
                                v-model="groupForm.time_range"
                                type="datetimerange"
                                value-format="yyyy-MM-dd HH:mm:ss"
                                range-separator="至"
                                start-placeholder="开始日期"
                                end-placeholder="结束日期">
                            </el-date-picker>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit('2')">立即创建</el-button>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>

            </el-tabs>
        </el-dialog>
    </div>
</template>

<script>
  import { http } from './../../utils/fetch'
  import Api from './../../config'

  export default {
      data () {
          return {
            activeName: 'timeGroup',
		    dialogVisible: false,
            conditionName: '',
            conditionBrand: '',
            conditionGroup: [],
            conditionMinPrice: '',
            conditionMaxPrice: '',
			tableData: [],
            groupForm: {
                car_id: '',
                total_num: '',
                type: '',
                time_range: '',
                group_price: '',
            },
            actionCol: {
                label: '操作',
                props: {
                    align: 'center',
                    width: '400px',
                },

                buttons: [{
                    props: {
                        type: 'warning',
                        size: "mini",
                        icon: 'el-icon-edit'
                    },
                    handler: row => {
                        this.show(row)
                    },
                    label: '详情'
                }, {
                    props: {
                        type: 'primary',
                        size: "mini",
                        icon: 'el-icon-time'
                    },
                    handler: row => {
                        this.dialogVisible = true
                        this.groupForm.car_id = row.id
                    },
                    label: '设置拼团'
                }, {
                    props: {
                        type: 'danger',
                        size: "mini",
                        icon: 'el-icon-delete'
                    },
                    handler: row => {
                        this.destroy(row)
                    },
                    label: '删除'
                }]
            },
          }
      },
      created () {
          this.fetchCars()
      },
      methods: {
          search() {
          },

          fetchCars() {
            http({
                url: Api.cars,
            }).then(response => {
                this.tableData = response.data.data
            })
          },

          //清楚查询条件
          clearSearch() {
            this.conditionNickname = ''
            this.conditionBrand = ''
            this.conditionGroup = []
          },

          //查看详情
          show(row) {
              this.$router.push({ name: 'showCar', params: {"id": row.id} })
          },

          addCar() {
              this.$router.push({ name: 'createCar' })
          },

          //处理切换
          handleClick(tab, event) {
            console.log(tab, event);
            this.groupForm.time_range = ''
            this.groupForm.group_price= ''
            this.groupForm.total_num= ''
          },

          //提交组团信息
          onSubmit(type) {
              this.groupForm.type = type;

              //todo http post
          },

          //删除
          destroy(row) {
            this.$confirm('此操作将永久该汽车, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {

                http({
                    method: 'delete',
                    url: Api.destroyCar + row.id,
                }).then(response => {
                    this.$notify.success({
                        'title': "提示",
                        'message': response.data.msg
                    })
                    this.fetchCars()
                })

            }).catch(() => {
                this.$notify({
                    type: 'info',
                    message: '已取消删除'
                });
            })
          }
      }
  }
</script>

<style>
#tableTools {
    display: inline-block;
}
#tableTools .table-button {
    margin: 0 0 30px 0px;
}
#tableTools .table-search {
    margin: 0 10px 15px 0px;
}
</style>
