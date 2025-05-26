interface MinAmount {
    currency_from: string // eth,
    currency_to: string // trx,
    min_amount?: number | undefined//0.0078999,
    fiat_equivalent?: number | undefined// 35.40626584
    is_fixed_rate: boolean | false
    is_fee_paid_by_user: boolean | true
}

interface TransactionForm {
    payment_id: string // => [required],
    price_amount: number // => [required, decimal],
    pay_amount: number // => [required, decimal],
    price_currency: string // => [required, string],
    pay_currency: string // => [required, string],
    order_description: string | null | undefined // => [string, nullable],
    order_id: string | null | undefined // => [nullable, string],
    payment_status: string // => [required, string],
}

interface GatewayError {
    message: string
    errors?: Array<string>
    error?: string
}
interface Transaction {
    id: number
    payment_id: string
    price_amount: number
}

export type { MinAmount, EstimatePrice, CreateOrder, GatewayTransaction, TransactionForm, GatewayError, Transaction }