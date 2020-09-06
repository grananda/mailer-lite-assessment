<template>
  <div>
    <b-card :header="'Welcome, ' + account.owner.name" class="mt-3">
      <b-card-text>
        <div>
          Account Number: <code>{{ account.account_number }}</code>
        </div>
        <div>
          Balance:
          <code>
            {{ account.balance }}
          </code>
        </div>
      </b-card-text>

      <b-button size="sm" variant="success" @click="displayForm">
        New payment
      </b-button>

      <b-button
        class="float-right"
        variant="danger"
        size="sm"
        nuxt-link
        to="/"
      >Logout
      </b-button
      >
    </b-card>
  </div>
</template>

<script lang="ts">
import Vue, {PropOptions} from "vue";
import {Account} from "~/types/Account";

export default Vue.extend({
  name: "AccountDetails",
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    account: {
      type: Object,
      required: true,
    } as PropOptions<Account>,
  },
  methods:{
    displayForm() {
      this.$emit('toggleShow', !this.show)
    },
  }
});
</script>
