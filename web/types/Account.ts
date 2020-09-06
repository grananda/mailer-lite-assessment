import {User} from "~/types/User";
import {Currency} from "~/types/Currency";

export interface Account {
  id: number,
  account_number: number;
  balance: number;
  owner: User;
  currency: Currency;
}
