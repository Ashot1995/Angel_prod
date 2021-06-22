<template>
    <yandex-map
        style="height: 64vh"
        :coords="coords"
        :zoom="zoom"
    >
        <slot></slot>
    </yandex-map>
</template>

<script>
import { yandexMap } from "vue-yandex-maps";

export default {
    name: "YandexMap",
    props: ['coords', 'zoom'],
    components: {
        'yandex-map':yandexMap,
    },
}
</script>

<style scoped>

</style>
