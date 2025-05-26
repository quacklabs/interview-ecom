interface Account {
    get balance() : string
    get name(): string
}

interface Balances {
  wallet?: number
}

interface UserProfile {
  email: string
  fullname: string
  dob: string
  phone: string
  zip: string
  country: string
}

interface PasswordUpdate {
  old_password: string
  new_password: string
}

export type { Account, Balances, BankInfo, WalletInfo, WithdrawChannels, UserProfile, PasswordUpdate, ActiveTrading }