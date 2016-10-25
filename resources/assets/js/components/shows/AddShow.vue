<template>
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse1">Add Show</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
          <typeahead
            api-uri="http://api.tvmaze.com/search/shows?q=" 
            :template-partial="templatePartial"
            :success-callback="typeaheadSelect"
            :input-text="typeaheadText"
            placeholder="Search a show"
          ></typeahead>
          <div v-if="result" style="margin-top: 5px">
            <p>{{ result.show.name }} || {{ result.show.premiered }}</p>
            <p>{{ showSummary }}</p>
            <div class="pull-right">
              <button class="btn btn-primary" @click="addShow">Add Show</button>
              <button class="btn btn-default" @click="result = false">Clear</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Typeahead from '../Typeahead.vue'
  export default {
    components: { Typeahead },

    props: {
      user: {
        type: Object
      }
    },

    data () {
      return {
        templatePartial: '<span>{{ result.show.name }} | {{ result.show.premiered }}</span>',
        result: false,
        typeaheadText: ''
      }
    },

    methods: {
      typeaheadSelect (result) {
        this.result = result
        this.typeaheadText = result.show.name
      },
      addShow () {
        this.$http.post('api/users/' + this.user.id + '/shows', this.result)
          .then((response) => {
            this.result = false
            window.alert('Show added successfully')
            this.typeaheadText = ''
          }, (response) => {
            window.alert('An error occurred!')
          })
      }
    },

    computed: {
      showSummary () {
        if (this.result) {
          return strip(this.result.show.summary)
        } else {
          return false
        }
      }
    }
  }

  function strip(html)
  {
     var tmp = document.createElement("DIV");
     tmp.innerHTML = html;
     return tmp.textContent || tmp.innerText || "";
  }
</script>