import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";
import Home from "./../views/Home.vue";
import Login from "./../views/Login.vue";
import Register from "./../views/Register.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: Home,
    },
    {
      path: "/login",
      name: "login",
      component: Login,
    },
    {
      path: "/register",
      name: "register",
      component: Register,
    },
  ],
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  
  if (authStore.isAuthenticated && to.name === 'login') next('/');
  else if (authStore.isAuthenticated && to.name === 'register') next('/');
  else if (!authStore.isAuthenticated && to.name !== "login" && to.name !== "home" && to.name !== "register")
    next({ name: "login" });
  else next();
});

export default router;
