import axios from "axios";

const axiosClient = axios.create({
    // baseURL: import.meta.env.VITE_API_BASE_URL,
    baseURL: "http://localhost:8081/api"
})

console.log(axiosClient.baseURL)
axiosClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('ACCESS_TOKEN')
    config.headers.Authorization = `Bearer ${token}`
    config.headers.Accept ="application/json"
    console.log(config)
    return config
})

axios.interceptors.response.use((response) => {
    return response;
}, (error) => {
    const { response } = error
    if (response.status === 401) {
        localStorage.removeItem('ACCESS_TOKEN')
    }
    console.log(error)
})
export default axiosClient;