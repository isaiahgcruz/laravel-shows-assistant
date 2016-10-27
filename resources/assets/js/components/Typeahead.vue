<template>
  <div style="position: relative;" v-bind:class="{'open': openDropdown}">
    <input
      type="text"
      class="form-control"
      v-model="queryString"
      @input="update"
      @keydown.up="up"
      @keydown.down="down"
      @keydown.enter= "hit"
      @keydown.esc="reset"
      :placeholder="placeholder"
      >
    <ul v-if="results.length" class="dropdown-menu" style="width: 100%">
      <li
        v-for="(result, index) in results"
        v-bind:class="{'active' : isActive(index)}"
        @mousemove="currentIndex = index"
        @mousedown.prevent="hit"
        ><a><partial :result="result" :templatePartial="templatePartial"></partial></a></li>
    </ul>
  </div>
</template>

<script>
  import _ from 'lodash'

  export default {
    props: {
      apiUri: {
        type: String,
        required: true
      },
      templatePartial: {
        type: String,
        required: true
      },
      successCallback: {},
      inputText: {
        type: String
      },
      placeholder: {
        type: String,
        default: ''
      }
    },  

    components: {
      /**
       * Component for the template to be shown on the list
       */
      partial: {
        template: '<div>{{ templatePartial }}</div>',

        props: {
          templatePartial: {
            type: String
          },
          result: {
            type: Object
          }
        },

        created() {
          this.$options.template = this.templatePartial

        }
      }
    },

    watch: {
      /**
       * Updates the search text
       */
      inputText (val) {
        this.queryString = val  
      }
    },

    /**
     * Component's data
     */
    data () {
      return {
        results: {},
        currentIndex: 0,
        openDropdown: false,
        queryString: '',
        loading: false,
      }
    },

    methods: {
      /**
       * API Call to populate results
       */
      update: _.debounce(function () {
          this.$http.get(this.apiUri + this.queryString)
            .then((response) => {
              this.results = response.body
              this.openDropdown = true
            })
        }, 500)
      ,

      /**
       * Key up method
       */
      up () {
        if (this.currentIndex > 0) {
          this.currentIndex -= 1
        }
      },

      /**
       * Key down method
       */
      down () {
        if (this.currentIndex < this.results.length) {
          this.currentIndex += 1 
        }
      },

      /**
       * Class check if the result is active
       */
      isActive (index) {
        return this.currentIndex === index
      },

      /**
       * Select a result
       */
      hit () {
        this.openDropdown = false
        this.successCallback(this.results[this.currentIndex])
      }
    }
  }
</script>

<style>
</style>