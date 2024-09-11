<template>
  <label class="base-input">
    <span class="base-input__title" v-if="props.title">{{ props.title }}</span>
    <div class="relative">
      <input :type="inputType" v-model.trim="value" />
      <button @click="togglePassword" v-if="isPasswordInput">
        <EyeShowSvg v-if="isShowPassword" />
        <EyeSvg v-else />
      </button>
    </div>
    <span class="base-input__hint">{{ hint }}</span>
  </label>
</template>

<script lang="ts" setup>
import EyeSvg from "~/assets/icons/eye.svg";
import EyeShowSvg from "~/assets/icons/eye-show.svg";

const props = defineProps({
  type: {
    type: String,
    required: false,
    default: "text",
  },
  title: {
    type: String,
    required: false,
    default: "",
  },
  hint: {
    type: String,
    required: false,
    default: "",
  },
});

const value = defineModel();

const isPasswordInput = computed(() => props.type === "password");
const isShowPassword = ref(false);

const inputType = computed(() => {
  if (isPasswordInput.value) {
    return isShowPassword.value ? "text" : "password"
  } else return props.type
})

function togglePassword() {
  isShowPassword.value = !isShowPassword.value;
}
</script>

<style lang="scss">
.base-input {
  display: flex;
  flex-direction: column;

  input {
    background: #f1f1f1;
    width: 100%;
    border-radius: 12px;
    outline: none;
    font-size: 16px;
    font-weight: 400;
    padding: 12px;
    line-height: 24.8px;
  }

  button {
    width: 24px;
    height: 24px;
    position: absolute;
    left: 12px;
    top: 12px;

    & > svg {
      width: 24px;
      height: 24px;
    }
  }
}

.base-input__title {
  font-size: 16px;
  font-weight: 400;
  line-height: 24.8px;
  color: #111113;
  margin-bottom: 12px;
}

.base-input__hint {
  font-size: 14px;
  font-weight: 400;
  line-height: 21.7px;
  color: #000000CC;
  padding-top: 12px;
}
</style>
