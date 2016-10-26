<template>
  <div class="container">
    <alert></alert>
    <div class="row">
      <div class="col-md-3 col-sm-4">
        <upcoming-episodes></upcoming-episodes>
      </div>
      <div class="col-md-6 col-sm-4">
        <add-show :user="user"></add-show>
        <shows-list></shows-list>
      </div>
      <div class="col-md-3 col-sm-4">
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
  import Alert from './Alert.vue'
  import AddShow from './shows/AddShow.vue';
  import ShowsList from './shows/ShowsList.vue';

  export default {
    components: { 
      UpcomingEpisodes, Generator, Alert, AddShow, ShowsList
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
            this.$bus.$emit('show-alert', 'alert alert-success', 'Episodes refreshed')
          }, (response) => {
            this.$bus.$emit('show-alert', 'alert alert-danger', 'An error occurred')
          }).finally(() => {
            this.isLoading = false
          })
      }
    }
  }
</script>