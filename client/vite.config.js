import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  server: {
    hmr: {
      host: "0.0.0.0",
    },
    port: 3000,
    host: true,
  },
  plugins: [
    vue(),
  ],
});
