<template>
	<div>
        <el-row>
            <app-header></app-header>
        </el-row>
        <el-row>
            <el-col :span="3" class="appContent">
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

.appContent{
    overflow-x: scroll !important;
}
.appContent::-webkit-scrollbar {/*滚动条整体样式*/
    width: 8px;     /*高宽分别对应横竖滚动条的尺寸*/
    height: 8px;
}
.appContent::-webkit-scrollbar-thumb {/*滚动条里面小方块*/
    border-radius: 5px;
    -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
    background: rgba(0,0,0,0.2);
}
.appContent::-webkit-scrollbar-track {/*滚动条里面轨道*/
    -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
    border-radius: 0;
    background: rgba(0,0,0,0.1);
}

</style>
