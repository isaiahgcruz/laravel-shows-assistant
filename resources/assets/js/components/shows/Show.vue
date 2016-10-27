<template>
  <p>
    {{ show.name }}
    <span class="pull-right">
      <i 
        class="glyphicon glyphicon-remove"
        @click="removeShow"
        style="cursor: pointer"
      ></i>
    </span>
  </p>
</template>

<script>
  export default {
    props: {
      show: {
        type: Object,
        required: true
      }
    },

    methods: {
      removeShow () {
        const messages = ["Are you sure you want to delete ["+ this.show.name +"]?"]
        const link = 'api/users/' + user.id + '/shows/' + this.show.id
        const method = 'delete'
        const payLoad = {}
        const callback = this.removeShowSuccess
        const alert = 'Show successfully deleted'
        this.$bus.$emit('show-confirm-modal', messages, link, method, payLoad, callback, alert)
      },
      removeShowSuccess () {
        this.$bus.$emit('shows-fetch-data')
        this.$bus.$emit('upcoming-episodes-fetch-data')
      }
    }
  }
</script>