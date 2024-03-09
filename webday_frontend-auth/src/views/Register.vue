<script setup>
import {onBeforeMount, ref} from 'vue';
import { useAuthStore } from "../stores/auth";
import Error from '../components/Error.vue'
import { useGlobalStore } from '../stores/global';
import { useRouter } from 'vue-router';

onBeforeMount(()=>{})

const globalStore = useGlobalStore(); 
const router = useRouter();


const authStore = useAuthStore();

const name = ref(null);
const email = ref(null);
const password = ref(null);
const passwordConfirmation = ref(null);


const handleRegister = async (e) =>{
  e.preventDefault();

  const data = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: passwordConfirmation.value,
  };
  
  authStore.register(data).then(res=>{
    if (res?.status === 201) router.push('/');
  })
}

</script>

<template>
  <div class="min-h-screen flex justify-center items-center bg-blue-100">
    <div class="w-1/3 bg-white rounded-lg shadow-xl px-6 py-8">
      <h1 class="text-2xl text-center font-bold mb-4">Register</h1>

      <form v-on:submit="handleRegister" class="flex flex-col gap-6 px-8">
        <div class="flex flex-col gap-1">
          <label for="name" class="text-gray-600">Username</label>
          <input v-model="name" name="name" id="name" placeholder="Username" class="px-4 py-2 rounded-md border border-gray-300 focus:outline-blue-100"  />
          <Error :errors="globalStore.error?.errors?.name" />
        </div>

        <div class="flex flex-col gap-1">
          <label for="email" class="text-gray-600">Email</label>
          <input v-model="email" name="email" id="email" type="email" placeholder="Email" class="px-4 py-2 rounded-md border border-gray-300 focus:outline-blue-100"  />
          <Error :errors="globalStore.error?.errors?.email" />
        </div>
        
        <div class="flex flex-col gap-1">
          <label for="password" class="text-gray-600">Password</label>
          <input v-model="password" name="password" id="password" type="password" placeholder="Password" class="px-4 py-2 rounded-md border border-gray-300 focus:outline-blue-100" />
          <Error :errors="globalStore.error?.errors?.password" />
        </div>

        <div class="flex flex-col gap-1">
          <label for="password_confirmation" class="text-gray-600">Password</label>
          <input v-model="passwordConfirmation" name="password_confirmation" id="password_confirmation" type="password" placeholder="Password Confirmation" class="px-4 py-2 rounded-md border border-gray-300 focus:outline-blue-100" />
          <Error :errors="globalStore.error?.errors?.password_confirmation" />
        </div>

        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg focus:outline-blue-100" type="submit">
          Register
        </button>
        
      </form>
      
      
    </div>
  </div>
</template>
