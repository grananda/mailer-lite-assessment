<template>
  <div>
    <b-alert class="mt-3" variant="danger" :show="displayErrorMessage">{{ message }}</b-alert>

    <b-card class="mt-3" header="New Payment" v-show="show">
      <b-form>
        <b-form-group id="input-group-1" label="To:" label-for="input-1">
          <b-form-input
            id="input-1"
            size="sm"
            v-model="payment.target_account"
            type="string"
            required
            placeholder="Destination ID"
          ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
          <b-input-group prepend="$" size="sm">
            <b-form-input
              id="input-2"
              v-model="payment.amount"
              type="number"
              required
              placeholder="Amount"
            ></b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group id="input-group-3" label="Details:" label-for="input-3">
          <b-form-input
            id="input-3"
            size="sm"
            v-model="payment.details"
            required
            placeholder="Payment details"
          ></b-form-input>
        </b-form-group>

        <b-button @click="transferAmount" size="sm" variant="primary">Submit</b-button>
      </b-form>
    </b-card>
  </div>
</template>

<script lang="ts">
import Vue, {PropOptions} from "vue";
import axios from "axios";
import {Payment} from "../types/Payment";
import {Account} from "../types/Account";

export default Vue.extend({
  name: "TransactionForm",
  data() {
    return {
      message: null,
      displayErrorMessage: false,
      payment: {} as Payment,
    };
  },
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
  methods: {
    async transferAmount() {
      let that = this;

      await axios.post(
        `http://localhost:8000/api/accounts/${that.account.id}/transactions`,
        this.payment
      )
        .then((response) => {
          that.$emit('completed', true)
        })
        .catch((err) => {
          that.message = err.response.data.message;
          that.displayErrorMessage = true;
          setTimeout(() => {
            that.displayErrorMessage = false;
          }, 5000);

        })
        .finally(() => {
          that.payment = {} as Payment;
          that.$emit('toggleShow', !this.show)
        });
    },
  }
});
</script>

<style scoped>

</style>
