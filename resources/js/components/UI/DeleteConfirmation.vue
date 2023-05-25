<template>
  <div class="delete-confirmation">
    <form class="delete-confirmation__form" method="POST" :action="this.link">
      <p class="delete-confirmation__label">Ви впевнені, що бажаєте видалити?</p>
      <input type="hidden" name="id" :value="this.id">
      <input type="hidden" name="_token" :value="this.csrf">
      <form-button class="delete-confirmation__btn-submit">Видалити</form-button>
    </form>
  </div>
</template>

<script>
export default {
  name: "DeleteConfirmation",
  props: {
    link: {
      type: String,
      required: true,
    },
    id: {
      type: Number,
      required: true,
    }
  },
  computed: {
    csrf() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
  }
}
</script>

<style scoped lang="scss">
.delete-confirmation {

  &__form {
    display: flex;
    flex-direction: column;
  }

  &__label {
    margin-top: 5px;
    color: red;
    font-weight: 700;
    font-size: 1.3em;
  }

  &__btn-submit {
    margin-top: 20px;
  }
}
</style>