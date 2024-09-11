<template>
  <div class="payment">
    <AppHeader title="واریز وجه" back-button />

    <div class="flex flex-col mt-4 p-4">
      <strong class="payment__title">مشخصات پلن شما</strong>
      <PlanCard active :plan="activePlan"/>
      <strong class="payment__title mt-4 mb-3">
        لطفا هزینه پلن را به شماره کارت زیر واریز کنید.
      </strong>
      <p class="payment__description">
        بعد از واریز وجه، رسید واریزی را به آیدی تلگرام ارسال کنید.
      </p>

      <div class="payment__card">
        <h2>اطلاعات حساب بانکی</h2>
        <div>
          <span>شماره کارت:</span>
          <div class="flex items-center">
            <p dir="ltr">{{ authStore.userData.card_info.value.toString().replace(/\B(?=(\d{4})+(?!\d))/g, " - ") }}</p>
            <button @click="copy">
              <CopySvg />
            </button>
          </div>
        </div>
        <div>
          <span>نام صاحب کارت:</span>
          <strong>{{ authStore.userData.card_info.meta }}</strong>
        </div>
      </div>

      <a href="https://t.me/giganet_service"  target="_blank" class="support__card">
        <TelegramSvg class="bg-[#2269F30D] text-[#2269F3]" />
        <div>
          <span>آیدی تلگرام</span>
          <strong dir="ltr">@Giganet_service</strong>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup lang="ts">
import {useAuthStore} from "~/stores/auth";

import { useClipboard } from '@vueuse/core'
import {useToast} from 'vue-toast-notification';

import AppHeader from "~/components/template/AppHeader.vue";

import PlanCard from "~/components/page/PlanCard.vue";
import TelegramSvg from "~/assets/icons/telegram.svg";
import CopySvg from "~/assets/icons/copy.svg";

definePageMeta({
  name: "PaymentPage",
  middleware: ["auth"],
});

const authStore = useAuthStore()

const route = useRoute();
const toast = useToast();

const activePlan = computed(() => {
  return authStore.userData.plans.find((plan) => plan.id === Number(route.query.plan))
})

const source = ref(authStore.userData.card_info.value)
const clipboard = useClipboard({ source });

function copy() {
  clipboard.copy(source.value);
  toast.success("شماره کارت کپی شد", {position: "top", queue: true});
}
</script>

<style lang="scss" scoped>
.payment {
  background-color: #fbfbfb;
  min-height: 100dvh;
}

.payment__title {
  font-size: 16px;
  font-weight: 700;
  line-height: 24.8px;
  text-align: right;
  margin-bottom: 16px;
  color: #000000;

  &.mb-3 {
    margin-bottom: 12px;
  }
}

.payment__card {
  background: #ffffff;
  border: 1px solid #22222212;
  border-radius: 12px;
  padding: 0 16px 16px;
  margin-bottom: 16px;
  display: flex;
  flex-direction: column;

  & > h2 {
    font-size: 16px;
    font-weight: 700;
    line-height: 24.8px;
    color: #ff7a22;
    position: relative;
    width: 100%;
    text-align: center;
    padding-top: 14px;
    margin-bottom: 24px;

    &::before {
      content: "";
      display: flex;
      background: #ff7a22;
      width: 80px;
      height: 6px;
      border-radius: 0px 0px 20px 20px;
      top: 0;
      left: 50%;
      position: absolute;
      transform: translateX(-50%);
    }
  }

  & > div {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;

    & > span {
      color: #191717;
      font-size: 16px;
      font-weight: 400;
      line-height: 24.8px;
    }

    & > p {
      color: #191717;
      font-size: 16px;
      font-weight: 400;
    }

    &:not(:last-of-type) {
      padding-bottom: 14px;
      border-bottom: 1px solid #dedede;
      margin-bottom: 14px;
    }

    & > div {
        & > button {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            margin-bottom: 0;

            & > svg {
                width: 24px;
                height: 24px;
                margin-bottom: 0;
            }
        }
    }
  }
}

.payment__description {
  color: #000000;
  font-size: 14px;
  font-weight: 600;
  line-height: 27px;
  margin-bottom: 16px;
}

.support__card {
  background: #ffffff;
  border: 1px solid #22222212;
  border-radius: 12px;
  padding: 14.5px 12.5px;
  margin-bottom: 16px;
  display: flex;

  & > svg {
    width: 60px;
    height: 60px;
    padding: 12.5px;
    border-radius: 12px;
    margin-left: 16px;
  }

  & > div {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    & > span {
      color: #474545;
      font-size: 16px;
      font-weight: 400;
      line-height: 31px;
      text-align: right;
    }

    & > strong {
      color: #191717;
      font-size: 16px;
      font-weight: 700;
      line-height: 31px;
      text-align: right;
    }
  }
}
</style>
