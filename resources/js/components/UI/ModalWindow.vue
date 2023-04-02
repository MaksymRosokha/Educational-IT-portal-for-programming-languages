<template>
  <div class="modal-window" @click="closeWindow">
    <div class="modal-window__wrapper" @click.stop>
      <header class="modal-window__header">
        <span class="modal-window__close" @click="closeWindow"></span>
      </header>
      <main class="modal-window__content">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: "modal-window",

  data() {
    return {
    }
  },
  methods: {
    closeWindow() {
      this.$emit('closeModalWindow');
    }
  }
}
</script>

<style scoped lang="scss">
.modal-window {
  position: fixed;
  top:0;
  left: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  z-index: 15;
  background-color: rgba(0, 0, 0, 0.4);

  &__wrapper{
    min-width: 200px;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 5px 1px white;
    padding: 2vw;
    margin: 2vw;
  }

  &__header {
    display: flex;
    justify-content: flex-end;
    position: sticky;
  }

  &__close {
    position: sticky;
    width: 40px;
    height: 40px;
    cursor: pointer;
    border-radius: 50%;
    transition: background-color 0.3s;

    &:hover {
      background-color: rgba(255, 0, 0, 0.64);
    }

    &:before, &:after {
      content: '';
      background-color: #8c0202;
      transition: all 1s ease 0s;
      position: absolute;
      width: 35px;
      height: 5px;
      border-radius: 5px;
      left: 2.30px;
    }

    &:before {
      transform: rotate(45deg);
      top: 18px;
    }

    &:after {
      transform: rotate(-45deg);
      bottom: 18px;
    }
  }

  &__content {
    min-width: 200px;
    min-height: 200px;
    margin: 1vw;
  }
}
</style>