import { useNetwork } from ".";
import type { Balances, WithdrawChannels } from '../types/Account'
import type { Transaction } from "../types/payments";
import type { APIResponse } from "../types/response";

export const accountService = () => {

    const network = useNetwork()
    
    const formatCurrency = (value: number) => {
        return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    };

    const balances = (): Promise<Balances> => {
        return new Promise<Balances>((resolve, reject) => {
            network.fetch<Balances, {}>('user_balance').then((response: any) => {
                // console.log(response)
                resolve(response.data)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    const recentTransactions = async (): Promise<Transaction[]> => {
        return new Promise<Transaction[]>((resolve, reject) => {
            network.fetch<Transaction[], {}>('recent_transactions').then((response: any) => {
                // console.log(response)
                resolve(response.data)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    const getWalletBalance = (): Promise<number> => {
        return new Promise<number>((resolve, reject) => {
            network.fetch<number, {}>('wallet_balance').then((response: any) => {
                // console.log(response)
                resolve(response.data)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    const getWithdrawalChannels = (): Promise<WithdrawChannels> => {
        return new Promise<WithdrawChannels>((resolve, reject) => {
            network.fetch<WithdrawChannels, {}>('withdraw_channels').then((response: any) => {
                // console.log(response)
                resolve(response.data)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    return { formatCurrency, balances, recentTransactions, getWalletBalance, getWithdrawalChannels }
}