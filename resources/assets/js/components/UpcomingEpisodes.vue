<template>
  <div class="panel panel-default">
    <div class="panel-heading">
      Upcoming Shows
    </div>
    <div class="panel-body">
      <template v-for="(value, key) in upcomingShows">
        <h4>{{ key }}</h4>
        <p v-for="episode in value">{{ episode.title }} | {{ episode.name }}</p>
      </template>
    </div>
  </div>
</template>

<script>
  export default {
    /**
     * Component's data
     */
    data () {
      return {
        upcomingShows: false
      }
    },

    created () {
      this.fetchData()
      this.$bus.$on('upcoming-episodes-fetch-data', () => {
        this.fetchData()
      })
    },

    methods: {
      /**
       * Gets all the upcoming episodes for the users
       */
      fetchData () {
        const params = {
          user
        }
        this.$http.get('api/episodes/upcoming', { params })
          .then((response) => {
            this.upcomingShows = response.body
          })
      }
    }
  }
</script>