import { useAuthStore } from "~/stores/auth";
import { getUserData } from "~/services";

export default defineNuxtPlugin(() => {
  const authStore = useAuthStore();
  const cookies = useCookie("GiganetUSERToken", {
    maxAge: 60 * 60 * 24 * 30, // 1 month
  });

  async function setToken(token: string) {
    return tryToLogin(token).then((data) => {
      cookies.value = token;
      return data;
    });
  }

  async function tryToLogin(token?: string | null) {
    token ??= cookies.value;

    if (token) {
      return getUserData(token).then((data) => {
        if (data.success) {
          authStore.setUserData(data.data);
          authStore.isLoggedIn = true;
        }
        return data;
      });
    } else return Promise.reject();
  }

  async function updateMe() {
    return getUserData(cookies.value!).then((data) => {
      if (data.status === "success") {
        authStore.setUserData(data.data);
      }
      return data;
    });
  }

  function logout() {
    authStore.isLoggedIn = false;
    authStore.clearUserData();
    cookies.value = undefined;
  }

  return {
    provide: {
      auth: {
        tryToLogin,
        setToken,
        logout,
        updateMe,
      },
    },
  };
});