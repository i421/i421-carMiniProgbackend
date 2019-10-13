<template>
    <div>
		<el-row style="text-align: center">
		    <el-col :span="3">
                <span>总人数</span><dynamic-number v-bind:number="total_customer">人</dynamic-number>
            </el-col>
		    <el-col :span="3">
                <span>认证人数</span><dynamic-number v-bind:number="auth_customer">人</dynamic-number>
            </el-col>
		    <el-col :span="3">
                <span>待认证人数</span><dynamic-number v-bind:number="wait_auth_customer">人</dynamic-number>
            </el-col>
		    <el-col :span="3">
                <span>现车订单</span><dynamic-number v-bind:number="now_car">辆</dynamic-number>
            </el-col>
		    <el-col :span="3">
                <span>拼团订单</span><dynamic-number v-bind:number="group_car">辆</dynamic-number>
            </el-col>
        </el-row>

		<el-row>
			<el-col :span="12">
				<div class="charts">
					<highcharts :options="collectionRankChartOptions"></highcharts>
				</div>
			</el-col>

			<el-col :span="12">
				<div class="charts">
					<highcharts :options="viewRankChartOptions"></highcharts>
				</div>
			</el-col>
		</el-row>

		<el-row>
			<el-col :span="12">
				<div class="charts">
					<highcharts :options="keywordChartOptions"></highcharts>
				</div>
			</el-col>
		</el-row>
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
            now_car: 0,
            group_car: 0,
			collectionRankChartOptions: {
				chart: {
					type: 'pie',
				},
                title: {
                    text: '汽车收藏数饼图'
                },
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %'
						}
					}
				},
                series: [{
                    data:[]
                }]
			},
			keywordChartOptions: {
				chart: {
					type: 'pie',
				},
                title: {
                    text: '汽车浏览量排行饼图'
                },
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %'
						}
					}
				},
                series: [{
                    data:[]
                }]
			},
			viewRankChartOptions: {
				chart: {
					type: 'pie',
				},
                title: {
                    text: '关键词排行饼图'
                },
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %'
						}
					}
				},
                series: [{
                    data:[]
                }]
			}
        }
      },

      components: {
          DynamicNumber
      },

      created () {
          this.dashboard()
          this.fetchCollectionRank()
          this.fetchKeywordRank()
          this.fetchViewRank()
      },

      methods: {
        dashboard () {
            http({
                url: Api.dashboard,
            }).then(response => {
                this.total_customer = response.data.data.total_customer
                this.auth_customer = response.data.data.auth_customer
                this.wait_auth_customer = response.data.data.wait_auth_customer
                this.now_car = response.data.data.now_car
                this.group_car = response.data.data.group_car
            })
        },

        fetchCollectionRank() {
            http({
                url: Api.dashboardCollectionRank,
            }).then(response => {
                let res = response.data.data
                let pieSeriesData = []
                let length = response.data.data.length

                for (let i = 0; i < length; i++) {
                    this.collectionRankChartOptions.series[0].data.push({ y: res[i]['value'], name: res[i]['name'] + " " + res[i]['value'] })
                }
            })
        },

        fetchViewRank() {
            http({
                url: Api.dashboardViewRank,
            }).then(response => {
                let res = response.data.data
                let pieSeriesData = []
                let length = response.data.data.length

                for (let i = 0; i < length; i++) {
                    this.viewRankChartOptions.series[0].data.push({ y: res[i]['value'], name: res[i]['name'] + " " + res[i]['value'] })
                }
            })
        },

        fetchKeywordRank() {
            http({
                url: Api.dashboardKeywordRank,
            }).then(response => {
                let res = response.data.data
                let pieSeriesData = []
                let length = response.data.data.length

                for (let i = 0; i < length; i++) {
                    this.keywordChartOptions.series[0].data.push({ y: res[i]['value'], name: res[i]['name'] + " " + res[i]['value'] })
                }
            })
        }
    }
  }
</script>

<style>
.charts {
	padding: 20px 10px 0;
}
</style>
