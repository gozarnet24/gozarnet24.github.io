<template>
    <div class="password">
        <AppHeader title="تغییر کلمه عبور" back-button />

        <div class="flex flex-col mt-4 p-4">
            <strong class="password__title">رمز عبور جدید خود را وارد کنید.</strong>

            <BaseTextInput v-model="password" type="password" title="رمز عبور جدید" class="mt-3" />
        </div>
        <div class="page__fixed">
            <BaseButton class="page__fixed-button" @click="submit" :disabled="isLoading">
                <div v-if="isLoading" class="flex justify-center items-center h-[25.4px]">
                    <div class="loader"></div>
                </div>
                <span v-else>تایید</span>
            </BaseButton>
        </div>
    </div>
</template>

<script setup>
import AppHeader from "~/components/template/AppHeader.vue";

import BaseButton from "~/components/global/BaseButton.vue";
import BaseTextInput from "~/components/global/BaseTextInput.vue";

import { changePassword } from "~/services";
import { useToast } from "vue-toast-notification";

definePageMeta({
    name: "ChangePasswordPage",
    middleware: ["auth"],
});

useHead({
    htmlAttrs: {
        class: "has-fixed-button",
    },
})

const toast = useToast();
const router = useRouter();
const password = ref("");

const isLoading = ref(false);

function submit() {
    if (isLoading.value) return;
    if (!password.value) {
        return toast.error("لطفا رمز عبور را وارد کنید!", { position: "top", queue: true });
    }

    isLoading.value = true;

    changePassword(password.value)
        .then(() => {
            toast.success("رمز عبور با موفقیت تغییر یافت", {
                position: "top",
                queue: true,
            });
            router.push("/");
        })
        .catch((error) => {
            toast.error(error.response?._data?.message?.[0], {
                position: "top",
                queue: true,
            })
        }
        )
        .finally(() => {
            isLoading.value = false;
        });
}
</script>

<style lang="scss" scoped>
.password {
    background-color: #fbfbfb;
    min-height: 100dvh;
}

.password__title {
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