import axios from '@axios'
import { defineStore } from 'pinia'

export const useMissionListStore = defineStore('MissionListStore', {
  actions: {
    //SECTION Options 
    // 👉 Fetch clients
    fetchClients()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/clients')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Fetch Client Parks
    fetchClientParks(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/client/${id}/parks`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Technicians
    fetchTechnicians(id) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/technicians')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single client
    fetchClient(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/clients/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Park
    fetchPark(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/parks/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION

    //SECTION Mission API CALL
    // 👉 Fetch missions data
    fetchMissions(params)  {
      const filters = []
      if (params.type) {
        filters.push({ field: 'mission_type', operator: '=', value: params.type })
      }
      if (params.client) {
        filters.push({ field: 'client_name', operator: '=', value: params.client })
      }
      if (params.status) {
        filters.push({ field: 'mission_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
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

    // 👉 Add Mission
    addMission(missionData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/missions', missionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update mission
    updateMission(id, missionData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/missions/${id}`, missionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Mission
    deleteMission(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },   

    //!SECTION Mission API CALL
    
    //SECTION Mission Area API CALL
    // 👉 Fetch Mission Areas
    fetchMissionAreas(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/mission/${id}/areas`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Mission Area
    fetchMissionArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/mission/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Mission Area
    addMissionArea(id, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/mission/${id}/areas`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Mission Area
    updateMissionArea(id, areaId, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/mission/${id}/areas/${areaId}`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Mission Area
    deleteMissionArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/mission/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Mission Area API CALL 
    
    //SECTION Mission Equipment API CALL
    // 👉 Fetch Mission Equipments
    fetchMissionEquipments(params) {
      const filters = []
      if (params.category) {
        filters.push({ field: 'equipment_category', operator: '=', value: params.category })
      }
      if (params.model) {
        filters.push({ field: 'equipment_model', operator: '=', value: params.model })
      }
      if (params.status) {
        filters.push({ field: 'equipment_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/mission/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Mission Equipment
    fetchMissionEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/mission/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Mission Equipment
    addMissionEquipment(id, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/mission/${id}/equipment`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Mission Equipment
    updateMissionEquipment(id, equipmentId, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/mission/${id}/equipment/${equipmentId}`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Mission Equipment
    deleteMissionEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/mission/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Inspected Intervention Equipments data
    fetchMetaInspectedEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/interventions/${params.id}/meta-equipment/search?limit=10000`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Inspected Intervention Equipments data
    fetchMetaWorkshopInspectedEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/workshops/${params.id}/meta-equipment`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Fetch Inspected Intervention Equipments data
    fetchInspectedEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/interventions/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Inspected Workshop Equipments data
    fetchInspectedWorkshopEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshops/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Intervention
    fetchIntervention(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/mission/${id}/intervention`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Workshop
    fetchWorkshop(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/mission/${id}/workshop`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    fetchMissionStandards(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/standards/search?limit=${params.options.itemsPerPage}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    attachMissionStandard(missionId, standardId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${missionId}/standards/attach`, {
            resources: [standardId],
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    detachMissionStandard(missionId, standardId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${missionId}/standards/detach`, {
            data: {
              resources: [standardId],
            },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    fetchMissionRecommendations(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/recommendations/search?limit=${params.options.itemsPerPage}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    attachMissionRecommendation(missionId, recommendationData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${missionId}/recommendations/attach`, recommendationData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    

    detachMissionRecommendation(missionId, recommendationId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${missionId}/recommendations/detach`, {
            data: {
              resources: [recommendationId],
            },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    

    fetchMissionCompliancesCompliant(params)  {
      const filters = [
        { field: 'compliance_status', operator: '=', value: 'compliant' },
      ]
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/compliances/search?limit=${params.options.itemsPerPage}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    fetchMissionCompliancesNonCompliant(params)  {
      const filters = [
        { field: 'compliance_status', operator: '=', value: 'non-compliant' },
      ]
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/compliances/search?limit=${params.options.itemsPerPage}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    attachMissionCompliance(missionId, complianceData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${missionId}/compliances/attach`, complianceData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    

    detachMissionCompliance(missionId, complianceId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${missionId}/compliances/detach`, {
            data: {
              resources: [complianceId],
            },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    fetchMissionServices(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/services/search?limit=${params.options.itemsPerPage}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    attachMissionService(missionId, serviceId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${missionId}/services/attach`, {
            resources: [serviceId],
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    detachMissionService(missionId, serviceId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${missionId}/services/detach`, {
            data: {
              resources: [serviceId],
            },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Mission Hazards
    fetchMissionHazards(params) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/hazards/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Mission Hazards
    addMissionHazard(id, hazardData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${id}/hazards`, hazardData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  

    // 👉 Delete Mission Hazard
    deleteMissionHazard(id, hazardId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${id}/hazards/${hazardId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    //!SECTION Mission Equipment API CALL 
    fetchMissionSuggestions(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/suggestions/search?limit=${params.options.itemsPerPage}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    attachMissionSuggestion(missionId, suggestionData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${missionId}/suggestions/attach`, suggestionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    

    detachMissionSuggestion(missionId, suggestionId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${missionId}/suggestions/detach`, {
            data: {
              resources: [suggestionId],
            },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Park Areas
    fetchParkAreas(parkId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/park/${parkId}/areas/search?limit=1000`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Mission Outs
    fetchMissionOuts(params) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${params.id}/out-of-services/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Mission Outs
    addMissionOut(id, outData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/missions/${id}/out-of-services`, outData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  

    // 👉 Delete Mission Out
    deleteMissionOut(id, outId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/missions/${id}/out-of-services/${outId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
})
