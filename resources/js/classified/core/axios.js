import axios from "axios";
import app from "../config/app";

const httpClient = axios.create({
    baseURL: app.api_base_url + "/api/classified",
    headers: {
        "X-Language": app.locale,
    },
});

export const setHeaders = headers => {
    httpClient.interceptors.request.use(function (config) {
        const token = localStorage.getItem("token");
        config.headers.Authorization = token ? `Bearer ${token}` : "";
        for (const key in headers) {
            config.headers[key] = headers[key];
        }

        return config;
    });
};

export default httpClient;
