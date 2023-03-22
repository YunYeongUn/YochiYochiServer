import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue({
      refresh: true,
    }),
  ],
  commonjsOptions: {
    esmExternals: true,
  },
  define: {
    VITE_IS_LOGIN: JSON.stringify(process.env.VITE_IS_LOGIN),
  },
});
