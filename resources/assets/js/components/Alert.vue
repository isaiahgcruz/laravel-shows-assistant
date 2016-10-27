<template>
  <div :class="className" v-if="show">
    <a href="#" class="close" @click="show = false" aria-label="close">&times;</a>
    {{ message }}
  </div>
</template>

<script>
  export default {
    /**
     * Component's data
     */
    data () {
      return {
        show: false,
        className: false,
        message: false
      }
    },

    watch: {
      /**
       * Timeout for the component to hide in 3 seconds
       */
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
      /**
       * Show's the alert
       */
      showAlert (className, message) {
        this.className = className;
        this.message = message;
        this.show = true;
      }
    }
  }
</script>