import axios from '@axios'
import { defineStore } from 'pinia'

export const useMissionParamsStore = defineStore('MissionParamsStore', {
  actions: {
    //SECTION Standard API CALL
    // 👉 Fetch Standards data
    fetchStandards(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/standards/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Standard
    fetchStandard(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/standards/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Standard
    addStandard(standardData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/standards', standardData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Standard
    updateStandard(id, standardData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/standards/${id}`, standardData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Standard
    deleteStandard(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/standards/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    //SECTION Recommendation API CALL
    // 👉 Fetch Recommendations data
    fetchRecommendations(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/recommendations/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Recommendation
    fetchRecommendation(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/recommendations/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Recommendation
    addRecommendation(recommendationData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/recommendations', recommendationData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Recommendation
    updateRecommendation(id, recommendationData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/recommendations/${id}`, recommendationData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Recommendation
    deleteRecommendation(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/recommendations/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Recommendation API CALL

    //SECTION Suggestion API CALL
    // 👉 Fetch Suggestions data
    fetchSuggestions(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/suggestions/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Suggestion
    fetchSuggestion(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/suggestions/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Suggestion
    addSuggestion(suggestionData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/suggestions', suggestionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Suggestion
    updateSuggestion(id, suggestionData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/suggestions/${id}`, suggestionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Suggestion
    deleteSuggestion(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/suggestions/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    //!SECTION Suggestion API CALL
    fetchCompliancesCompliant(params)  {
      const filters = [
        { field: 'compliance_status', operator: '=', value: 'compliant' },
      ]
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/compliances/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchCompliancesNonCompliant(params)  {
      const filters = [
        { field: 'compliance_status', operator: '=', value: 'non-compliant' },
      ]
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/compliances/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //SECTION Service API CALL
    // 👉 Fetch Services data
    fetchServices(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/mission-services/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Service
    fetchService(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/mission-services/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Service
    addService(serviceData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/mission-services', serviceData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Service
    updateService(id, serviceData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/mission-services/${id}`, serviceData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Service
    deleteService(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/mission-services/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    //SECTION Service API CALL

    //SECTION Hazard API CALL
    // 👉 Fetch Hazards data
    fetchHazards(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/hazards/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Hazard
    fetchHazard(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/hazards/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Hazard
    addHazard(hazardData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/hazards', hazardData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Hazard
    updateHazard(id, hazardData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/hazards/${id}`, hazardData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Hazard
    deleteHazard(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/hazards/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Hazard API CALL
  },
})
