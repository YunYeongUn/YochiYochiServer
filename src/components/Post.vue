<template>
  <div v-if="post">
    <h1>{{ post[0].post_title }}</h1>
    {{ post[0].post_content }}
  </div>
</template>

<script>
import { useRoute } from "vue-router";
const route = useRoute();
export default {
  data() {
    return {
      post: "",
    };
  },

  mounted() {
    this.getData();
  },

  methods: {
    async getData() {
      await this.axios
        .get("http://localhost/api/community/" + this.$route.params.id)
        .then((res) => {
          /* console.log(res.staus);
          console.log(res.data); */
          this.post = res.data;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          console.log("글상세페이지");
        });
    },
  },
};
</script>
