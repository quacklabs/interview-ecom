import axios from "axios"
import type { APIResponse } from "../types/response";
import type { EstimatePrice, CreateOrder, GatewayTransaction, TransactionForm, GatewayError } from "../types/payments"
import { useNetwork } from "."


export const useGateway = () => {

    const network = useNetwork()

    const request = axios.create({
        baseURL: "https://api.nowpayments.io/v1/",
        timeout: 30000,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'x-api-key' : import.meta.env.VITE_NOWPAYMENT_KEY
        }
    })

    function getPaymentAmount(amount: number, currency: string): Promise<EstimatePrice> {
        return new Promise((resolve, reject) =>  {
            const params: EstimatePrice  = {
                currency_from: "usd",
                currency_to: currency.toLowerCase(),
                amount: Number(amount)
            }
            request.get('estimate', {params: params}).then((response) => {
                resolve(response.data)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    function npCreatePayment(data: CreateOrder): Promise<GatewayTransaction> {
        return new Promise((resolve, reject) => {
            request.post('payment', data).then((response) => {
                resolve(response.data)
            }).catch((error) => {
                reject(error)
            })
        });
    }

    function createPayment(data: TransactionForm): Promise<APIResponse<GatewayError>> {
        return new Promise<APIResponse<GatewayError>>((resolve, reject) => {
            network.push<GatewayError, TransactionForm>('new-deposit', data).then((response) => {
                const err: APIResponse<GatewayError> = {
                    status: true,
                    message: response.message,
                    data: {
                        message: "Awaiting payment"
                    }
                }
                resolve(err)
            }).catch((error) => {
                reject(error)
            })
        });
    }

    function npCheckStatus(id: string): Promise<GatewayTransaction> {
        return new Promise((resolve, reject) => {
            request.get('payment/'+id).then((response) => {
                resolve(response.data)
            }).catch((error) => {
                reject(error)
            })
        })
    }

    return { getPaymentAmount, npCreatePayment, npCheckStatus, createPayment }
}