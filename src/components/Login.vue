<template>
  <div v-if="needLogin">
    <div>
      <Input
        names="E-mail"
        placeholders="ex) kream@kream.co.kr"
        v-model="data.value.email"
        :valids="data.valid.emailHasError"
        :passwords="false"
      />
    </div>
    <div>
      <Input
        names="비밀번호"
        placeholders="영문, 숫자, 특수문자 조합 8-16자"
        v-model="data.value.password"
        :passwords="true"
        :valids="data.valid.passwordHasError"
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
  </div>
</template>

<script>
import Input from "./Input.vue";
import { useStore } from "vuex";
import { computed, onMounted } from "vue";

export default {
  components: {
    Input,
  },
  setup() {
    const store = useStore();

    const data = {
      value: {
        email: "",
        password: "",
      },
      valid: {
        emailHasError: false,
        passwordHasError: false,
      },
    };

    const needLogin = computed(() => {
      console.log(store.getters["auth/needLogin"]);
      return store.getters["auth/needLogin"];
    });

    function checkEmail() {
      const validateEmail =
        /^[A-Za-z0-9_\\.\\-]+@[A-Za-z0-9\\-]+\.[A-Za-z0-9\\-]+/;

      if (validateEmail.test(data.value.email)) {
        data.valid.emailHasError = true;
        return;
      }
      data.valid.emailHasError = false;
    }

    function checkPassword() {
      const validatePassword =
        /^(?=.*[a-zA-z])(?=.*[0-9])(?=.*[$`~!@$!%*#^?&\\(\\)\-_=+]).{8,16}$/;

      if (validatePassword.test(data.value.password)) {
        data.valid.passwordHasError = true;
        return;
      }
      data.valid.passwordHasError = false;
    }

    function checkAll() {
      if (!data.valid.emailHasError || !data.valid.passwordHasError) {
        alert("다시 입력하시오.");
        return;
      }
      return true;
    }

    async function login() {
      try {
        await store.dispatch("auth/login", {
          email: this.data.value.email,
          password: this.data.value.password,
        });
        this.$router.push({ name: "home" });
      } catch (err) {
        console.log(err);
      }
    }

    onMounted(() => {
      // checkEmail();
      // checkPassword();
    });

    return {
      data,
      needLogin,
      checkEmail,
      checkPassword,
      checkAll,
      login,
    };
  },
};

// import Input from "./Input.vue";
// import { useStore } from "vuex";
// import { computed } from "vue";
// const store = useStore();

// export default {
//   data() {
//     return {
//       value: {
//         email: "",
//         password: "",
//       },
//       valid: {
//         emailHasError: false,
//         passwordHasError: false,
//       },
//     };
//   },
//   components: {
//     Input,
//   },
//   computed: {
//     needLogin: computed(() => {
//       console.log(this.$store.getters["auth/needLogin"]);
//       return this.$store.getters["auth/needLogin"];
//     }),
//   },
//   methods: {
//     checkEmail() {
//       const validateEmail =
//         /^[A-Za-z0-9_\\.\\-]+@[A-Za-z0-9\\-]+\.[A-Za-z0-9\\-]+/;

//       if (validateEmail.test(this.value.email)) {
//         this.valid.emailHasError = true;
//         return;
//       }
//       this.valid.emailHasError = false;
//     },
//     checkPassword() {
//       const validatePassword =
//         /^(?=.*[a-zA-z])(?=.*[0-9])(?=.*[$`~!@$!%*#^?&\\(\\)\-_=+]).{8,16}$/;

//       if (validatePassword.test(this.value.password)) {
//         this.valid.passwordHasError = true;
//         return;
//       }
//       this.valid.passwordHasError = false;
//     },
//     checkAll() {
//       if (!this.valid.emailHasError || !this.valid.passwordHasError) {
//         alert("다시 입력하시오.");
//         return;
//       }
//       return true;
//     },

//     async login() {
//       try {
//         await this.$store.dispatch("auth/login", {
//           email: this.value.email,
//           password: this.value.password,
//         });
//         this.$router.push({ name: "home" });
//       } catch (err) {
//         console.log(err);
//       }
//     },
//   },
//   watch: {
//     "value.email": function () {
//       this.checkEmail();
//     },
//     "value.password": function () {
//       this.checkPassword();
//     },
//   },
// };
</script>
