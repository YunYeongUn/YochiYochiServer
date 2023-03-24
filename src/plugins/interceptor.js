import axiosinstance from "./axios.js";
import { useCookies } from "vue3-cookies";
import axios from "axios";

const { cookies } = useCookies();

axiosinstance.interceptors.request.use(
  async (config) => {
    console.log("axios.js request : ", config);
    if (import.meta.env.VITE_IS_LOGIN === "Y" && cookies.get("accessToken")) {
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
    //console.error("axios.js response error : ", error);
    if (import.meta.env.VITE_IS_LOGIN === "Y") {
      const errorRes = error.response;
      const originalRequest = error.config;
      // console.log("error:", errorRes);
      if (errorRes.status === 401) {
        // access token이 만료되었거나 없는 경우
        console.log("함 볼까", errorRes);
        if (errorRes.statusText === "Unauthorized") {
          const refreshToken = cookies.get("refreshToken");

          if (refreshToken) {
            try {
              const response = await axios.post(
                `http://localhost/api/refresh`,
                {
                  refresh_token: refreshToken,
                }
              );
              const accessToken = response.data.access_token;
              cookies.set("accessToken", accessToken, "1h");
              originalRequest.headers[
                "Authorization"
              ] = `Bearer ${accessToken}`;
              return axiosinstance(originalRequest);
            } catch (err) {
              console.error(err);
              alert("로그인이 필요합니다.");
              return Promise.reject(err);
            }
          } else {
            // refresh token이 없는 경우
            alert("로그인이 필요합니다.");
            return Promise.reject(error);
          }
        } else {
          // access token이 변조 등 유효하지 않은 경우
          console.warn("유효하지 않은 토큰", error);
          alert("다시 로그인해주시기 바랍니다.");
          return Promise.reject(error);
        }
      }
    }
    return Promise.reject(error);
  }
);
export default axiosinstance;
