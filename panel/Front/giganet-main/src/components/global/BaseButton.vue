<template>
  <button class="base-button" :disabled>
    <slot name="default" />
  </button>
</template>

<script lang="ts" setup>
const props = defineProps({
  disabled: {
    type: Boolean,
    required: false,
    default: false,
  }
})
</script>

<style lang="scss">
.base-button {
  background: #FF7A22;
  font-size: 16px;
  font-weight: 700;
  line-height: 24.8px;
  color: white;
  padding: 12px;
  border-radius: 12px;
  width: 100%;

  &:disabled {
    background: #FF7A2240 !important;
  }
}
</style>
