<template>
  <div>
    <h3>게시글 올리기</h3>

    <Writeform
      names="제목은 18글자까지입니다."
      placeholders="제목"
      v-model="value.title"
      :valids="valid.titleHasError"
      max-length="18"
    />
    <Writeform
      names="내용은 180자까지입니다."
      placeholders="내용"
      v-model="value.textdetail"
      :valids="valid.detailHasError"
      max-length="180"
    />
    <button @click="store()">게시</button>
  </div>
</template>

<script>
import Writeform from "./Writeform.vue";

export default {
  data() {
    return {
      value: {
        name: "",
        title: "",
        textdetail: "",
      },
      valid: {
        nameHasError: false,
        titleHasError: false,
        detailHasError: false,
      },
    };
  },
  components: {
    Writeform,
  },
  methods: {
    checkNull() {
      if (!this.value.name || !this.value.title || !this.value.textdetail) {
        alert("빈칸을 채워주세요.");
        return false;
      }
      return true;
    },
    /* async postBoard(cn) {
            if (cn) {
                await this.axios
                    .post("http://localhost/api/community/store", this.value)
                    .then((res) => {
                        console.log(res.data)
                        location.href = "/"
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => {
                        console.log()
                    })
            }
        } */
    async store() {
      try {
        const rs = await this.store
          .dispatch("auth/createPost", {
            post_title: this.value.title,
            post_content: this.value.textdetail,
          })
          .then(this.$router.push({ name: "community" }));
      } catch (err) {
        console.log(err);
      }
    },
  },
};
</script>
