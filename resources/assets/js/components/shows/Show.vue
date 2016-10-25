<template>
  <p>{{ show.name }}</p>
</template>

<script>
  export default {
    props: {
      show: {
        type: Object,
        required: true
      }
    }
  }
</script>