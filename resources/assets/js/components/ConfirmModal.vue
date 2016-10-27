<template>
  <div class="modal fade" tabindex="-1" role="dialog" id="confirm-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" v-if="!errors">Confirmation</h4>
          <h4 class="modal-title" v-else>An error occurred</h4>
        </div>

        <div class="modal-body">
          <template v-if="!isLoading && !errors">
            <p v-for="message of messages" v-text="message"></p>
          </template>
      
          <template v-if="!isLoading && errors">
            <p v-for="error of errors" v-text="error"></p>
          </template>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="handleConfirm">Confirm</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
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
        showModal: false,
        messages: '',
        errors: '',
        link: '',
        method: '',
        payLoad: {},
        callback: function () {},
        alert: '',
        isLoading: false
      }
    },

    created () {
      this.$bus.$on('show-confirm-modal', (messages, link, method, payLoad, callback, alert) => {
        this.showConfirmModal(messages, link, method, payLoad, callback, alert)
      })
    },

    methods: {
      /**
       * Show the confirm modal
       */
      showConfirmModal (messages, link, method, payLoad, callback, alert) {
        $('#confirm-modal').modal('show')
        this.messages = messages
        this.link = link
        this.method = method
        this.payLoad = payLoad
        this.callback = callback
        this.alert = alert
      },

      /**
       * Handle the modal submission.
       */
      handleConfirm() {
        this.isLoading = true
        this.$http[this.method](this.link, this.payload).then(this.success, this.error)
      },

      /**
       * Success callback.
       */
      success({body}) {
        this.isLoading = false
        $('#confirm-modal').modal('hide')
        if (this.alert.length) {
            this.$bus.$emit('show-alert', 'alert alert-success', this.alert)
        }

        if (this.callback) {
            this.callback()
        }
      },

      /**
       * Error callback.
       */
      error({body}) {
        this.isLoading = false
        this.errors = body.errors
      },
    },


  }
</script>