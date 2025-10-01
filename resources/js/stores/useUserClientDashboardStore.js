import axios from '@axios'
import { defineStore } from 'pinia'

export const useUserClientDashboardStore = defineStore('UserClientDashboardStore', {
  actions: {
    //SECTION User API CALL
    // 👉 Fetch Client Parks
    fetchClientParks(id) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/client/${id}/parks/search`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchClients()  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/clients/search`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Equipments data
    fetchEquipments(params)  {
      const filters = []
    
      filters.push({ field: 'client_name', operator: '=', value: params.client })
          
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/equipment/search`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Equipment data
    fetchMetaEquipment(params)  {      
      const filters = []
    
      filters.push({ field: 'client_name', operator: '=', value: params.client })
      
      return new Promise((resolve, reject) => {
        axios
          .post('/api/meta-equipment/search?limit=10000', {
            filters,
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    fetchEquipmentsById(params)  {
      const filters = []

      filters.push({ field: 'client_name', operator: '=', value: params.client })
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/equipment/search?limit=10000`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    
    // 👉 fetch single Equipment
    fetchEquipment(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/equipment/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //SECTION Park Equipment API CALL
    // 👉 Fetch Park Equipments
    fetchParkEquipments(params) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/park/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Park Equipment
    fetchParkEquipmentData(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/equipment/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Fetch missions data
    fetchMissions(params)  {
      const filters = []

      filters.push({ field: 'client_name', operator: '=', value: params.client })

  
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single mission
    fetchMission(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/missions/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Client Contact API CALL 
  },
})
