import axios from "axios";

export const URL = {
  baseURL: process.env.NODE_ENV === "production" ? "" : "/api",

};

const api = axios.create({
  baseURL: URL.baseURL,
  headers: {
    "Content-Type": "application/json"
  }
});

export default api;
