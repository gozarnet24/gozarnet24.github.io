<template>
  <div class="app">
    <slot />
  </div>
</template>

<style lang="scss" scoped>
.app {
  @screen md {
    transform: translateX(0);
    overflow-y: hidden;
    max-width: 500px;
    width: 500px;
    margin: auto;

    max-height: 800px;
    height: 100%;

    & > * {
      overflow: auto;
      max-height: 800px;
      height: 100%;
    }
  }
}
</style>
