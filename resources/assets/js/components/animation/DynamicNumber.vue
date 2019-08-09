<template>
    <p class="number">{{ animatedNumber }}
        <small>
            <slot></slot>
        </small>
    </p>
</template>
<script>
    import TWEEN from 'tween.js'

    export default {
        data() {
            return {
                animatedNumber: 0,
            }
        },

        props: [
            'number',
        ],

        watch: {
            number: function (newValue, oldValue) {
                var that = this
                var animationFrame

                function animate(time) {
                    TWEEN.update(time)
                    animationFrame = requestAnimationFrame(animate)
                }

                new TWEEN.Tween({tweeningNumber: oldValue})
                    .easing(TWEEN.Easing.Quadratic.Out)
                    .to({tweeningNumber: newValue}, 5000)
                    .onUpdate(function () {
                        that.animatedNumber = this.tweeningNumber.toFixed(0)
                    })
                    .onComplete(function () {
                        cancelAnimationFrame(animationFrame)
                    })
                    .start()
                animationFrame = requestAnimationFrame(animate)
            }
        },
    }
</script>
<style scoped>
    .number {
        font-size: 34px;
    }
</style>
