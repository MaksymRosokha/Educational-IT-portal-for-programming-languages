<template>
  <input class="form-input-field"
         :type="this.typeOfInput"
         :name="this.nameOfInput"
         :placeholder="this.placeholderOfInput"
         :required="this.isRequired"
         :maxlength="this.maxLengthOfInput"
         :minlength="this.minLengthOfInput"
         :value="this.valueOfInput"
         @input="this.passOnValue"
  >
</template>

<script>
export default {
  name: "FormInputField",

  data() {
    return {
    }
  },
  props: {
    typeOfInput: {
      type: String,
      required: false,
      default: "text",
    },
    nameOfInput: {
      type: String,
      required: true,
    },
    placeholderOfInput: {
      type: String,
      required: false,
      default: "",
    },
    isRequired: {
      type: Boolean,
      required: false,
      default: false,
    },
    maxLengthOfInput: {
      type: Number,
      required: false,
      default: null,
    },
    minLengthOfInput: {
      type: Number,
      required: false,
      default: null,
    },
    valueOfInput: {
      type: String,
      required: false,
      default: '',
    },
  },
  methods:{
    passOnValue(event){
      this.$emit('data', event.target.value);
    }
  }
}
</script>

<style scoped lang="scss">

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
  border-bottom: solid 2px black;
  -webkit-text-fill-color: black;
  -webkit-box-shadow: 0 0 0 1000px transparent inset;
  transition: background-color 5000s ease-in-out 0s;
}

.form-input-field {
  display: inline;
  width: 100%;
  margin-bottom: .5vw;
  background-color: transparent;
  border: none;
  border-bottom: solid 2px black;
  font-weight: 500;
  outline: none;
}
</style>