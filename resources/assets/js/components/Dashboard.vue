<template>
  <div class="container">
    <confirm-modal></confirm-modal>
    <alert></alert>
    <div class="row">
      <div class="col-md-3 col-sm-4">
        <upcoming-episodes></upcoming-episodes>
      </div>
      <div class="col-md-6 col-sm-4">
        <add-show></add-show>
        <shows-list></shows-list>
      </div>
      <div class="col-md-3 col-sm-4">
        <generator></generator>
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
  import ConfirmModal from './ConfirmModal.vue';

  export default {
    components: { 
      UpcomingEpisodes, Generator, Alert, AddShow, ShowsList, ConfirmModal
    },

    /**
     * Component's data
     */
    data () {
      return {
        isLoading: false
      }
    },

    methods: {
      /**
       * API Call to refresh all the shows' episodes
       */
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