<script setup>
import { onBeforeMount } from "vue";
import { useAuthStore } from "../stores/auth";


const authStore = useAuthStore();

const handleLogout = () => {
  authStore.logout();
}
</script>

<template>
  <header class="bg-indigo-100 px-8 py-4">
    <nav class="flex justify-between items-center text-white">
      <div class="text-2xl font-bold text-indigo-800">Logo</div>

      <ul class="flex gap-4 items-center">
        <li class="text-indigo-500 hover:text-indigo-800 transition-colors">
          <router-link to="/">Home</router-link>
        </li>
        <li class="text-indigo-500 hover:text-indigo-800 transition-colors">
          <router-link to="/products">Products</router-link>
        </li>
        <template v-if="!authStore.isAuthenticated">
            <li class="text-indigo-500 hover:text-indigo-800 transition-colors">
              <router-link to="/login">Login</router-link>
            </li>
            <li class="text-indigo-500 hover:text-indigo-800 transition-colors">
              <router-link to="/register">Register</router-link>
            </li>
        </template>
        <template v-else>
            <button v-on:click="handleLogout" class="text-red-500 font-semibold hover:text-red-600">
              Logout
            </button>
        </template>
      </ul>
    </nav>
  </header>

  <div class="main flex flex-col p-8 bg-gray-50">
    <slot />
  </div>
</template>

<style scoped>
.main{
    min-height: calc(100vh - 64px)
}
</style>