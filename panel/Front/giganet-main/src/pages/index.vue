<template>
  <div class="page">
    <AppHeader />

    <main class="flex flex-col items-center p-4">
      <h3 class="page__service-title">اطلاعات سرویس شما</h3>
      <p class="page__service-name">
        {{ authStore.userData.service_information.service_name }}
      </p>
      <div class="page__service-chart">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2.5 -2.5 37 37" class="progress-bar">
          <circle
            cx="16"
            cy="16"
            r="15.9155"
            class="progress-bar__background"
          />

          <circle
            cx="16"
            cy="16"
            r="15.9155"
            class="progress-bar__progress"
            :stroke-dashoffset="100 - (100 - 
              authStore.userData.service_information.used_traffic /
              authStore.userData.service_information.total_traffic
            * 100) + 'px'"
          />
        </svg>
        <div>
          <span>حجم مصرفی</span>
          <strong
            >{{ authStore.userData.service_information.used_traffic }} /
            {{
              authStore.userData.service_information.total_traffic
            }}
            GB</strong
          >
        </div>
      </div>
    </main>

    <section class="bg-[#fbfbfb] p-4">
      <AlertBox
        v-for="notification in authStore.userData.notifications"
        :key="notification.id"
        :id="notification.id"
        :title="notification.title"
        :description="notification.description"
      />

      <div class="grid grid-cols-2 gap-4 max-w-[336px] mx-auto">
        <div class="page__card">
          <CalenderSvg />
          <span>تاریخ شروع سرویس</span>
          <b>{{ authStore.userData.service_information.start_date }}</b>
        </div>
        <div class="page__card">
          <CircleSvg />
          <span>حجم کل</span>
          <b dir="ltr"
            >{{ authStore.userData.service_information.total_traffic }} GB</b
          >
        </div>
        <div class="page__card">
          <timeSvg />
          <span>مقدار باقی‌مانده</span>
          <b dir="ltr"
            >{{ authStore.userData.service_information.rest_traffic }} GB</b
          >
        </div>
        <div class="page__card">
          <timerSvg />
          <span>مقدار مصرف شده</span>
          <b dir="ltr"
            >{{ authStore.userData.service_information.used_traffic }} GB</b
          >
        </div>
      </div>
    </section>

    <div class="page__fixed">
      <NuxtLink to="/plans">
        <BaseButton class="page__fixed-button"> خرید ترافیک اضافه </BaseButton>
      </NuxtLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from "~/stores/auth";

import AppHeader from "~/components/template/AppHeader.vue";

import AlertBox from "~/components/page/AlertBox.vue";
import BaseButton from "~/components/global/BaseButton.vue";

import CalenderSvg from "~/assets/icons/calender.svg";
import CircleSvg from "~/assets/icons/circle.svg";
import timeSvg from "~/assets/icons/time.svg";
import timerSvg from "~/assets/icons/timer.svg";

definePageMeta({
  name: "IndexPage",
  middleware: ["auth"],
});

useHead({
    htmlAttrs: {
        class: "has-fixed-button",
    },
})

const authStore = useAuthStore();
</script>

<style lang="scss">
.page {
  background: linear-gradient(
    127.76deg,
    rgba(53, 105, 204, 0.05) 0%,
    rgba(197, 236, 173, 0.12) 99.26%
  );
  padding-bottom: 74px;
}

.page__service-title {
  font-size: 18px;
  font-weight: 700;
  line-height: 27.9px;
  color: #111113;
  margin-bottom: 4px;
}

.page__service-name {
  font-size: 16px;
  font-weight: 400;
  line-height: 24.8px;
  color: #111113;
}

.page__service-chart {
  margin-top: 16px;
  position: relative;

  & > svg {
    width: 180px;
    height: 180px;
  }

  & > div {
    position: absolute;
    top: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;

    & > span {
      font-size: 16px;
      font-weight: 400;
      line-height: 24.8px;
      text-align: center;
      color: #000000b2;
      margin-bottom: 4px;
    }

    & > strong {
      font-size: 16px;
      font-weight: 700;
      line-height: 24.8px;
      text-align: center;
      color: #ff7a22;
      direction: ltr;
    }
  }
}

.page__card {
  @apply aspect-square bg-white rounded-xl max-w-[160px] flex items-center justify-center flex-col;

  &:nth-child(1) > svg {
    background: #1bd3e40d;
    color: #1bd3e4;
  }

  &:nth-child(2) > svg {
    background: #ff7a220d;
    color: #ff7a22;
  }

  &:nth-child(3) > svg {
    background: #2269f30d;
    color: #2269f3;
  }

  &:nth-child(4) > svg {
    background: #1fe97c0d;
    color: #1fe97c;
  }

  & > svg {
    width: 38px;
    height: 38px;
    margin-bottom: 12px;
    padding: 7px;
    border-radius: 8px;
  }

  & > span {
    color: #000000;
    font-size: 14px;
    font-weight: 400;
    line-height: 21.7px;
    text-align: center;
    margin-bottom: 8px;
  }
  & > b {
    color: #000000;
    font-size: 16px;
    font-weight: 700;
    line-height: 24.8px;
    text-align: center;
  }
}

.page__fixed {
  background: #ffffff;
  border-top: 1px solid #ebebeb;
  width: 100%;
  position: fixed;
  padding: 12px 16px;
  bottom: 0;
}

$progress-bar-stroke-width: 5;
$progress-bar-size: 180px;

.progress-bar {
  height: $progress-bar-size;
  width: $progress-bar-size;
}

.progress-bar__background {
  fill: none;
  stroke: #EFEFEF;
  stroke-width: $progress-bar-stroke-width;
}

.progress-bar__progress {
  fill: none;
  stroke: #EFEFEF;
  stroke: #ff7a22;
  stroke-dasharray: 100 100;
  stroke-linecap: round;
  stroke-width: $progress-bar-stroke-width;
  transition: stroke-dashoffset 1s ease-in-out;
}
</style>
