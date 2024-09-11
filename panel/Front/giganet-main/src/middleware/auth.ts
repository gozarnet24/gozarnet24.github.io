import { useAuthStore } from "~/stores/auth";

export default defineNuxtRouteMiddleware(async (to) => {
  const nuxtApp = useNuxtApp();
  const authStore = useAuthStore();

  if (!authStore.isLoggedIn) {
    try {
      await nuxtApp.$auth.tryToLogin();
      if (authStore.isLoggedIn) {
        navigateTo(to);
      } else throw new Error();
    } catch {
      return navigateTo(`/login?next=${to.fullPath}`);
    }
  }
});
