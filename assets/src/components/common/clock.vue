<template>
    <span>{{ display }}</span>
</template>

<script>

export default {
    data() {
        return {
            time: Date.now()
        }
    },
    computed: {
        display() {
            return hrm.Moment(this.time).format('LTS');
        }
    },
    created() {
        setInterval(() => {
            this.time = Date.now();
        }, 1000);
    }
}
</script>