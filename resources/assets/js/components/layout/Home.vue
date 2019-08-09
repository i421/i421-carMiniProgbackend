<template>
	<div>
        <el-row>
            <app-header></app-header>
        </el-row>
        <el-row>
            <el-col :span="3">
                <navbar></navbar>
            </el-col>
            <el-col :span="21" class="appContent">
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
<style>
.appContent {
    height: 100%;
    overflow-y: scroll;
}
</style>
