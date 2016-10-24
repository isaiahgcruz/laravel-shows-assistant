<template>
  <div class="container">
    <add-show></add-show>
    <div class="panel panel-default">
      <div class="panel-heading">Shows</div>

      <div class="panel-body">
        Shows list
      </div>
    </div>
  </div>
</template>

<script>
  import AddShow from './AddShow.vue';
  export default {
    components: { AddShow },
  }
</script>