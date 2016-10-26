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
        this.$http.delete('api/users/' + user.id + '/shows/' + this.show.id)
          .then((response) => {
            this.$bus.$emit('show-alert', 'alert alert-success', 'Show successfully removed')
          }).finally(() => {
            this.$bus.$emit('upcoming-episodes-fetch-data')
            this.$bus.$emit('shows-fetch-data')
          })
      }
    }
  }
</script>