<template></template>
<script setup lang="ts">
const { $auth } = useNuxtApp();

$auth.logout();

navigateTo("/");
</script>
