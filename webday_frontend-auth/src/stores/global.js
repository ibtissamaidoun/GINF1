import { defineStore } from "pinia";
import { ref } from "vue";

export const useGlobalStore = defineStore("global", () => {
  const loading = ref(null);

  const error = ref(null);


  return { error, loading };
});
