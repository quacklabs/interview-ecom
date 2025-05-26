interface APIResponse<T> {
    status: Boolean | undefined
    message: string | undefined
    data: T | undefined
}

interface APIError {
    status: Boolean
    message: string | undefined
}

export type { APIResponse, APIError }