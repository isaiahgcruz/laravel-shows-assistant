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
        <div class="panel panel-default">
          <div class="panel-heading">Shortcuts</div>
          <div class="panel-body">
            <button class="btn btn-default" 
              @click="generateICS"
            >Generate .ics</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import UpcomingEpisodes from './UpcomingEpisodes.vue'
  import { VCALENDAR, VEVENT } from 'ics-js'

  export default {
    components: { 
      UpcomingEpisodes
    },

    props: {
      user: {
        type: Object
      }
    },

    methods: {
      generateICS () {
        const params = {
          user: this.user
        }
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
            console.log(cal.toBlob())
            download(cal.toBlob(), 'tvshows.ics', 'text/plain')
          })
      }
    }
  }

  function download(content, filename, contentType)
  {
    if(!contentType) contentType = 'application/octet-stream';
    var a = document.createElement('a');
    var blob = new Blob([content], {'type':contentType});
    a.href = window.URL.createObjectURL(blob);
    a.download = filename;
    a.click();
  }
</script>