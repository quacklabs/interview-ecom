import type { Register, AuthState, LoginForm, RefreshToken, PasswordResetRequest, PasswordReset } from "../types/Auth";
import type { APIResponse, APIError } from "../types/response";
import { useNetwork } from "../lib"
import { StorageModule } from "../lib/store";
import { computed, ref, watch } from "vue";

import { useRouter, useRoute } from "vue-router";

export const useAuth = () => {

  const network = useNetwork()

  const user = computed(() => {
    return state.value.user
  })
  const token = computed(() => {
    return state.value.token
  })

  const state = ref<AuthState>({
    user: null,
    error: null,
    refreshTokenTimeout: null,
    token: null
  });

  const isAdmin = computed(() => {
    return user.roles?.includes('admin') || false
  })

  const router = useRouter();
  const route = useRoute()
  const local = StorageModule.getInstance()

  const login = (credentials: LoginForm): Promise<APIError | null> => {
    return new Promise<APIError | null>((resolve, reject) => {
      network.push<AuthState, LoginForm>('login', credentials).then((response) => {
        if(response.status === true && response.data) {
          state.value = response.data
          state.value.error = null,
          state.value.refreshTokenTimeout = null
        }
        local.save('broker_user', response.data)
        startRefreshTokenTimer()
        resolve(null)
      }).catch((error: any) => {
        reject(error as APIError)
      })
    })
  }

  const refreshToken = async () => {
    network.fetch<RefreshToken, {}>('refresh_token')
      .then((token) => {
        state.value.token = token.data?.token
        startRefreshTokenTimer()
      }).catch((error) => {
        console.log(error)
        stopRefreshTokenTimer()
    })
  }

  const startRefreshTokenTimer = () => {
    stopRefreshTokenTimer()
    // parse json object from base64 encoded jwt token
    const jwtBase64 = state.value.token?.split('.')[1];
    if(jwtBase64) {
      const jwtToken = JSON.parse(atob(jwtBase64));
      const expires = new Date(jwtToken.exp * 1000);
      const timeout = expires.getTime() - Date.now() - (60 * 1000);
      state.value.refreshTokenTimeout = setTimeout(refreshToken, timeout);
    }
  }

  const signup = (userData: Register): Promise<APIError | null> => {
    return new Promise<APIError | null>((resolve, reject) => {
      // console.log(userData)
      network.push('register', userData).then((response) => {
          resolve(null)
      }).catch((error) => {
        reject(error as APIError)
      })
    })
  }

  const forgot_password = (email: PasswordResetRequest): Promise<string> => {
    return new Promise<string>((resolve, reject) => {
      network.push<string, PasswordResetRequest>('forgot-password', email).then((response) => {
          resolve(response.data!)
      }).catch((error) => {
        reject(error as APIError)
      })
    })
  }

  const reset_password = (data: PasswordReset): Promise<Boolean> => {
    return new Promise<Boolean>((resolve, reject) => {
      network.push<string, PasswordReset>('reset-password', data).then((response) => {
        resolve(true)
      }).catch((error) => {
        reject(error as APIError)
      })
    })
  }

  const stopRefreshTokenTimer = () => {
      clearTimeout(state.value.refreshTokenTimeout ?? 'refreshToken')
  }

  const logout = () => {
    local.remove('broker_user');
  }

  const loadSession = () => {
    try {
      const client = local.get('_app_user')
      
      const authUser = client ? JSON.parse(client) : null
      if(authUser) {
        state.value.user = authUser
      }
      if(authUser.token){
        state.value.token = authUser.token
        refreshToken()
      }
    } catch (err) {
      console.log(err)
    } finally {
      return
    }
  };

  watch(user, (newVal) => {
    if(newVal !== null) {
      const data: AuthState = {
        user: newVal,
        token: token.value,
      }
      local.save('_app_user', data);
    } else {
      router.replace({name: 'Login'})
    }
  })

  watch(token, (newVal) => {
    if(newVal !== null) {
      const data: AuthState = {
        user: user.value,
        token: newVal,
      }
      local.save('_app_user', data);
    }
  })
  loadSession()
  return { login, logout, user, token, signup, forgot_password, reset_password, isAdmin }
}