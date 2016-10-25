<template>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">Dashboard</div>
      <div class="panel-body">
        Dashboard body
      </div>
    </div>

    <upcoming-episodes></upcoming-episodes>
  </div>
</template>

<script>
  import UpcomingEpisodes from './UpcomingEpisodes.vue'

  export default {
    components: { 
      UpcomingEpisodes
    },

    props: {
      user: {
        type: Object
      }
    }
  }
</script>