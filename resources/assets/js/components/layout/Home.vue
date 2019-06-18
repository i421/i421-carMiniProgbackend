<template>
	<div>
        <el-row>
            <app-header></app-header>
        </el-row>
        <el-row>
            <el-col :span="3">
                <navbar></navbar>
            </el-col>
            <el-col :span="21">
                <app-content></app-content>
            </el-col>
        </el-row>
	</div>
</template>

<script>
    import Navbar from './Navbar'
    import AppHeader from './Header'
    import AppContent from './Content'

	export default {
		name: 'AppLayout',
		components: {
			Navbar,
			AppContent,
			AppHeader
		}
	}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
	.app-wrapper {
	  position: relative;
	  height: 100%;
	  width: 100%;
	}
	.main-container {
	  text-align: center;
	  margin-top: 400px;
	  min-height: 50vh;
	}
</style>
