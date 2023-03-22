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
    this.show();
  },

  methods: {
    async show() {
      try {
        const showpost = await this.$store.dispatch(
          "community/getPost",
          this.$route.params.id
        );
        this.post = showpost;
        console.log(this.post);
      } catch (err) {
        console.log(err);
      }
    },
  },
};
</script>
