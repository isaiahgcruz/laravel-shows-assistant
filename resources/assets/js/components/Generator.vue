<template>
  <div class="panel panel-default">
    <div class="panel-heading">Generate ICS</div>
    <div class="panel-body">
      <div class="form-group">
        <label for="startdate">Start Date: </label>
        <select class="form-control" id="startdate" v-model="startDate">
          <option value="1">From the show's first episode</option>
          <option value="2">Today</option>
          <option value="3">Show's latest season</option>
          <option value="4">Start of the Month</option>
        </select>
      </div>
    </div>
    <div class="panel-footer">
      <button class="btn btn-default" 
        @click="generateICS"
        :disabled="isLoading"
      >Generate .ics</button>
    </div>
  </div>
</template>

<script>
  import { VCALENDAR, VEVENT } from 'ics-js'

  export default {
    /**
     * Component's data
     */
    data () {
      return {
        isLoading: false,
        startDate: 1
      }
    },

    methods: {
      /**
       * Generates the .ics file
       */
      generateICS () {
        const params = {
          user,
          config: this.startDate
        }
        this.isLoading = true
        this.$http.get('api/episodes/', { params })
          .then(({body}) => {
            const cal = new VCALENDAR()
            cal.addProp('VERSION', 2)
            cal.addProp('PRODID', 'Watchlist');
            for(let i in body) {
              const event = new VEVENT()
              event.addProp('UID')
              event.addProp('SUMMARY', body[i].title)
              event.addProp('DTSTART', new Date(body[i].start), { VALUE: 'DATE-TIME' });
              event.addProp('DTSTAMP', new Date(body[i].start), { VALUE: 'DATE-TIME' });
              event.addProp('DTEND', new Date(body[i].end), { VALUE: 'DATE-TIME' });
              cal.addComponent(event)
            }
            download(cal.toBlob(), 'tvshows.ics', 'text/plain')
            this.$bus.$emit('show-alert', 'alert alert-success', 'ICS Generated [' + body.length + ' entries]')
          }, (response) => {
            this.$bus.$emit('show-alert', 'alert alert-danger', 'An error occurred')
          }).finally(() => {
            this.isLoading = false
          })
      },
    }
  }

  /**
   * File download function
   */
  function download(content, filename, contentType) {
    if(!contentType) contentType = 'application/octet-stream';
    var a = document.createElement('a');
    var blob = new Blob([content], {'type':contentType});
    a.href = window.URL.createObjectURL(blob);
    a.download = filename;
    a.click();
  }
</script>