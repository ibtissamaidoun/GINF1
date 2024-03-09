import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";

const localUser = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;
const localToken = localStorage.getItem('token') ?? null
const localisAuthenticated = localStorage.getItem('isAuthenticated') ?? false

const apiUrl = 'http://localhost:8000/api';

export const useAuthStore = defineStore("auth", () => {
  const user = ref(localUser);
  const token = ref(localToken);
  const isAuthenticated = ref(localisAuthenticated);

  const login = async (data) => {
    try {
      let response = await axios.post(
        `${apiUrl}/login`,
        data
      );
      
      if (response.status !== 200 && response.status !== 201) return;

      user.value = response.data.user
      token.value = response.data.token
      isAuthenticated.value = true

      localStorage.setItem('user', JSON.stringify(user.value));
      localStorage.setItem('token', token.value);
      localStorage.setItem('isAuthenticated', isAuthenticated.value);

      return response;
    } catch (error) {
      return error?.response;
    }
  };

  const register = async (data) => {
    try {
      let response = await axios.post(`${apiUrl}/register`, data)

      if (response.status !== 201) return
      
      user.value = response.data.user
      token.value = response.data.token
      isAuthenticated.value = true

      localStorage.setItem('user', JSON.stringify(user.value));
      localStorage.setItem('token', token.value);
      localStorage.setItem('isAuthenticated', isAuthenticated.value);

      return response;
    } catch (error) {
      
    }
  };

  const logout = async () => {
    try {
      let response = await axios.delete(`${apiUrl}/logout`);

      if (![204, 205].includes(response.status)) return 

      localStorage.removeItem('user');
      localStorage.removeItem('token');
      localStorage.removeItem('isAuthenticated', false);
      
      user.value = null;
      token.value = null;
      isAuthenticated.value = false;

      return response
    } catch (error) {
      return error?.response
    }
  };

  return { user, token, isAuthenticated, login, register, logout };
});
