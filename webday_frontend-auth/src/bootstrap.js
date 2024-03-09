import _ from "lodash";
window._ = _;

// const qs = require("qs");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

import { useGlobalStore } from "@/Stores/global";

// const debug = process.env.MIX_DEBUG;

window.axios.defaults.withCredentials = true;

// window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.headers.common["Accept"] = "application/json";
window.axios.defaults.headers.common["Content-Type"] = "application/json";

// window.axios.defaults.validateStatus = status => {
//   return status < 500;
// };

// window.axios.defaults.paramsSerializer = (params) => {
//   return qs.stringify(params);
// };

// Add a request interceptor
window.axios.interceptors.request.use(
  function (config) {
    // Do something before request is sent
    const token = localStorage.getItem('token');
    if(token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    
    const globalStore = useGlobalStore();

    if (config.params?.loading != false) globalStore.loading = true;

    return config;
  },
  function (error) {
    // Do something with request error

    const globalStore = useGlobalStore();

    globalStore.loading = false;

    console.log("axios.interceptors.request", error);

    return Promise.reject(error);
  }
);

// Add a response interceptor
window.axios.interceptors.response.use(
  function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    // console.log("window.axios.interceptors.response", response);

    const globalStore = useGlobalStore();

    globalStore.loading = false;

    if (response.data.links) {
      response.links = response.data.links;
    }

    if (response.data.meta) {
      response.meta = response.data.meta;
    }

    response.data = response.data.data ?? response.data;

    response.success = [200, 201, 202, 203, 204, 205].includes(response.status);

    if ([201, 204].includes(response.status)) {
     
    }

    console.log("response from bootstrap", response);

    globalStore.error = null;

    return response;
  },
  function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    // console.log("window.axios.interceptors.response", error);
    // console.log("error.config", error.config);

    const globalStore = useGlobalStore();

    globalStore.loading = false;

    if (error.response) {
      // The request was made and the server responded with a status code
      // that falls out of the range of 2xx

      // if (error.response.status >= 500 && !debug)
      //     return Promise.reject(error);

      globalStore.error = error.response.data;

      let message = false;

      if (globalStore.error.errors) message = globalStore.error.message;
      else if (globalStore.error.message) message = globalStore.error.message;

      if (message) {
        
      }

      return Promise.reject(error);
    }

    if (error.request) {
      // The request was made but no response was received
      // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
      // http.ClientRequest in node.js
      console.log("error.request", error.request);

      // if (error.request.message)

      return Promise.reject(error);
    }

    // Something happened in setting up the request that triggered an Error
    // console.log("Error", error.message);

    return Promise.reject(error);
  }
);