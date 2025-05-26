export interface InvestmentPlan {
    id: number
    name: string
    description: string
    investment_term: string
    return_percent: number
    min_amount: string
    active: Boolean
    details: InvestmentPlanDetail[]
}

export interface InvestmentPlanDetail {
    plan_id: number
    feature: string
}

export interface InvestmentBooking {
    plan_id: number
    amount: Number
}

export interface Investment {
    amount: number
    approved: boolean
    status: boolean
    created_at: string
    plan: InvestmentPlan
    totalProfit: number
    pnl?: number
    maturity?: string
}

export interface ProfitMetrics {
    labels: string[]
    datasets: ProfitMetric[]
}

export interface ProfitMetric {
    label: 'First Dataset'
    data: number[]
    fill: boolean
    borderColor: string,
    tension: number
}