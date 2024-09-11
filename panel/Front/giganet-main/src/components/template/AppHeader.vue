<template>
  <div class="relative">
    <header class="app-header">
      <button @click="isOpenNavbar = true">
        <MenuSvg />
      </button>
      <h2 v-if="props.title">{{ props.title }}</h2>
      <img v-else src="/logo.png" width="47" height="50" />
      <button v-if="props.backButton" @click="$router.back()" class="!text-[#292D32]">
        <ArrowLeftSvg />
      </button>
      <button v-else @click="isOpenMenu = true">
        <ProfileSvg />
      </button>
    </header>

    <Transition name="up-to-down">
      <div
        class="app-header__menu"
        v-on-click-outside="() => (isOpenMenu = false)"
        v-if="isOpenMenu"
      >
        <NuxtLink to="/">
          <ProfileSvg />
          <span>{{ authStore.userData.username }}</span>
        </NuxtLink>
        <NuxtLink to="/logout">
          <LogoutSvg class="!text-[#FF4141] delete" />
          <span>خروج</span>
        </NuxtLink>
      </div>
    </Transition>

    <nav
      class="app-header__navbar duration-300 translate-x-full"
      :class="{ '!translate-x-0': isOpenNavbar }"
      v-on-click-outside="() => (isOpenNavbar = false)"
    >
      <div class="flex justify-between items-center w-full">
        <NuxtLink to="/">
          <img src="/logo.png" width="54" height="57" class="w-[54px] h-[57px]" />
        </NuxtLink>
          <button class="app-header__navbar-close" @click="isOpenNavbar = false">
          <CloseCircleSvg />
        </button>
      </div>

      <ul class="app-header__navbar-links">
        <li>
          <NuxtLink to="/support">پشتیبانی</NuxtLink>
        </li>
        <li>
          <NuxtLink to="/change-password">تغییر کلمه عبور</NuxtLink>
        </li>
        <li>
          <NuxtLink to="/" disabled class="hidden">قوانین و مقررات</NuxtLink>
        </li>
        <li>
          <NuxtLink to="/" disabled class="hidden">نحوه آموزش اتصال</NuxtLink>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup lang="ts">
import {useAuthStore} from "~/stores/auth";

import { vOnClickOutside } from "@vueuse/components";

import ProfileSvg from "~/assets/icons/profile.svg";
import MenuSvg from "~/assets/icons/menu.svg";
import LogoutSvg from "~/assets/icons/logout.svg";
import CloseCircleSvg from "~/assets/icons/close-circle.svg";
import ArrowLeftSvg from "~/assets/icons/arrow-left.svg";

const authStore = useAuthStore()

const props = defineProps({
  title: {
    type: String,
    required: false,
    default: undefined,
  },
  backButton: {
    type: Boolean,
    required: false,
    default: false,
  },
});

const isOpenMenu = ref(false);
const isOpenNavbar = ref(false);
</script>

<style lang="scss" scoped>
.app-header {
  padding: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #22222212;

  & > h2 {
    font-size: 18px;
    font-weight: 600;
    line-height: 27.9px;
    text-align: center;
    color: #000000;
  }

  & > img {
    width: 47px;
    height: 50px;
  }

  & > button {
    width: 36px;
    height: 36px;
    padding: 6px;
    border-radius: 100%;
    overflow: hidden;
    background: #ffffff80;
    outline: none;
    margin: 0;
    display: flex;
    color: #ff7a22;

    & > svg {
      width: 24px;
      height: 24px;
    }
  }
}

.app-header__menu {
  background: #fff;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  position: absolute;
  width: 190px;
  padding: 0 11px;
  top: 64px;
  left: 16px;
  z-index: 1;

  & > a {
    display: flex;
    align-items: center;
    padding: 11px 0;

    & > svg {
      background: #ff7a220d;
      width: 28px;
      min-width: 28px;
      height: 28px;
      border-radius: 8px;
      padding: 4px;
      color: #ff7a22;

      &.delete.nuxt-icon--fill * {
        fill: none !important;
      }
    }

    & > span {
      font-size: 14px;
      font-weight: 400;
      line-height: 28px;
      color: #0e0b2d;
      margin-right: 8px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    &:not(:last-of-type) {
      border-bottom: 1px solid #f6f6f6;
    }
  }
}

.app-header__navbar {
  background: #ffffff;
  width: 220px;
  display: flex;
  position: fixed;
  flex-direction: column;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 1;
  padding: 16px;
}

.app-header__navbar-close {
  outline: none;
  width: 24px;
  height: 24px;
  display: flex;

  & > svg {
    width: 24px;
    height: 24px;
  }
}

.app-header__navbar-links {
  display: flex;
  flex-direction: column;
  padding: 0;
  margin-top: 32px;

  & > li {
    &:not(:last-of-type) {
      margin-bottom: 20px;
    }

    & > a {
      color: #000000;
      font-size: 16px;
      font-weight: 400;
      line-height: 24.8px;

      &:disabled,
      &[disabled] {
        color: #00000066;
        cursor: not-allowed;
        user-select: none;
        pointer-events: none;
      }
    }
  }
}

.up-to-down-leave-active,
.up-to-down-enter-active {
  transition: all 0.3s ease-out;
}

.up-to-down-enter-from,
.up-to-down-leave-to {
  opacity: 0;
}

.up-to-down-enter-from {
  transform: translateY(-8px);
}

.up-to-down-leave-to {
  transform: translateY(15px);
}
</style>
