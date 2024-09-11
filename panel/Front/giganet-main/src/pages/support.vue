<template>
  <div class="support">
    <AppHeader title="پشتیبانی" back-button />

    <div class="flex flex-col mt-4 p-4">
      <strong class="support__title">با ما در ارتباط باشید.</strong>

      <a href="mailto:giganetwork.me@gmail.com" target="_blank" class="support__card">
        <EmailSvg class="bg-[#F210450D] text-[#F21045]" />
        <div>
          <span>ایمیل</span>
          <strong dir="ltr">giganetwork.me@gmail.com</strong>
        </div>
      </a>

      <a href="https://t.me/giganet_service" target="_blank" class="support__card">
        <TelegramSvg class="bg-[#2269F30D] text-[#2269F3]" />
        <div>
          <span>آیدی تلگرام</span>
          <strong dir="ltr">@Giganet_service</strong>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup>
import AppHeader from "~/components/template/AppHeader.vue";

import EmailSvg from "~/assets/icons/email.svg";
import TelegramSvg from "~/assets/icons/telegram.svg";

definePageMeta({
  name: "SupportPage",
  middleware: ["auth"],
});
</script>

<style lang="scss" scoped>
.support {
  background-color: #fbfbfb;
  min-height: 100dvh;
}

.support__title {
  font-size: 16px;
  font-weight: 700;
  line-height: 24.8px;
  text-align: right;
  margin-bottom: 16px;
  color: #000000;
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
