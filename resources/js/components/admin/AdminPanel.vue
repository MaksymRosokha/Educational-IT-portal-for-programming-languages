<template>
  <section class="admin-panel">
    <header class="admin-panel__header">
      <h4 class="admin-panel__title">
        <i class="admin-panel__title--italic">Адмін-панель: </i>{{this.title}}
      </h4>
    </header>
    <main class="admin-panel__main">
      <slot></slot>
    </main>
  </section>
</template>

<script>
export default {
  name: "AdminPanel",
  data() {
    return {}
  },
  props: {
    title: {
      type: String,
      required: true,
    }
  }
}
</script>

<style scoped lang="scss">
  .admin-panel {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    flex-wrap: wrap;
    background: linear-gradient(90deg, rgb(168, 85, 246), rgb(152, 48, 250), rgb(168, 85, 246));
    box-shadow: 0 0 10px 2px #200080;
    padding: 1vw;
    margin: 1vw;
    border-radius: 1vw;
    width: 100%;

    // .admin-panel__header

    &__header {
      display: flex;
      align-items: center;
    }

    // .admin-panel__title

    &__title {
      color: #ffffff;
      font-weight: 700;
    }

    // .admin-panel__title--italic

    &__title--italic {
    }

    // .admin-panel__main

    &__main {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }
  }

</style>