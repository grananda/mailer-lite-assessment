<template>
  <div>
    <div class="container" v-if="loading">loading...</div>

    <div class="container" v-if="!loading">
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

        <b-button size="sm" variant="success" @click="show = !show">
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

      <b-card class="mt-3" header="Payment History">
        <b-table striped hover :items="transactions"></b-table>
      </b-card>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import Vue from "vue";

interface User {
  name: string;
  email: string;
}

interface Account {
  id: number,
  account_number: number;
  balance: number;
  owner: User;
  currency: Currency;
}

interface Currency {
  symbol: string;
  code: string;
}

interface Transaction {
  amount: number;
  currency: string;
  details: string;
  account_from: Account;
  account_to: Account;
}

interface Payment {
  amount: number,
  account_from: string,
  target_account: string,
}

export default Vue.extend({

  data() {
    return {
      show: false,
      loading: true,
      message: null,
      displayErrorMessage: false,
      payment: {} as Payment,
      account: {} as Account,
      transactions: [] as Transaction[],
    };
  },

  async mounted() {
    await this.catchAccountData();
    await this.catchAccountTransactionsData();
  },

  methods: {
    async catchAccountData() {
      let that = this;

      await axios
        .get(`http://localhost:8000/api/accounts/${this.$route.params.id}`)
        .then((response) => {
          that.account = response.data;

          if (that.account && that.transactions) {
            that.loading = false;
          }
        })
        .catch((err) => {
          that.$router.push('/')
        });
    },
    async catchAccountTransactionsData() {
      let that = this;

      await axios
        .get(`http://localhost:8000/api/accounts/${that.account.id}/transactions`)
        .then((response) => {
          that.transactions = response.data;

          if (that.account && that.transactions) {
            that.loading = false;
          }
        });
    },
    async transferAmount() {
      let that = this;

      await axios.post(
        `http://localhost:8000/api/accounts/${that.account.id}/transactions`,
        this.payment
      )
        .then((response) => {
          this.catchAccountData();
          this.catchAccountTransactionsData();
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
          that.show = false;
        });
    }
  }
});
</script>
