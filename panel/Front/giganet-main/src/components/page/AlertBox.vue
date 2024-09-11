<template>
  <div class="alert-box" v-if="isShow">
    <div class="flex items-center mb-2 justify-between">
      <strong>{{ props.title }}</strong>
      <button @click="close">
        <CloseCircleSvg />
      </button>
    </div>
    <p>{{ props.description }}</p>
  </div>
</template>

<script setup lang="ts">
import CloseCircleSvg from "~/assets/icons/close-circle.svg";
import { checkNotification } from "~/services";

const emits = defineEmits(["close"]);
const props = defineProps({
  title: String,
  description: String,
  id: Number,
});

const isShow = ref(true);

function close() {
  isShow.value = false;
  try {
    checkNotification(props.id!)
  } catch (error) {
    
  }
}
</script>

<style scoped lang="scss">
.alert-box {
  padding: 12px;
  border-radius: 8px;
  background: #ff7a220d;
  margin-bottom: 16px;

  strong {
    font-size: 14px;
    font-weight: 700;
    line-height: 21.7px;
    color: #000000;
  }

  p {
    color: #000000;
    font-size: 12px;
    font-weight: 400;
    line-height: 18.6px;
    margin-bottom: 0;
  }

  button {
    outline: none;
    width: 20px;
    height: 20px;
    display: flex;

    & > svg {
      width: 20px;
      height: 20px;
    }
  }
}
</style>
