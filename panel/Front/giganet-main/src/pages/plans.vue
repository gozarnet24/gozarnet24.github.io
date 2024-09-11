<template>
  <div class="plans">
    <AppHeader title="خرید پلن‌ها" back-button />

    <div class="flex flex-col mt-4 p-4">
      <strong class="plans__title">پلن مورد نظر خود را انتخاب کنید.</strong>

      <PlanCard
        v-for="plan in authStore.userData.plans"
        :key="plan.id"
        :plan="plan"
        :active="plan.id === activePlan"
        @click="activePlan = plan.id"
      />
    </div>

    <div class="page__fixed">
      <BaseButton class="page__fixed-button" :disabled="activePlan === null" @click="$router.push('/support')">خرید و پرداخت</BaseButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import {useAuthStore} from "~/stores/auth";

import AppHeader from "~/components/template/AppHeader.vue";

import BaseButton from "~/components/global/BaseButton.vue";
import PlanCard from "~/components/page/PlanCard.vue";

definePageMeta({
  name: "PlansPage",
  middleware: ["auth"],
});

useHead({
    htmlAttrs: {
        class: "has-fixed-button",
    },
})

const authStore = useAuthStore()

const activePlan = ref(null);
</script>

<style lang="scss" scoped>
.plans {
  background-color: #fbfbfb;
  padding-bottom: 74px;
}

.plans__title {
  font-size: 16px;
  font-weight: 700;
  line-height: 24.8px;
  text-align: right;
  margin-bottom: 16px;
  color: #000000;
}

.page__fixed {
  background: #ffffff;
  border-top: 1px solid #ebebeb;
  width: 100%;
  position: fixed;
  padding: 12px 16px;
  bottom: 0;
}
</style>
