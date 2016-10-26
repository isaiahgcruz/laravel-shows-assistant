<template>
  <div class="panel panel-default">
    <div class="panel-heading">Shows</div>

    <div class="panel-body">
      <show v-for="show in shows" :show="show"></show>
    </div>
  </div>
</template>

<script>
  import Show from './Show.vue'

  export default {
    components: {
      Show
    },

    data () {
      return {
        shows: false
      }
    },

    created () {
      this.fetchData()
      this.$bus.$on('shows-fetch-data', () => {
        this.fetchData()
      })
    },

    methods: {
      fetchData () {
        this.$http.get('api/users/' + user.id + '/shows')
          .then((response) => {
            this.shows = response.body
          }, (response) => {
            this.shows = false
          })
      }
    }
  }
</script>