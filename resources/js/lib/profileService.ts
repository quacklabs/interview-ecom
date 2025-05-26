import { useNetwork } from "."
import type { UserProfile, PasswordUpdate, BankInfo, WithdrawChannels, WalletInfo } from '../types/Account'

export const useProfile = () => {

    const network = useNetwork()
    
    const getProfile = (): Promise<UserProfile> => {
        return new Promise<UserProfile>((resolve, reject) => {
            network.fetch<UserProfile, {}>('get_profile').then((profile) => {
                resolve(profile.data!)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    

    const updatePassword = (data: PasswordUpdate): Promise<Boolean> => {
        return new Promise<Boolean>((resolve, reject) => {
            network.push<Boolean, PasswordUpdate>('update_password', data).then((profile) => {
                resolve(profile.data!)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    const updateProfile = (data: UserProfile) => {
        return new Promise<Boolean>((resolve, reject) => {
            network.push<Boolean, UserProfile>('update_profile', data).then((profile) => {
                resolve(profile.data!)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    return { getProfile, updatePassword, updateProfile }
}