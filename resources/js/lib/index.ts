// export { useAuth  } from './auth'
export { useNetwork } from './request'
export { notify } from './notifications'
export { useGateway } from './gateway'
export { appLayout } from './layout'
export { useConfig } from './appConfig'
export { accountService } from './accountService'
export { useAuth } from './auth'
export { useProfile } from './profileService'
export { default as CountryData } from './countryData'
export const formatCurrency = (value: number) => {
    return value.toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 });   
}