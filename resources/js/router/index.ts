import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import { useAuth } from '../lib'
import { HomeLayout, AppLayout } from '../layout'

import { 
  Home, 
  Login,  
  Register,
  Dashboard,
  NotFound,
  RegistrationSuccess,
  VerificationStatus,
  ForgotPassword,
  ForgotPasswordSuccess,
  ResetPassword,
  ErrorPage,
  ResetSuccess,
  VerificationFailed,
  VerificationSuccess,
  ResendSuccess,
} from '../views'


const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "Landing",
    component: HomeLayout,
    meta: { requiresAuth: false },
    children: [
      {
        path: '/',
        name: 'Home',
        component: Home
      }
    ]
  },
  {
    path: '/auth',
    name: 'Auth',
    meta: { requiresAuth: false },
    children: [
      {
        path: 'login',
        name: 'Login',
        component: Login
      },
      {
        path: 'register',
        name: 'Register',
        component: Register
      },
      {
        path: 'logout',
        name: 'logout',
        beforeEnter: (to, from, next) => {
          const authHandler = useAuth()
          authHandler.logout()
          next({name: 'Login'})
        },
        redirect: {name: 'Login'}
      },
      {
        path: 'register-successful',
        name: 'RegistrationSuccess',
        component: RegistrationSuccess
      },
      {
        path: 'email/verification-status/:email',
        name: 'VerificationStatus',
        component: VerificationStatus
      },
      {
        path: 'verification-success',
        name: 'VerificationSuccess',
        component: VerificationSuccess
      },
      {
        path: 'email-resend',
        name: 'ResendSuccess',
        component: ResendSuccess
      },
      {
        path: 'verification-failed',
        name: 'VerificationFailed',
        component: VerificationFailed
      },
      {
        path: 'forgot-password',
        name: 'ForgotPassword',
        component: ForgotPassword
      },
      {
        path: 'request-reset-success',
        name: 'ForgotPasswordSuccess',
        component: ForgotPasswordSuccess
      },
      {
        path: 'reset-password/:email/:token',
        name: 'ResetPassword',
        component: ResetPassword,
        props: true
      },
      {
        path: 'reset-failed',
        name: 'ResetFailed',
        component: ErrorPage
      },
      {
        path: 'reset-success',
        name: 'ResetSuccess',
        component: ResetSuccess
      }
    ]
  },
  {
    path: '/account',
    name: 'App',
    component: AppLayout,
    meta: { requiresAuth: true, rbac: true },
    children: [
      {
        path: 'dashboard',
        name: 'Account',
        component: Dashboard
      },
    ]
  },
  // {
  //   path: '/cart',
  //   name: 'App',
  //   component: AppLayout,
  //   meta: { requiresAuth: true},
  //   children: [
  //     {
  //       path: '/',
  //       name: 'Account',
  //       component: Cart
  //     },
  //   ]
  // }
  { path: '/:pathMatch(.*)*', component: NotFound },
    
]
const env = import.meta.env.VITE_APP_ENV
const base = (env === 'production') ? '/' : '/e-broker/'
const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const authHandler = useAuth()
    if (requiresAuth) {
      if (!authHandler.user || !authHandler.token) {
        authHandler.logout()
        next({name: 'Login'});
      } else {
        const rbac_enabled = to.matched.some(record => record.meta.rbac);

        if(rbac_enabled) {
          next()
        } else{
          if(authHandler.user.assigned_roles.includes('admin')) {
            next()
          } else {
            next({name: 'Home'})
          }
        }
      }
    } else {
      next();
    }
  });
  
  export default router