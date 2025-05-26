<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <img  :src="logo" alt="logo" class="mb-5 w-6rem flex-shrink-0" />
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <div class="text-900 text-3xl font-medium mb-3">Forgot Password?</div>
                        <span class="text-600 font-medium">Enter your email to continue</span>
                    </div>

                    <form @submit.prevent="handleLogin">
                      <div>
                        <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                        <InputText id="email1" type="text" placeholder="Email address" class="w-full mb-5" style="padding: 1rem" v-model="form.email" />

                        <Button label="Request Password Reset"
                          class="w-full p-3 text-xl"
                          type="submit" :disabled="isLoading">
                        </Button>
                      </div>
                    </form>
                </div>

                <div class="w-full mt-2 justify-content-center text-center">
                    <router-link :to="{name: 'Login'}" style="color: var(--primary-color)" class="font-medium no-underline ml-2 text-right cursor-pointer">
                        Back to Login  
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
// @ts-ignore
import { useGlobalLoader } from 'vue-global-loader'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { notify, useAuth } from '../lib'
import type { APIError } from '../types/response'
import { useConfig } from '../lib/appConfig'

export default defineComponent({
    setup() {
      const router = useRouter()
      const { logo } = useConfig()
      const authHandler = useAuth()

      const form = reactive({
        email: '',
      })

      const rules = computed(() => {
        return {
          email: { required, email },
        }
      })

      const { displayLoader, destroyLoader, isLoading } = useGlobalLoader()
      const v$ = useVuelidate(rules, form)

      const handleLogin = async () => {
        displayLoader()

        authHandler.forgot_password({email: form.email}).then((resp) => {
          destroyLoader()
            notify({
                title: 'Success',
                text: resp,
                type: 'success',
                speed: 0.1,
                duration: 50
            })
            setTimeout(() => {
                router.push({
                    name: 'ForgotPasswordSuccess'
                })
            },5000);
        }).catch((error: APIError) => {
          destroyLoader()
            notify({
                title: 'Error',
                text: error.message,
                duration: 50,
                type: 'error'
            })
        })
      };

      return { form, v$, isLoading, handleLogin, logo }
    },
})
</script>