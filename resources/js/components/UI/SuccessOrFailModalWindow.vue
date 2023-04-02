<template>
  <modal-window class="success-or-fail" @close-modal-window="closeWindow">
    <h4 class="success-or-fail__text">{{ text }}</h4>
    <slot></slot>
  </modal-window>
</template>

<script>
export default {
  name: "SuccessOrFailModalWindow",

  data() {
    return {}
  },
  props: {
    text: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    }
  },
  mounted() {
    this.checkSuccessOrFail();
  },
  methods: {
    checkSuccessOrFail() {
      let txt = document.querySelector('.success-or-fail__text');

      if (this.type === "success") {
        txt.style.color = '#00FF00';
      } else {
        if (this.type === "fail") {
          txt.style.color = '#FF0000';
        } else {
          txt.style.color = '#000000';
        }
      }
    },
    closeWindow() {
      this.$emit('closeModalWindow');
    }
  }
}
</script>

<style lang="scss" scoped>
.success-or-fail {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;


  &__text {
    text-align: center;
    font-size: 2.5em;
    font-weight: 900;
    word-break: break-word;
  }
}

</style>