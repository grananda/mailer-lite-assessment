<template>
  <div>
    <b-card class="mt-3" header="Payment History">
      <b-table striped hover :items="transactions"></b-table>
    </b-card>
  </div>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
  name: "TransactionsList",
  props: {
    transactions: {
      type: Array,
      required: true,
    },
  }
});
</script>

