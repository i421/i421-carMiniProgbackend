<template>
    <section id="app-container">
		<transition mode="out-in" :duration="{ enter: 500, leave: 400 }"
			enter-active-class="animated"
			leave-active-class="animated fadeOutRight">
            <router-view :key="$route.path"></router-view>
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
    margin-bottom: 66px;
}
</style>
