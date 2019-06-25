<template>
<div>
    <el-menu
        default-active="2"
        router
        class="el-menu-vertical-demo"
        :collapse="isCollapse"
        @open="handleOpen"
        @close="handleClose" >

        <el-col v-for="menu in menus" :key="menu.id">
            <el-menu-item v-if="menu.child==null" :key="menu.id" :index="menu.name">
                <i :class="menu.icon"></i>
                <span slot="title" v-if="$store.state.language == 'zh_cn'"> {{ menu.display_zh_name }}</span>
                <span slot="title" v-else>{{ menu.display_en_name }}</span>
            </el-menu-item>

            <el-submenu v-else :key="menu.id" :index="menu.name">
                <template slot="title">
                    <i :class="menu.icon"></i>
                    <span slot="title" v-if="$store.state.language == 'zh_cn'"> {{ menu.display_zh_name }}</span>
                    <span slot="title" v-else>{{ menu.display_en_name }}</span>
                </template>

                <el-menu-item-group v-for="atom in menu.child" :key="atom.name">
                    <el-menu-item :key="atom.id" :index="atom.name">
                        <span slot="title" v-if="$store.state.language == 'zh_cn'"> {{ atom.display_zh_name }}</span>
                        <span slot="title" v-else> {{ atom.display_en_name }} </span>
                    </el-menu-item>
                </el-menu-item-group>
            </el-submenu>
        </el-col>

    </el-menu>
</div>
</template>

<script>

    import Api from './../../config'
    import { http } from './../../utils/fetch'

    export default {
        data() {
            return {
                isCollapse: false,
                menus: [],
            }
        },

        created() {
            this.fetchMenuList()
        },

        methods: {
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },

            handleClose(key, keyPath) {
                console.log(key, keyPath);
            },

            //获取菜单列表
            fetchMenuList() {
                http({
                    url: Api.userPermission,
                }).then(response => {
                    this.menus = response.data.data
                }, response => {
                    console.log(err)
                })
            }
        }
    }
</script>

<style>
.el-menu-vertical-demo {
    height: 100%;
    z-index: 1;
}
.el-submenu .el-menu-item {
    min-width: 50px !important;
}
</style>
