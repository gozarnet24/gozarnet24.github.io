<template>
  <div class="login-page">
    <form @submit.prevent class="login-page__form">
      <img src="/logo.png" width="98" height="105" class="login-page__logo" />
      <h3 class="login-page__title">ورود به حساب کاربری</h3>
      <BaseTextInput v-model="form.username" title="نام کاربری" class="mb-6" />
      <BaseTextInput
        v-model="form.password"
        title="رمز عبور"
        type="password"
        class="mb-8"
      />
      <BaseButton @click="submit" :disabled="isLoading">
        <div v-if="isLoading" class="flex justify-center items-center h-[25.4px]">
          <div class="loader"></div>
        </div>
        <span v-else> ورود به پنل </span>
      </BaseButton>
    </form>
  </div>
</template>

<script setup lang="ts">
import type { RouteLocationRaw } from "vue-router";

import { useToast } from "vue-toast-notification";

import { loginUser } from "~/services";

import BaseButton from "~/components/global/BaseButton.vue";
import BaseTextInput from "~/components/global/BaseTextInput.vue";

definePageMeta({
  name: "LoginPage",
  middleware: ["guest"],
});

// onBeforeUnmount(() => {
//   if (window) {
//     window.$crisp.do('chat:show')
//   }
// });

// onBeforeMount(() => {
//   if (window) {
//     $crisp.on('session:loaded', () => {
//       window.$crisp.do('chat:hide')
//     })

//     window.$crisp.do('chat:hide')
//   }
// })

const nuxtApp = useNuxtApp();
const toast = useToast();
const router = useRouter();
const route = useRoute();

const form = reactive({
  username: "",
  password: "",
});

const isLoading = ref(false);

function submit() {
  if (isLoading.value) return;
  if (!form.username || !form.password) {
    toast.error("اطلاعات خود را کامل کنید!", { position: "top", queue: true });
    return;
  }

  isLoading.value = true;

  loginUser({ username: form.username, password: form.password })
    .then((data) => nuxtApp.$auth.setToken("bearer " + data.token))
    .then(() => router.push((route.query.next as RouteLocationRaw) || "/"))
    .catch(() =>
      toast.error("اطلاعات وارد شده اشتباه است!", {
        position: "top",
        queue: true,
      })
    )
    .finally(() => {
      isLoading.value = false;
    });
}
</script>

<style lang="scss">
.login-page {
  @apply bg-white min-h-screen flex;
}

.login-page__form {
  width: 100%;
  max-width: calc(100% - 32px);
  margin: auto;
  border: 1px solid #e9e9e9;
  border-radius: 16px;
  padding: 24px 16px;

  @screen md {
    max-width: 480px;
  }
}

.login-page__title {
  font-size: 20px;
  font-weight: 700;
  line-height: 31px;
  width: 100%;
  text-align: center;
  color: #111113;
  margin-bottom: 24px;

  @screen md {
    line-height: 38px;
    font-size: 24px;
  }
}

.login-page__logo {
  width: 98px;
  height: 105px;
  margin-right: auto;
  margin-left: auto;
  margin-bottom: 24px;
}

.loader {
  height: 8px;
  aspect-ratio: 4;
  --_g: no-repeat radial-gradient(farthest-side, #fff 90%, #fff0);
  background: var(--_g) left, var(--_g) right;
  background-size: 25% 100%;
  display: grid;
}
.loader:before,
.loader:after {
  content: "";
  height: inherit;
  aspect-ratio: 1;
  grid-area: 1/1;
  margin: auto;
  border-radius: 50%;
  transform-origin: -100% 50%;
  background: #fff;
  animation: l49 1s infinite linear;
}
.loader:after {
  transform-origin: 200% 50%;
  --s: -1;
  animation-delay: -0.5s;
}

@keyframes l49 {
  58%,
  100% {
    transform: rotate(calc(var(--s, 1) * 1turn));
  }
}
</style>
