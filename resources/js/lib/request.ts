import type { APIResponse, APIError } from "../types/response";
import axios, { type AxiosInstance, type AxiosRequestConfig } from "axios";
import { computed, type ComputedRef } from "vue";
import { useAuth } from "./auth";
import { StorageModule } from "./store";


enum RequestType {
    json = 'json',
    file = 'file',
    unknown = 'json' // we'll use a json default fallback for now. 
}

export const useNetwork = () => {

    const handler = axios.create({
        baseURL: import.meta.env.VITE_API_BASE_URL || window.location.origin,
        timeout: 60000,
    })

    const auth_header = computed(() => {
        const local = StorageModule.getInstance()
        const client = local.get('broker_user')
        const authUser = client ? JSON.parse(client) : null
        if(authUser) {
            return authUser.token ? 'Bearer ' + authUser.token : ''
        }
        return ''
    })

    const config = (multipart: boolean | false) => {
        return  {
            headers: {
                "Content-Type" : (multipart == false) ? 'application/json' : 'multipart/form-data',
                "Accept" : 'application/json',
                "Authorization" : auth_header.value,
                "Access-Control-Allow-Origin": "*"
            }
        }
    }

    function push<T, S>(endpoint: string, data: S, type: RequestType = RequestType.json): Promise<APIResponse<T>> {
        return new Promise<APIResponse<T>>((resolve, reject) => {
            handler.post(endpoint, data, config(type == RequestType.file))
            .then((response) => {
                if(response.status == 200 || response.status == 201) {
                    const resp: APIResponse<T> = {
                        status: true,
                        message: response.statusText,
                        data: response.data as T
                    }
                    resolve(resp)
                } else {
                    const APIError: APIError = {
                        status: false,
                        message: response.data.message
                    }
                    reject(APIError)
                }
            })
            .catch((error) => {
                console.error('API request error:', error);
                const err: APIError = {
                    status: false,
                    message: error.response?.data?.message || 'Network error. Please check your connection.'
                }
                reject(err)
            })
        });
    }

    function fetch<T, S>(endpoint: string, data?: S): Promise<APIResponse<T>> {
        return new Promise<APIResponse<T>>((resolve, reject) => {
            // console.log(this.config())
            handler.get(endpoint, config.value)
            .then((response) => {
                // const params = response.data
                if(response.status == 200 || response.status == 201) {
                    const resp: APIResponse<T> = {
                        status: true,
                        message: response.statusText,
                        data: response.data as T
                    }
                    resolve(resp)
                } else {
                    console.log('invalid request, will reject')
                    const APIError: APIError = {
                        status: false,
                        message: "Unknown error, please check your internet connection"
                    }
                    reject(APIError)
                }
            })
            .catch((error) => {
                console.error('API fetch error:', error)
                const message: APIError = {
                    message: error.response?.data?.message || 'Network error. Please check your connection.',
                    status: false
                }
                reject(message)
            })
        });
    }

    return { push, fetch }
}