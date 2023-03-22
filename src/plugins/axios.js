import axios from "axios";

const instance = axios.create({
  baseURL: import.meta.env.VITE_BASE_URL,
  headers: {
    "Content-Type": "application/json",
  },
  timeout: 3000,
  // withCredentials: true, // withCredentials 설정 추가
});
export default instance;
