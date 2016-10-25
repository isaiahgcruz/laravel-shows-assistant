<template>
  <div class="container">
    <add-show :user="user"></add-show>
    <shows-list></shows-list>
  </div>
</template>

<script>
  import AddShow from './AddShow.vue';
  import ShowsList from './ShowsList.vue';

  export default {
    components: { AddShow, ShowsList },

    props: {
      user: {
        type: Object
      }
    }
  }
</script>