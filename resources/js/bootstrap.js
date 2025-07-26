import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

function getToken() {
    let token = document.cookie.split(";").find(indice => {
        return indice.includes("token=")
    })

    token = token.split('=')[1]
    token = 'Bearer ' + token

    return token
}

axios.interceptors.request.use(
    config => {
        config.headers['Accept'] = 'application/json'
        config.headers['Authorization'] = getToken()
        return config
    },
    error => {
        return Promise.reject(error)
    }
)

axios.interceptors.response.use(
    response => {
        return response
    },
    error => {
        return Promise.reject(error)
    }
)
