<template>
  <div :class="className" v-if="show">
    <a href="#" class="close" @click="show = false" aria-label="close">&times;</a>
    {{ message }}
  </div>
</template>

<script>
  export default {
    data () {
      return {
        show: false,
        className: false,
        message: false
      }
    },

    watch: {
      show(val) {
        if (val) {
          window.setTimeout(() => {
            this.show = false;
          }, 3000)
        }
      }
    },

    created () {
      this.$bus.$on('show-alert', (className, message) => {
        this.showAlert(className, message)
      })
    },

    methods: {
      showAlert (className, message) {
        this.className = className;
        this.message = message;
        this.show = true;
      }
    }
  }
</script>