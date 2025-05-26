<template>
  <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <img :src="logo" alt="logo" class="mb-5 w-6rem flex-shrink-0" />
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="@/assets/images/avatar.png" alt="Image" height="50" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3">Welcome!</div>
                        <span class="text-600 font-medium">Sign Up to continue</span>
                    </div>

                    <form @submit.prevent="handleSubmit">
                      <div class="grid w-full justify-content-center">

                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="email1" class="block text-900 text-xl font-medium mb-2">Username</label>
                          <InputText id="email1" type="text" placeholder="Username" class="w-full" style="padding: 1rem" v-model="form.username" inputClass="w-full"/>
                          <InlineMessage class="w-full" severity="warn" v-if="v$.username.$error"> {{ v$.fullname.$errors[0].$message }} </InlineMessage> 
                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="email1" class="block text-900 text-xl font-medium mb-2">Full Name</label>
                          <InputText id="fullname" type="text" placeholder="Full Name" class="w-full" style="padding: 1rem" v-model="form.fullname" inputClass="w-full" />
                          <InlineMessage class="w-full" severity="warn" v-if="v$.fullname.$error"> {{ v$.fullname.$errors[0].$message }} </InlineMessage> 

                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="email1" class="block text-900 text-xl font-medium">Email</label>
                          <InputText id="email1" type="text" placeholder="Email address" class="w-full mb-2" style="padding: 1rem" v-model="form.email" inputClass="w-full" />
                          <InlineMessage class="w-full" severity="warn" v-if="v$.email.$error"> {{ v$.email.$errors[0].$message }} </InlineMessage> 

                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="password1" class="block text-900 font-medium text-xl">Password</label>
                          <Password id="password1" v-model="form.password" placeholder="Password" :toggleMask="true" class="w-full mb-2" inputClass="w-full" :inputStyle="{ padding: '1rem' }" :feedback="true"></Password>
                          <InlineMessage class="w-full" severity="warn" v-if="v$.password.$error"> {{ v$.password.$errors[0].$message }} </InlineMessage> 

                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="password1" class="block text-900 font-medium text-xl mb-2">Confirm Password</label>
                          <Password id="password1" v-model="form.confirm_password" placeholder="Confirm Password" :toggleMask="true" class="w-full mb-2" inputClass="w-full" :inputStyle="{ padding: '1rem' }" :feedback="false"></Password>
                          <InlineMessage class="w-full" severity="warn" v-if="v$.confirm_password.$error"> {{ v$.confirm_password.$errors[0].$message }} </InlineMessage> 
                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="email1" class="block text-900 text-xl font-medium mb-2">Phone Number</label>
                          <InputText id="email1" type="text" placeholder="Phone Number" class="w-full mb-2" style="padding: 1rem" v-model="form.phone" inputClass="w-full"/>
                          <InlineMessage class="w-full" severity="warn" v-if="v$.phone.$error"> {{ v$.phone.$errors[0].$message }} </InlineMessage> 

                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="email1" class="block text-900 text-xl font-medium mb-2">Country</label>
                          <Dropdown v-model="form.country" :options="countries" optionValue="countryShortCode" optionLabel="countryName" :filter="true" :showClear="true" placeholder="Select a country" class="w-full" inputClass="w-full" />
                          <InlineMessage class="w-full" severity="warn" v-if="v$.country.$error"> {{ v$.country.$errors[0].$message }} </InlineMessage> 
                        </div>

                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="email1" class="block text-900 text-xl font-medium mb-2">Date of Birth</label>
                          <Calendar v-model="form.dob" :maxDate="maxDate" :manualInput="false" class="w-full" inputClass="w-full" />
                          <InlineMessage class="w-full" severity="warn" v-if="v$.country.$error"> {{ v$.country.$errors[0].$message }} </InlineMessage> 
                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <label for="email1" class="block text-900 text-xl font-medium mb-2">Zip Code</label>
                          <InputText id="email1" type="text" placeholder="ZIP" class="w-full mb-2" style="padding: 1rem" v-model="form.zip" inputClass="w-full" />
                          <InlineMessage class="w-full" severity="warn" v-if="v$.zip.$error"> {{ v$.zip.$errors[0].$message }} </InlineMessage> 

                        </div>

                        <div class="col-12 mb-3 md:col-6 lg:col-6">
                          <div class="flex align-items-left justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center">
                              <Checkbox id="rememberme1" :binary="true" class="mr-2" v-model="form.accept"></Checkbox>
                              <label for="rememberme1">I have read and agreed to the <router-link style="color: green;" :to="{name: 'Terms'}">Terms & Conditions</router-link></label>
                              <InlineMessage class="w-full" severity="warn" v-if="v$.accept.$error"> {{ v$.accept.$errors[0].$message }} </InlineMessage> 

                            </div>
                          </div> 
                        </div>
                        
                        <div class="col-12 mb-3 md:col-6 lg:col-6">
      
                          <Button label="Register" class="align-center justify-center p-3 text-xl"
                            type="button" @click="handleSubmit">
                          </Button>
                        </div>
                        <!-- -->
                        <!-- <Button label="Sign In" class="w-full p-3 text-xl"></Button> -->
                        <!--  -->
                      </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
  
  
</template>
  
<script lang="ts">
// @ts-ignore
import { defineComponent, reactive, computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength, maxLength, alphaNum, sameAs, numeric, helpers } from '@vuelidate/validators'
import { useAuth, notify } from '../lib'
import type { Register } from '../types/Auth'
import type { APIError } from '../types/response'

// import { CountrySelect } from '../components/Widgets'
import { useGlobalLoader } from 'vue-global-loader'
import { useRouter  } from 'vue-router'
import { useConfig, CountryData } from '../lib'
import DropDown from 'primevue/dropdown'
import Calendar from 'primevue/calendar';

export default defineComponent({
  setup() {
      const router = useRouter()
      const auth = useAuth()
      const { logo } = useConfig()
      const form = reactive({
          fullname: '',
          username: '',
          email: '',
          phone: '',
          password: '',
          confirm_password: '',
          country: '',
          dob: '',
          zip: '',
          accept: false,
      })

      const rules = computed(() => {
          return {
              fullname: { required, minLength: minLength(6) },
              username: { required, minLength: minLength(6) },
              email: { required, email },
              phone: { required, numeric },
              password: { required, minLength: minLength(8), alphaNum },
              confirm_password: { required, sameAs: helpers.withMessage('Passwords do not match', sameAs(form.password)) },
              country: { required },
              dob: { required },
              accept: { required: helpers.withMessage('You must accept the terms and conditions', required), sameAs: helpers.withMessage('You must accept the terms and conditions', sameAs(true))  },
              zip: { required }
          }
      })

      const { displayLoader, destroyLoader, isLoading } = useGlobalLoader()

      const v$ = useVuelidate(rules, form)

      const handleSubmit = async () => {
          const validate = await v$.value.$validate()

          if(!validate) {
            console.log('validation failed')
              return
          }
          displayLoader()
          const data: Register = {
              username: form.username,
              email: form.email,
              password: form.password,
              fullname: form.fullname,
              phone: form.phone,
              dob: form.dob,
              country: form.country,
              zip: form.zip
          }

          auth.signup(data).then((data) => {
              destroyLoader()
              notify({
                  title: 'Registration Successful',
                  text: 'Please wait while you are redirected',
                  type: 'success'
              })
              setTimeout(() => {
                  router.push({name: 'RegistrationSuccess'})
              }, 3000);
              
          }).catch((error) => {
              destroyLoader()
              const message = error as APIError
              notify({
                  title: 'Registration Failed',
                  text: message.message,
                  duration: 10000,
                  type: 'info'
              })
          }).finally(() => {
              destroyLoader()
          })
      };

      const countries = computed(() => {
        let countryList = CountryData.map((country) => {
          const item: Country = {
            countryName: country.countryName,
            countryShortCode: country.countryShortCode
          }
          return item
        })
        return countryList
      })
      let today = new Date();
      let month = today.getMonth();
      let prevMonth = (month === 0) ? 11 : month -1;
      const maxDate = ref(new Date());
      maxDate.value.setMonth(prevMonth);
      return { form, v$, handleSubmit, isLoading, logo, countries, maxDate }
  },
  components: {
    DropDown,
    Calendar
  }
})
</script>
