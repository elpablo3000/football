<template>
    <div class="container">
        <div>
<!--            <transition name="slide">-->
                <router-view></router-view>
<!--            </transition>-->
        </div>
    </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s
}

.fade-enter, .fade-leave-active {
    opacity: 0
}
</style>

<script>

export default {};
</script>
