<template>
<div class="button-with-modal-window">
    <button class="button-with-modal-window__button"
            @click="showWindow">
      {{ this.buttonText }}
    </button>
    <modal-window class="button-with-modal-window__modal-window"
                  :title="this.title"
                  v-if="isVisible"
                  @close-modal-window="closeWindow">
      <slot></slot>
    </modal-window>
  </div>
</template>

<script>

export default {
  name: "ButtonWithModalWindow",
  data() {
    return {
      isVisible: false,
    }
  },
  props: {
    buttonText: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: false
    }
  },
  methods: {
    closeWindow() {
      this.isVisible = false;
    },
    showWindow() {
      this.isVisible = true;
    },
  }
}
</script>

<style scoped lang="scss">

.button-with-modal-window {

  &__button {
    border-radius: 10px;
    width: 200px;
    height: 40px;
    transition: background-color 0.5s, color 1s, border 1s;
    background-color: #6e01d3;
    color: white;
    box-shadow: 0 0 5px 1px #5e5eff;
    border: none;
    font-weight: 600;

    &:hover {
      color: #000464;
      background-color: #da7bff;
      box-shadow: 0 0 10px 1px #3c3cfa;
    }

    @media (min-width: 1800px) {
      width: 300px;
      height: 50px;
    }

    @media (max-width: 768px) {
      font-size: 1.2em;
    }
  }

  &__modal-window {

  }
}

</style>