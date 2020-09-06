import {Account} from "~/types/Account";

export interface Transaction {
  amount: number;
  currency: string;
  details: string;
  account_from: Account;
  account_to: Account;
}
