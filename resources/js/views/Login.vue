<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <img  :src="logo" alt="logo" class="mb-5 w-6rem flex-shrink-0" />
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="@/assets/images/avatar.png" alt="Image" height="50" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
                        <span class="text-600 font-medium">Sign in to continue</span>
                    </div>

                    <form @submit.prevent="handleLogin">
                      <div>
                        <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                        <InputText id="email1" type="text" placeholder="Email address" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="form.email" />

                        <label for="password1" class="block text-900 font-medium text-xl mb-2">Password</label>
                        <Password id="password1" v-model="form.password" placeholder="Password" :toggleMask="true" class="w-full mb-3" inputClass="w-full" :inputStyle="{ padding: '1rem' }" :feedback="false"></Password>

                        <div class="flex align-items-center justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center">
                                <Checkbox id="rememberme1" binary class="mr-2"></Checkbox>
                                <label for="rememberme1">Remember me</label>
                            </div>
                            <router-link :to="{name: 'ForgotPassword'}" style="color: var(--primary-color)" class="font-medium no-underline ml-2 text-right cursor-pointer">
                              Forgot password?
                            </router-link>
                        </div>
                        <!-- <Button label="Sign In" class="w-full p-3 text-xl"></Button> -->
                        <Button label="Sign In"
                          class="w-full p-3 text-xl"
                          type="submit" :disabled="isLoading">
                        </Button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref, computed } from 'vue'
import { useAuth } from '../lib';
import { useRouter } from 'vue-router'
// @ts-ignore
import { useGlobalLoader } from 'vue-global-loader'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { notify } from '../lib'
import type { APIError } from '../types/response'
import { useConfig } from '../lib/appConfig'

export default defineComponent({
    setup() {
      const router = useRouter()
      const { logo } = useConfig()
      const authHandler = useAuth()

      const form = reactive({
        email: '',
        password: ''
      })

      const rules = computed(() => {
        return {
          email: { required, email },
          password: { required },       
        }
      })

      const { displayLoader, destroyLoader, isLoading } = useGlobalLoader()
      const v$ = useVuelidate(rules, form)

      const handleLogin = async () => {
        // isLoading.value = true;
        // error.value = null;
        displayLoader()

        authHandler.login({email: form.email, password: form.password})
        .then((response) => {
          destroyLoader()
          notify({
            title: 'Login Successful',
            text: 'redirecting to dashboard...',
            type: 'success'
          })
          setTimeout(() => {
            router.push({name: 'Account'})
          }, 300);
        }).catch(error => {
          destroyLoader()
          const message = error as APIError
          notify({
            title: 'Login Failed',
            text: message.message,
            type: 'info'
          })
        })
      };

      return { form, v$, isLoading, handleLogin, logo }
    },
})
</script>