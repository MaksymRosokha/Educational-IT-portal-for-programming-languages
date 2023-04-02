<template>
  <button class="form-button" type="submit">
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "FormButton",

  data() {
    return {}
  },

}
</script>

<style scoped lang="scss">
.form-button {
  width: 100%;
  height: 30px;
  background-color: #162939;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  font-size: 1em;

  &:hover {
    transition: background-color .8s;
    background-color: #31536e;
  }
}
</style>