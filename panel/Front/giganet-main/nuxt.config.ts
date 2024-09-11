// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: false,
  
  components: false,
  srcDir: "src/",
  compatibilityDate: '2024-04-03',
  devtools: { enabled: true },
  modules: ["@nuxtjs/tailwindcss", "nuxt-svgo", "@pinia/nuxt"],
  app: {
    head: {
      title: "گیگانت | Giganet",
    }
  },
  css: ["@/assets/styles/main.scss", "vue-toast-notification/dist/theme-bootstrap.css"],
  tailwindcss: {
    cssPath: ["~/assets/styles/tailwind.css", { injectPosition: "first" }],
    configPath: "tailwind.config",
    exposeConfig: {
      level: 2,
    },
    config: {},
    viewer: true,
  },
})