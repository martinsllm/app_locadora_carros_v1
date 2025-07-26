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
        if(error.response.status == 401 && error.response.data.message == 'Token has expired') {
            axios.post('http://localhost:8000/api/refresh')
                .then(response => {
                    console.log('Refresh do token')
                    document.cookie = 'token='+response.data.token+';SameSite=Lax'
                    window.location.reload()
                })
        }
        return Promise.reject(error)
    }
)
