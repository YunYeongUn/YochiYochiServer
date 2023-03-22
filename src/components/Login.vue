<template>
  <div>
    <Input
      names="E-mail"
      placeholders="ex) kream@kream.co.kr"
      v-model="value.email"
      :valids="valid.emailHasError"
      :passwords="false"
    />
  </div>
  <div>
    <Input
      names="비밀번호"
      placeholders="영문, 숫자, 특수문자 조합 8-16자"
      v-model="value.password"
      :passwords="true"
      :valids="valid.passwordHasError"
    />
  </div>
  <div>
    <button type="button" @click="login()">Login</button>
  </div>
  <div>
    <a href="signup">
      <p>signup</p>
    </a>
  </div>
</template>

<script>
import Input from "./Input.vue";
import { useStore } from "vuex";
const store = useStore();

export default {
  data() {
    return {
      value: {
        email: "",
        password: "",
      },
      valid: {
        emailHasError: false,
        passwordHasError: false,
      },
      access_token: "",
      store: useStore(),
    };
  },
  components: {
    Input,
  },
  methods: {
    checkEmail() {
      const validateEmail =
        /^[A-Za-z0-9_\\.\\-]+@[A-Za-z0-9\\-]+\.[A-Za-z0-9\\-]+/;

      if (validateEmail.test(this.value.email)) {
        this.valid.emailHasError = true;
        return;
      }
      this.valid.emailHasError = false;
    },
    checkPassword() {
      const validatePassword =
        /^(?=.*[a-zA-z])(?=.*[0-9])(?=.*[$`~!@$!%*#^?&\\(\\)\-_=+]).{8,16}$/;

      if (validatePassword.test(this.value.password)) {
        this.valid.passwordHasError = true;
        return;
      }
      this.valid.passwordHasError = false;
    },
    checkAll() {
      if (!this.valid.emailHasError || !this.valid.passwordHasError) {
        alert("다시 입력하시오.");
        return;
      }
      return true;
    },
    /* async postData(ch) {
      await this.axios
        .post("http://localhost/api/login", this.value)
        .then((res) => {
          console.log(res.data);
          this.access_token = res.data.access_token;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {});
    }, */
    async login() {
      try {
        await this.$store.dispatch("auth/login", {
          email: this.value.email,
          password: this.value.password,
        });
        this.$router.push({ name: "home" });
      } catch (err) {
        console.log(err);
      }
    },
  },
  watch: {
    "value.email": function () {
      this.checkEmail();
    },
    "value.password": function () {
      this.checkPassword();
    },
  },
};
</script>
