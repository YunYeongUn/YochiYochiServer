import axiosinstance from "./axios.js";
import { useCookies } from "vue3-cookies";

const { cookies } = useCookies();

axiosinstance.interceptors.request.use(
  async (config) => {
    console.log("axios.js request : ", config);
    if (import.meta.env.VITE_IS_LOGIN === "Y") {
      config.headers["Authorization"] = `Bearer ${cookies.get("accessToken")}`;
    }
    console.log("axios.js request : ", config);
    return config;
  },
  (error) => {
    console.error("axios.js request error : ", error);
    return Promise.reject(error);
  }
);

axiosinstance.interceptors.response.use(
  (res) => {
    console.log("응답헤더확인", res.headers);
    return res;
  },
  async (error) => {
    console.error("axios.js response error : ", error);
    if (import.meta.env.VITE_IS_LOGIN === "Y") {
      const errorRes = error.response;
      const originalRequest = error.config;
      if (
        errorRes.status === 401 &&
        errorRes.data.message === "Unauthenticated."
      ) {
        // accessToken이 만료되었을 때 refresh token으로 새로운 accessToken 발급
        try {
          const response = await axios.post(
            `${import.meta.env.VITE_APP_API_URL}/api/auth/refresh`,
            {
              refresh_token: cookies.get("refreshToken"),
            }
          );
          const accessToken = response.data.access_token;
          cookies.set("accessToken", accessToken, "1h");
          originalRequest.headers["Authorization"] = `Bearer ${accessToken}`;
          return instance(originalRequest);
        } catch (err) {
          console.error(err);
          alert("로그인이 필요합니다.");
          return Promise.reject(err);
        }
      } else if (errorRes.status === 401) {
        // accessToken이 변조 등 유효하지 않은 토큰일 경우
        console.warn("유효하지 않은 토큰", error);
        alert("다시 로그인해주시기 바랍니다.");
        return Promise.reject(error);
      }
    }
    return Promise.reject(error);
  }
);

export default axiosinstance;
