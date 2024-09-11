<template>
  <button class="plan__card w-full" :class="{ active: props.active }">
    <p v-html="plan.name"></p>

    <div class="flex justify-between items-center w-full">
      <div class="plan__card-labels">
        <span>تعداد اتصال</span>
        <b v-if="plan.connection_count">{{ plan.connection_count }}</b>
        <b v-else>نامحدود</b>
      </div>
      <span class="plan__card-divider"></span>
      <div class="plan__card-labels">
        <span>هزینه</span>
        <b>{{ plan.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} تومان</b>
      </div>
      <span class="plan__card-divider"></span>
      <div class="plan__card-labels">
        <span>زمان</span>
        <b v-if="plan.duration">{{ plan.duration }} روز</b>
        <b v-else>نامحدود</b>
      </div>
    </div>
  </button>
</template>

<script setup lang="ts">
const props = defineProps({
  active: {
    type: Boolean,
    required: false,
    default: false,
  },
  plan: {
    type: Object,
    required: false,
    default: () => ({}),
  }
});
</script>

<style lang="scss" scoped>
.plan__card {
  background: #ffffff;
  border: 1px solid #d9d9d9;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 16px;
  display: flex;
  flex-direction: column;

  &>p {
    font-size: 16px;
    font-weight: 400;
    line-height: 24.8px;
    color: #111113;
    text-align: center;
    width: 100%;
    margin-bottom: 20px;

    &>span {
      font-size: 16px;
      font-weight: 700;
      line-height: 24.8px;
    }
  }

  &.active {
    background: #ff7a2208;
    border: 1px solid #ff7a22;
  }
}

.plan__card-labels {
  display: flex;
  flex-direction: column;
  align-items: flex-start;

  &>span {
    font-size: 14px;
    font-weight: 400;
    line-height: 21.7px;
    color: #000000cc;
    margin-bottom: 4px;
  }

  &>b {
    font-size: 14px;
    font-weight: 700;
    line-height: 21.7px;
    color: #111113;
  }
}

.plan__card-divider {
  background: #dfdfdf;
  width: 1px;
  height: 22px;
}
</style>
