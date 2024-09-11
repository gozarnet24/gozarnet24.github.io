import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    userData: {},
    isLoggedIn: false,
  }),
  actions: {
    setUserData(userData) {
      this.userData = userData;
    },
    clearUserData() {
      this.userData = {};
    },
  },
});
