import axios from "axios";
import { createStore } from 'vuex';

export const store = createStore({
    state: {
        STSConfigurations: [],
        notifications: []
    },
    getters: {
        getSTSConfigurations: state => {
            return state.STSConfigurations;
        },
        getNotifications: state => {
            return state.notifications
        }
    },
    actions: {
        fetchNotifications({ commit }, params) {
            return axios
                    .get('/notif')
                    .then(response => {
                        if (response.data.status.code == 200) {
                            commit('setNotifications', response.data.data.notifications)
                        } else {
                            throw response.data.status.message
                        }
                    })
        },
        fetchConfigurations({ commit }) {
            return axios
                .get("/configs")
                .then(response => {
                    if (response.data.status.code == 200) {
                        commit('setSTSConfigurations', response.data.data.sts_configurations)
                    } else {
                        throw response.data.status.message
                    }
                })
                .catch(err => {
                    throw err
                });

        },
        createConfigurations({ commit }, payload) {
            let formData = new FormData()

            formData.append("data", payload.data)
            formData.append("digest", payload.digest)
            formData.append("key", payload.key)

            return axios
                .post('/configs', formData)
                .then(function(response, status, request) {
                    if (response.data.status.code == 200) {
                        commit('appendToSTSConfigurations', response.data.data.sts_configurations)
                        return response.data.data.sts_configurations
                    } else {
                        throw response.data.status.message
                    }
                }).catch(err => {
                    throw err
                })

        },
        
    },
    mutations: {
        setSTSConfigurations(state, STSConfigurations) {
            return (state.STSConfigurations = STSConfigurations)
        },
        setNotifications(state, notifications) {
            return (state.notifications = notifications)
        },
        appendToSTSConfigurations(state, STSConfiguration) {
            return (state.STSConfigurations.push(STSConfiguration.config))

        }
    }
});
