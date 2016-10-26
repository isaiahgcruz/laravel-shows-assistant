<template>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">Dashboard</div>
      <div class="panel-body">
        Dashboard body
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <upcoming-episodes></upcoming-episodes>
      </div>
      <div class="col-md-6">
        <upcoming-episodes></upcoming-episodes>
      </div>
      <div class="col-md-3">
        <generator :user="user"></generator>
        <div class="panel panel-default">
          <div class="panel-heading">Shortcuts</div>
          <div class="panel-body">
            <p>
              <button class="btn btn-default"
                @click="refreshEpisodes"
                :disabled="isLoading"
              >Refresh episodes</button>
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import UpcomingEpisodes from './UpcomingEpisodes.vue'
  import Generator from './Generator.vue'

  export default {
    components: { 
      UpcomingEpisodes, Generator
    },

    data () {
      return {
        isLoading: false
      }
    },

    props: {
      user: {
        type: Object
      }
    },

    methods: {
      refreshEpisodes () {
        this.isLoading = true
        this.$http.post('api/episodes/refresh')
          .then((response) => {
            //insert code here            
          }).finally(() => {
            this.isLoading = false
          })
      }
    }
  }
</script>