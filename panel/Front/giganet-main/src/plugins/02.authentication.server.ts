export default defineNuxtPlugin(async (nuxtApp) => {
    await nuxtApp.$auth.tryToLogin().catch(() => {});
});