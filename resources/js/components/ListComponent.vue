<template>
  <div class="card col-12 col-sm-8 offset-sm-2 col-md-8 offset-md-2">
    <table class="table text-center">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Word</th>
          <th scope="col">Count</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,i) in list" :key="i">
          <th scope="row">{{item.id}}</th>
          <th scope="row">{{item.word}}</th>
          <th scope="row">{{item.count}}</th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["list"]
};
</script>
