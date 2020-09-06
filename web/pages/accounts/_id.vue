<template>
  <div>
    <div class="container" v-if="loading">loading...</div>
    <div class="container" v-if="!loading">
      <account-details
        :account="account"
        :show="show"
        @toggleShow="toggleShow"
      >

      </account-details>
      <transaction-form
        :account="account"
        :show="show"
        @completed="completeTransaction"
        @toggleShow="toggleShow"
      ></transaction-form>
      <transactions-list :transactions="transactions">

      </transactions-list>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import Vue from "vue";
import AccountDetails from '../../components/AccountDetails.vue';
import TransactionsList from '../../components/TransactionsList.vue';
import TransactionForm from '../../components/TransactionForm.vue';
import {Transaction} from "../../types/Transaction";
import {Account} from "../../types/Account";

export default Vue.extend({

  components: {
    AccountDetails,
    TransactionsList,
    TransactionForm
  },

  data() {
    return {
      show: false,
      loading: true,
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
    toggleShow(value: boolean) {
      this.show = value;
    },
    async completeTransaction(value: boolean) {
      await this.catchAccountData();
      await this.catchAccountTransactionsData();
    }
  }
});
</script>
