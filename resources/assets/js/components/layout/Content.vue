<template>
    <section id="app-container">
        <transition>
            <router-view></router-view>
        </transition>
    </section>
</template>

<script>
	export default {
		name: 'AppContent'
	}
</script>

<style scoped>
#app-container {
    padding: 20px;
}
</style>
