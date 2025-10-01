<script setup>
import { useMissionListStore } from '../useMissionListStore'
import { useMissionParamsStore } from '../useMissionParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  hazardsViewHeaders: {
    type: Array,
    required: true,
  },
  riskLevelViewHeaders: {
    type: Array,
    required: true,
  },
  recommendationsViewHeaders: {
    type: Array,
    required: true,
  },
  suggestionsViewHeaders: {
    type: Array,
    required: true,
  },
  outsViewHeaders: {
    type: Array,
    required: true,
  },
  serviceViewHeaders: {
    type: Array,
    required: true,
  },
  standardViewHeaders: {
    type: Array,
    required: true,
  },
  areaViewHeaders: {
    type: Array,
    required: true,
  },
  compliancesViewHeaders: {
    type: Array,
    required: true,
  },
  missionData: {
    type: Array,
    required: true,
  },
  missionId: {
    type: Number,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
])

const route = useRoute()
const missionParamsStore = useMissionParamsStore()
const missionListStore = useMissionListStore()
const localMissionData = ref((props.missionData))

const interventionId = ref('')
const parkId = ref('')
const interventionData = ref([])
const equipments = ref([])
const totalEquipment = ref()
const totalFireExtinguisher = ref()
const totalFireHose = ref()
const othersEquipment = ref()
const totalInspectedEquipment = ref()
const totalInspectedFireExtinguisher = ref()
const totalInspectedFireHose = ref()
const totalInspectedOthersEquipment = ref()
const categoryChart = ref({})
const categoriesLabels = ref({})
const categoriesSeries = ref({})
const statusChart = ref({})
const statusLabels = ref({})
const statusSeries = ref({})
const fireExtinguisherModelChart = ref({})
const fireExtinguisherModelLabels = ref({})
const fireExtinguisherModelSeries = ref({})
const inspectedFireExtinguisherModelWeight = ref({})
const inspectedFireExtinguisherModelWeightLabels = ref({})
const inspectedFireExtinguisherModelWeightSeries = ref({})
const rechargeRawModelWeight = ref({})
const rechargeRawModelWeightLabels = ref({})
const rechargeRawModelWeightSeries = ref({})
const totalRawMaterialForFireExtinguishers = ref({})
const totalRawMaterialForFireExtinguishersLabels = ref({})
const totalRawMaterialForFireExtinguishersSeries = ref({})
const nitrogenRecharge = ref()
const rechargedSparklet = ref()
const rechargeRaw = ref()
const rechargeNitrogenModelWeight = ref({})
const rechargeNitrogenModelWeightLabels = ref({})
const rechargeNitrogenModelWeightSeries = ref({})
const protectionFireExtinguisherWeight = ref({})
const protectionFireExtinguisherWeightLabels = ref({})
const protectionFireExtinguisherWeightSeries = ref({})

const accessoryFireExtinguisherWeight = ref({})
const accessoryFireExtinguisherWeightLabels = ref({})
const accessoryFireExtinguisherWeightSeries = ref({})

const supplyFireExtinguisherWeight = ref({})
const supplyFireExtinguisherWeightLabels = ref({})
const supplyFireExtinguisherWeightSeries = ref({})

const maintenanceFireExtinguisherWeight = ref({})
const maintenanceFireExtinguisherWeightLabels = ref({})
const maintenanceFireExtinguisherWeightSeries = ref({})

const additionalMaintenanceFireExtinguisherWeight = ref({})
const additionalMaintenanceFireExtinguisherWeightLabels = ref({})
const additionalMaintenanceFireExtinguisherWeightSeries = ref({})

const statusFireExtinguisherModelWeight = ref({})
const statusFireExtinguisherModelWeightLabels = ref({})
const statusFireExtinguisherModelWeightSeries = ref({})

const inspectedFireHoseModel = ref({})
const inspectedFireHoseModelLabels = ref({})
const inspectedFireHoseModelSeries = ref({})

const protectionFireHoseModel = ref({})
const protectionFireHoseModelLabels = ref({})
const protectionFireHoseModelSeries = ref({})

const accessoryFireHoseModel = ref({})
const accessoryFireHoseModelLabels = ref({})
const accessoryFireHoseModelSeries = ref({})

const supplyFireHoseModel = ref({})
const supplyFireHoseModelLabels = ref({})
const supplyFireHoseModelSeries = ref({})

const maintenanceFireHoseModel = ref({})
const maintenanceFireHoseModelLabels = ref({})
const maintenanceFireHoseModelSeries = ref({})

const additionalMaintenanceFireHoseModel = ref({})
const additionalMaintenanceFireHoseModelLabels = ref({})
const additionalMaintenanceFireHoseModelSeries = ref({})

const statusFireHoseModel= ref({})
const statusFireHoseModelLabels = ref({})
const statusFireHoseModelSeries = ref({})

const inspectedOthersEquipmentModel = ref({})
const inspectedOthersEquipmentModelLabels = ref({})
const inspectedOthersEquipmentModelSeries = ref({})

const protectionOthersEquipmentModel = ref({})
const protectionOthersEquipmentModelLabels = ref({})
const protectionOthersEquipmentModelSeries = ref({})

const accessoryOthersEquipmentModel = ref({})
const accessoryOthersEquipmentModelLabels = ref({})
const accessoryOthersEquipmentModelSeries = ref({})

const supplyOthersEquipmentModel = ref({})
const supplyOthersEquipmentModelLabels = ref({})
const supplyOthersEquipmentModelSeries = ref({})

const maintenanceOthersEquipmentModel = ref({})
const maintenanceOthersEquipmentModelLabels = ref({})
const maintenanceOthersEquipmentModelSeries = ref({})

const additionalMaintenanceOthersEquipmentModel = ref({})
const additionalMaintenanceOthersEquipmentModelLabels = ref({})
const additionalMaintenanceOthersEquipmentModelSeries = ref({})

const statusOthersEquipmentModel= ref({})
const statusOthersEquipmentModelLabels = ref({})
const statusOthersEquipmentModelSeries = ref({})

const totalPage = ref(1)
const totalAreas = ref(0)
const areas = ref([])
const totalRecommendations = ref(0)
const recommendations = ref([])
const totalServices = ref(0)
const services = ref([])
const totalOuts = ref(0)
const outs = ref([])
const totalStandards = ref(0)
const standards = ref([])
const totalCompliantAreas = ref(0)
const compliantAreas = ref([])
const totalNonCompliantAreas = ref(0)
const nonCompliantAreas = ref([])
const totalHazards = ref(0)
const hazards = ref([])
const totalSuggestions = ref(0)
const suggestions = ref([])

const totalEquipmentInService = ref()
const totalEquipmentLimitedUse = ref()
const totalEquipmentOutOfService = ref()

const options = ref({
  page: 1,
  itemsPerPage: 1000,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

const getPaginationMeta = list => {
  const start = (options.value.page - 1) * options.value.itemsPerPage + 1
  const end = Math.min(options.value.page * options.value.itemsPerPage, list.length)
  
  return `Showing ${start} to ${end} of ${list.length} entries`
}

const fetchParkAreas = async () => {
  if (!parkId.value) return // Don't fetch if parkId is empty

  try {
    const response = await missionListStore.fetchParkAreas(parkId.value)

    areas.value = response.data.data
    totalAreas.value = response.data.meta.total
    console.log(areas.value)
  } catch (error) {
    console.error('Error fetching park areas:', error)
  }
}

watchEffect(fetchParkAreas)

watchEffect(() => {
  if (parkId.value) {
    fetchParkAreas()
  }
})

// 👉 Watch for Dialog Visibility
watch(
  () => props.isDialogVisible,
  newVal => {
    if (newVal) {
      fetchServices()
      fetchCompliances()
      fetchNonCompliances()
      fetchHazards()
      fetchStandards()
      fetchRecommendations()
      fetchSuggestions()
      fetchOuts()
      fetchIntervention()
    }
  },
)

// 👉 Watch for Mission Data Changes
watch(
  () => props.missionData,
  newVal => {
    localMissionData.value = newVal
    fetchServices()
    fetchCompliances()
    fetchNonCompliances()
    fetchHazards()
    fetchStandards()
    fetchRecommendations()
    fetchSuggestions()
    fetchOuts()
    fetchIntervention()
  },
  { deep: true },
)

// 👉 Fetch Services
const fetchServices = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionServices({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      services.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalServices.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched services:', services.value)
    })
    .catch(error => {
      console.error('Error fetching services:', error)
    })
}

const fetchRecommendations = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionRecommendations({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      recommendations.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalRecommendations.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched recommendations:', recommendations.value)
    })
    .catch(error => {
      console.error('Error fetching recommendations:', error)
    })
}

// 👉 Fetch Suggestions
const fetchSuggestions = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionSuggestions({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      suggestions.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalSuggestions.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched suggestions:', suggestions.value)
    })
    .catch(error => {
      console.error('Error fetching suggestions:', error)
    })
}

const fetchOuts = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionOuts({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      outs.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalOuts.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched outs:', outs.value)
    })
    .catch(error => {
      console.error('Error fetching outs:', error)
    })
}

const fetchStandards = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionStandards({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      standards.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalStandards.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched standards:', standards.value)
    })
    .catch(error => {
      console.error('Error fetching standards:', error)
    })
}

const fetchCompliances = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionCompliancesCompliant({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      compliantAreas.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalCompliantAreas.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched compliantAreas:', compliantAreas.value)
    })
    .catch(error => {
      console.error('Error fetching compliantAreas:', error)
    })
}


const fetchNonCompliances = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionCompliancesNonCompliant({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      nonCompliantAreas.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalNonCompliantAreas.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched nonCompliantAreas:', nonCompliantAreas.value)
    })
    .catch(error => {
      console.error('Error fetching nonCompliantAreas:', error)
    })
}

const fetchHazards = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMissionHazards({
    id: props.missionId,
    options: options.value,
  })
    .then(response => {
      hazards.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalHazards.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched hazards:', hazards.value)
    })
    .catch(error => {
      console.error('Error fetching hazards:', error)
    })
}

const filteredRecommendations = computed(() => {
  return {
    critical: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'critical'),
    immediate: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'immediate'),
    short_term: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'short_term'),
    long_term: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'long_term'),
  }
})

const filteredSuggestions = computed(() => {
  return {
    monthly: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'monthly'),
    quarterly: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'quarterly'),
    semi_annual: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'semi_annual'),
    annual: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'annual'),
    as_needed: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'as_needed'),
    
  }
})

const fetchIntervention = async () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  try {
    // Ensure missionId is logged and its type is correct
    console.log('Mission ID:', props.missionId, 'Type:', typeof props.missionId)

    const response = await missionListStore.fetchIntervention(props.missionId)

    interventionData.value = response.data.data
    interventionId.value = interventionData.value.id
    parkId.value = interventionData.value.park

    await fetchInspectedEquipments() // Assuming this is an async function
    await fetchParkAreas()           // Assuming this is an async function

  } catch (error) {
    console.error('Error fetching intervention:', error)
  }
}

// 👉 Fetching equipments
const fetchInspectedEquipments = () => {
  if (!props.missionId) {
    console.warn('Mission ID is not available.')
    
    return
  }

  missionListStore.fetchMetaInspectedEquipments({
    id: interventionId.value,
  })
    .then(response => {
      equipments.value = response.data.meta
      totalEquipment.value = response.data.meta.total_equipment
      totalFireExtinguisher.value = response.data.meta.total_fire_extinguishers
      totalFireHose.value = response.data.meta.total_fire_hoses
      othersEquipment.value = response.data.meta.total_others_equipment
    
      totalInspectedEquipment.value = response.data.meta.inspected_equipment
      totalInspectedFireExtinguisher.value = response.data.meta.inspected_fire_extinguisher
      totalInspectedFireHose.value = response.data.meta.inspected_fire_hose
      totalInspectedOthersEquipment.value = response.data.meta.inspected_others_equipment
    
      categoryChart.value = response.data.meta.total_equipment_by_category
      categoriesLabels.value = Object.keys(categoryChart.value)
      categoriesSeries.value = Object.values(categoryChart.value)
    
      statusChart.value = response.data.meta.equipment_by_status
      statusLabels.value = Object.keys(statusChart.value)
      statusSeries.value = Object.values(statusChart.value)
    
      fireExtinguisherModelChart.value = response.data.meta.total_fire_extinguishers_by_model
      fireExtinguisherModelLabels.value = Object.keys(fireExtinguisherModelChart.value)
      fireExtinguisherModelSeries.value = Object.values(fireExtinguisherModelChart.value)
    
      inspectedFireExtinguisherModelWeight.value = response.data.meta.inspected_fire_extinguisher_by_model_weight
      inspectedFireExtinguisherModelWeightLabels.value = Object.keys(inspectedFireExtinguisherModelWeight.value)
      inspectedFireExtinguisherModelWeightSeries.value = Object.values(inspectedFireExtinguisherModelWeight.value)
    
      rechargeRawModelWeight.value = response.data.meta.raw_recharged_fire_extinguisher_by_model_weight
      rechargeRawModelWeightLabels.value = Object.keys(rechargeRawModelWeight.value)
      rechargeRawModelWeightSeries.value = Object.values(rechargeRawModelWeight.value)
    
      totalRawMaterialForFireExtinguishers.value = response.data.meta.total_raw_material_for_fire_extinguishers
      totalRawMaterialForFireExtinguishersLabels.value = Object.keys(totalRawMaterialForFireExtinguishers.value)
      totalRawMaterialForFireExtinguishersSeries.value = Object.values(totalRawMaterialForFireExtinguishers.value)
    
      nitrogenRecharge.value = response.data.meta.nitrogen_recharged_fire_extinguisher_count
      rechargedSparklet.value = response.data.meta.recharged_sparklet_count
      rechargeRaw.value = response.data.meta.raw_recharged_fire_extinguisher_count
    
      rechargeNitrogenModelWeight.value = response.data.meta.nitrogen_recharged_fire_extinguisher_by_model_weight
      rechargeNitrogenModelWeightLabels.value = Object.keys(rechargeNitrogenModelWeight.value)
      rechargeNitrogenModelWeightSeries.value = Object.values(rechargeNitrogenModelWeight.value)
    
      protectionFireExtinguisherWeight.value = response.data.meta.protection_by_fire_extinguisher
      protectionFireExtinguisherWeightLabels.value = Object.keys(protectionFireExtinguisherWeight.value)
      protectionFireExtinguisherWeightSeries.value = Object.values(protectionFireExtinguisherWeight.value)
    
      accessoryFireExtinguisherWeight.value = response.data.meta.accessory_fire_extinguisher_counts
      accessoryFireExtinguisherWeightLabels.value = Object.keys(accessoryFireExtinguisherWeight.value)
      accessoryFireExtinguisherWeightSeries.value = Object.values(accessoryFireExtinguisherWeight.value)
    
      supplyFireExtinguisherWeight.value = response.data.meta.supply_fire_extinguisher_counts
      supplyFireExtinguisherWeightLabels.value = Object.keys(supplyFireExtinguisherWeight.value)
      supplyFireExtinguisherWeightSeries.value = Object.values(supplyFireExtinguisherWeight.value)
    
      maintenanceFireExtinguisherWeight.value = response.data.meta.maintenance_fire_extinguisher_counts
      maintenanceFireExtinguisherWeightLabels.value = Object.keys(maintenanceFireExtinguisherWeight.value)
      maintenanceFireExtinguisherWeightSeries.value = Object.values(maintenanceFireExtinguisherWeight.value)
    
      additionalMaintenanceFireExtinguisherWeight.value = response.data.meta.additional_maintenance_fire_extinguisher_counts
      additionalMaintenanceFireExtinguisherWeightLabels.value = Object.keys(additionalMaintenanceFireExtinguisherWeight.value)
      additionalMaintenanceFireExtinguisherWeightSeries.value = Object.values(additionalMaintenanceFireExtinguisherWeight.value)

      statusFireExtinguisherModelWeight.value = response.data.meta.fire_extinguisher_by_status
      statusFireExtinguisherModelWeightLabels.value = Object.keys(statusFireExtinguisherModelWeight.value)
      statusFireExtinguisherModelWeightSeries.value = Object.values(statusFireExtinguisherModelWeight.value)

      inspectedFireHoseModel.value = response.data.meta.inspected_fire_hose_by_model
      inspectedFireHoseModelLabels.value = Object.keys(inspectedFireHoseModel.value)
      inspectedFireHoseModelSeries.value = Object.values(inspectedFireHoseModel.value)

      protectionFireHoseModel.value = response.data.meta.protection_fire_hose_by_model
      protectionFireHoseModelLabels.value = Object.keys(protectionFireHoseModel.value)
      protectionFireHoseModelSeries.value = Object.values(protectionFireHoseModel.value)
    
      accessoryFireHoseModel.value = response.data.meta.accessory_fire_hose_counts
      accessoryFireHoseModelLabels.value = Object.keys(accessoryFireHoseModel.value)
      accessoryFireHoseModelSeries.value = Object.values(accessoryFireHoseModel.value)

      supplyFireHoseModel.value = response.data.meta.supply_fire_hose_counts
      supplyFireHoseModelLabels.value = Object.keys(supplyFireHoseModel.value)
      supplyFireHoseModelSeries.value = Object.values(supplyFireHoseModel.value)

      maintenanceFireHoseModel.value = response.data.meta.maintenance_fire_hose_counts
      maintenanceFireHoseModelLabels.value = Object.keys(maintenanceFireHoseModel.value)
      maintenanceFireHoseModelSeries.value = Object.values(maintenanceFireHoseModel.value)
    
      additionalMaintenanceFireHoseModel.value = response.data.meta.additional_maintenance_fire_hose_counts
      additionalMaintenanceFireHoseModelLabels.value = Object.keys(additionalMaintenanceFireHoseModel.value)
      additionalMaintenanceFireHoseModelSeries.value = Object.values(additionalMaintenanceFireHoseModel.value)
    
      statusFireHoseModel.value = response.data.meta.fire_hose_by_status
      statusFireHoseModelLabels.value = Object.keys(statusFireHoseModel.value)
      statusFireHoseModelSeries.value = Object.values(statusFireHoseModel.value)

      inspectedOthersEquipmentModel.value = response.data.meta.inspected_others_equipment_by_model
      inspectedOthersEquipmentModelLabels.value = Object.keys(inspectedOthersEquipmentModel.value)
      inspectedOthersEquipmentModelSeries.value = Object.values(inspectedOthersEquipmentModel.value)

      protectionOthersEquipmentModel.value = response.data.meta.protection_others_equipment_by_model
      protectionOthersEquipmentModelLabels.value = Object.keys(protectionOthersEquipmentModel.value)
      protectionOthersEquipmentModelSeries.value = Object.values(protectionOthersEquipmentModel.value)
    
      accessoryOthersEquipmentModel.value = response.data.meta.accessory_others_equipment_counts
      accessoryOthersEquipmentModelLabels.value = Object.keys(accessoryOthersEquipmentModel.value)
      accessoryOthersEquipmentModelSeries.value = Object.values(accessoryOthersEquipmentModel.value)

      supplyOthersEquipmentModel.value = response.data.meta.supply_others_equipment_counts
      supplyOthersEquipmentModelLabels.value = Object.keys(supplyOthersEquipmentModel.value)
      supplyOthersEquipmentModelSeries.value = Object.values(supplyOthersEquipmentModel.value)

      maintenanceOthersEquipmentModel.value = response.data.meta.maintenance_others_equipment_counts
      maintenanceOthersEquipmentModelLabels.value = Object.keys(maintenanceOthersEquipmentModel.value)
      maintenanceOthersEquipmentModelSeries.value = Object.values(maintenanceOthersEquipmentModel.value)

      additionalMaintenanceOthersEquipmentModel.value = response.data.meta.additional_maintenance_others_equipment_counts
      additionalMaintenanceOthersEquipmentModelLabels.value = Object.keys(additionalMaintenanceOthersEquipmentModel.value)
      additionalMaintenanceOthersEquipmentModelSeries.value = Object.values(additionalMaintenanceOthersEquipmentModel.value)
    
      statusOthersEquipmentModel.value = response.data.meta.others_equipment_by_status
      statusOthersEquipmentModelLabels.value = Object.keys(statusOthersEquipmentModel.value)
      statusOthersEquipmentModelSeries.value = Object.values(statusOthersEquipmentModel.value)

      totalEquipmentInService.value = response.data.meta.total_equipment_in_service
      totalEquipmentLimitedUse.value = response.data.meta.total_equipment_limited_use
      totalEquipmentOutOfService.value = response.data.meta.total_equipment_out_of_service

      console.log('Fetched equipments:', equipments.value)
    })
    .catch(error => {
      console.error('Error fetching hazards:', error)
    })
}

// const fetchInspectedEquipments = () => {
//   missionListStore.fetchMetaInspectedEquipments({
//     id: interventionId.value,
//   }).then(response => {
//     console.log('Function called')
//     equipments.value = response.data.meta
//     totalEquipment.value = response.data.meta.total_equipment
//     totalFireExtinguisher.value = response.data.meta.total_fire_extinguishers
//     totalFireHose.value = response.data.meta.total_fire_hoses
//     othersEquipment.value = response.data.meta.total_others_equipment
    
//     totalInspectedEquipment.value = response.data.meta.inspected_equipment
//     totalInspectedFireExtinguisher.value = response.data.meta.inspected_fire_extinguisher
//     totalInspectedFireHose.value = response.data.meta.inspected_fire_hose
//     totalInspectedOthersEquipment.value = response.data.meta.inspected_others_equipment
    
//     categoryChart.value = response.data.meta.total_equipment_by_category
//     categoriesLabels.value = Object.keys(categoryChart.value)
//     categoriesSeries.value = Object.values(categoryChart.value)
    
//     statusChart.value = response.data.meta.equipment_by_status
//     statusLabels.value = Object.keys(statusChart.value)
//     statusSeries.value = Object.values(statusChart.value)
    
//     fireExtinguisherModelChart.value = response.data.meta.total_fire_extinguishers_by_model
//     fireExtinguisherModelLabels.value = Object.keys(fireExtinguisherModelChart.value)
//     fireExtinguisherModelSeries.value = Object.values(fireExtinguisherModelChart.value)
    
//     inspectedFireExtinguisherModelWeight.value = response.data.meta.inspected_fire_extinguisher_by_model_weight
//     inspectedFireExtinguisherModelWeightLabels.value = Object.keys(inspectedFireExtinguisherModelWeight.value)
//     inspectedFireExtinguisherModelWeightSeries.value = Object.values(inspectedFireExtinguisherModelWeight.value)
    
//     rechargeRawModelWeight.value = response.data.meta.raw_recharged_fire_extinguisher_by_model_weight
//     rechargeRawModelWeightLabels.value = Object.keys(rechargeRawModelWeight.value)
//     rechargeRawModelWeightSeries.value = Object.values(rechargeRawModelWeight.value)
    
//     totalRawMaterialForFireExtinguishers.value = response.data.meta.total_raw_material_for_fire_extinguishers
//     totalRawMaterialForFireExtinguishersLabels.value = Object.keys(totalRawMaterialForFireExtinguishers.value)
//     totalRawMaterialForFireExtinguishersSeries.value = Object.values(totalRawMaterialForFireExtinguishers.value)
    
//     nitrogenRecharge.value = response.data.meta.nitrogen_recharged_fire_extinguisher_count
//     rechargedSparklet.value = response.data.meta.recharged_sparklet_count
//     rechargeRaw.value = response.data.meta.raw_recharged_fire_extinguisher_count
    
//     rechargeNitrogenModelWeight.value = response.data.meta.nitrogen_recharged_fire_extinguisher_by_model_weight
//     rechargeNitrogenModelWeightLabels.value = Object.keys(rechargeNitrogenModelWeight.value)
//     rechargeNitrogenModelWeightSeries.value = Object.values(rechargeNitrogenModelWeight.value)
    
//     protectionFireExtinguisherWeight.value = response.data.meta.protection_by_fire_extinguisher
//     protectionFireExtinguisherWeightLabels.value = Object.keys(protectionFireExtinguisherWeight.value)
//     protectionFireExtinguisherWeightSeries.value = Object.values(protectionFireExtinguisherWeight.value)
    
//     accessoryFireExtinguisherWeight.value = response.data.meta.accessory_fire_extinguisher_counts
//     accessoryFireExtinguisherWeightLabels.value = Object.keys(accessoryFireExtinguisherWeight.value)
//     accessoryFireExtinguisherWeightSeries.value = Object.values(accessoryFireExtinguisherWeight.value)
    
//     supplyFireExtinguisherWeight.value = response.data.meta.supply_fire_extinguisher_counts
//     supplyFireExtinguisherWeightLabels.value = Object.keys(supplyFireExtinguisherWeight.value)
//     supplyFireExtinguisherWeightSeries.value = Object.values(supplyFireExtinguisherWeight.value)
    
//     maintenanceFireExtinguisherWeight.value = response.data.meta.maintenance_fire_extinguisher_counts
//     maintenanceFireExtinguisherWeightLabels.value = Object.keys(maintenanceFireExtinguisherWeight.value)
//     maintenanceFireExtinguisherWeightSeries.value = Object.values(maintenanceFireExtinguisherWeight.value)
    
//     additionalMaintenanceFireExtinguisherWeight.value = response.data.meta.additional_maintenance_fire_extinguisher_counts
//     additionalMaintenanceFireExtinguisherWeightLabels.value = Object.keys(additionalMaintenanceFireExtinguisherWeight.value)
//     additionalMaintenanceFireExtinguisherWeightSeries.value = Object.values(additionalMaintenanceFireExtinguisherWeight.value)

//     statusFireExtinguisherModelWeight.value = response.data.meta.fire_extinguisher_by_status
//     statusFireExtinguisherModelWeightLabels.value = Object.keys(statusFireExtinguisherModelWeight.value)
//     statusFireExtinguisherModelWeightSeries.value = Object.values(statusFireExtinguisherModelWeight.value)

//     inspectedFireHoseModel.value = response.data.meta.inspected_fire_hose_by_model
//     inspectedFireHoseModelLabels.value = Object.keys(inspectedFireHoseModel.value)
//     inspectedFireHoseModelSeries.value = Object.values(inspectedFireHoseModel.value)

//     protectionFireHoseModel.value = response.data.meta.protection_fire_hose_by_model
//     protectionFireHoseModelLabels.value = Object.keys(protectionFireHoseModel.value)
//     protectionFireHoseModelSeries.value = Object.values(protectionFireHoseModel.value)
    
//     accessoryFireHoseModel.value = response.data.meta.accessory_fire_hose_counts
//     accessoryFireHoseModelLabels.value = Object.keys(accessoryFireHoseModel.value)
//     accessoryFireHoseModelSeries.value = Object.values(accessoryFireHoseModel.value)

//     supplyFireHoseModel.value = response.data.meta.supply_fire_hose_counts
//     supplyFireHoseModelLabels.value = Object.keys(supplyFireHoseModel.value)
//     supplyFireHoseModelSeries.value = Object.values(supplyFireHoseModel.value)

//     maintenanceFireHoseModel.value = response.data.meta.maintenance_fire_hose_counts
//     maintenanceFireHoseModelLabels.value = Object.keys(maintenanceFireHoseModel.value)
//     maintenanceFireHoseModelSeries.value = Object.values(maintenanceFireHoseModel.value)
    
//     additionalMaintenanceFireHoseModel.value = response.data.meta.additional_maintenance_fire_hose_counts
//     additionalMaintenanceFireHoseModelLabels.value = Object.keys(additionalMaintenanceFireHoseModel.value)
//     additionalMaintenanceFireHoseModelSeries.value = Object.values(additionalMaintenanceFireHoseModel.value)
    
//     statusFireHoseModel.value = response.data.meta.fire_hose_by_status
//     statusFireHoseModelLabels.value = Object.keys(statusFireHoseModel.value)
//     statusFireHoseModelSeries.value = Object.values(statusFireHoseModel.value)

//     inspectedOthersEquipmentModel.value = response.data.meta.inspected_others_equipment_by_model
//     inspectedOthersEquipmentModelLabels.value = Object.keys(inspectedOthersEquipmentModel.value)
//     inspectedOthersEquipmentModelSeries.value = Object.values(inspectedOthersEquipmentModel.value)

//     protectionOthersEquipmentModel.value = response.data.meta.protection_others_equipment_by_model
//     protectionOthersEquipmentModelLabels.value = Object.keys(protectionOthersEquipmentModel.value)
//     protectionOthersEquipmentModelSeries.value = Object.values(protectionOthersEquipmentModel.value)
    
//     accessoryOthersEquipmentModel.value = response.data.meta.accessory_others_equipment_counts
//     accessoryOthersEquipmentModelLabels.value = Object.keys(accessoryOthersEquipmentModel.value)
//     accessoryOthersEquipmentModelSeries.value = Object.values(accessoryOthersEquipmentModel.value)

//     supplyOthersEquipmentModel.value = response.data.meta.supply_others_equipment_counts
//     supplyOthersEquipmentModelLabels.value = Object.keys(supplyOthersEquipmentModel.value)
//     supplyOthersEquipmentModelSeries.value = Object.values(supplyOthersEquipmentModel.value)

//     maintenanceOthersEquipmentModel.value = response.data.meta.maintenance_others_equipment_counts
//     maintenanceOthersEquipmentModelLabels.value = Object.keys(maintenanceOthersEquipmentModel.value)
//     maintenanceOthersEquipmentModelSeries.value = Object.values(maintenanceOthersEquipmentModel.value)

//     additionalMaintenanceOthersEquipmentModel.value = response.data.meta.additional_maintenance_others_equipment_counts
//     additionalMaintenanceOthersEquipmentModelLabels.value = Object.keys(additionalMaintenanceOthersEquipmentModel.value)
//     additionalMaintenanceOthersEquipmentModelSeries.value = Object.values(additionalMaintenanceOthersEquipmentModel.value)
    
//     statusOthersEquipmentModel.value = response.data.meta.others_equipment_by_status
//     statusOthersEquipmentModelLabels.value = Object.keys(statusOthersEquipmentModel.value)
//     statusOthersEquipmentModelSeries.value = Object.values(statusOthersEquipmentModel.value)
//   }).catch(error => {
//     console.error(error)
//   })
// }

const equipmentCount = computed(() => {
  if (totalEquipment.value === null || totalEquipment.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalEquipment.value
})

const fireExtinguisherCount = computed(() => {
  if (totalFireExtinguisher.value === null || totalFireExtinguisher.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalFireExtinguisher.value
})

const fireHoseCount = computed(() => {
  if (totalFireHose.value === null || totalFireHose.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalFireHose.value
})

const othersEquipmentCount = computed(() => {
  if (othersEquipment.value === null || othersEquipment.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return othersEquipment.value
})


const statisticsVerticalSimple = [
  {
    title: 'Equipment',
    color: 'primary',
    stats: equipmentCount,
    icon: 'tabler-tool',
  },
  {
    title: 'Fire Extinguisher',
    color: 'primary',
    stats: fireExtinguisherCount,
    icon: 'tabler-fire-extinguisher',
  },
  {
    title: 'Fire Hose',
    color: 'primary',
    stats: fireHoseCount,
    icon: 'tabler-firetruck',
  },
  {
    title: 'Others Equipment',
    color: 'primary',
    stats: othersEquipmentCount,
    icon: 'tabler-tools',
  },
]

const equipmentTables = [
  {
    description: 'Equipment',
    quantity: equipmentCount,
  },
  {
    description: 'Fire Extinguisher',
    quantity: fireExtinguisherCount,
  },
  {
    description: 'Fire Hose',
    quantity: fireHoseCount,
  },
  {
    description: 'Others Equipment',
    quantity: othersEquipmentCount,
  },
]

const parsedTeamMembers = teamMembers => {
  try {
    return JSON.parse(teamMembers)
  } catch (error) {
    return []
  }
}

const hasStatusFireExtinguisher = computed(() => {
  return Object.keys(statusFireExtinguisherModelWeight.value).length > 0
})

const hasRechargeRawFireExtinguisher = computed(() => {
  return Object.keys(rechargeRawModelWeight.value).length > 0
})

const hasRechargeNitrogenFireExtinguisher = computed(() => {
  return Object.keys(rechargeNitrogenModelWeight.value).length > 0
})

const hasTotalRawMaterialFireExtinguisher = computed(() => {
  return Object.keys(totalRawMaterialForFireExtinguishers.value).length > 0
})

const hasInspectedFireExtinguisher = computed(() => {
  return Object.keys(inspectedFireExtinguisherModelWeight.value).length > 0
})

const hasOutOfOrderQrcFireExtinguisher = computed(() => {
  return Object.keys(outOfOrderQrcFireExtinguisherModelWeight.value).length > 0
})

const hasProtectionFireExtinguisher = computed(() => {
  return Object.keys(protectionFireExtinguisherWeight.value).length > 0
})

const hasAccessoryFireExtinguisher = computed(() => {
  return Object.keys(accessoryFireExtinguisherWeight.value).length > 0
})

const hasSupplyFireExtinguisher = computed(() => {
  return Object.keys(supplyFireExtinguisherWeight.value).length > 0
})

const hasMaintenanceFireExtinguisher = computed(() => {
  return Object.keys(maintenanceFireExtinguisherWeight.value).length > 0
})

const hasAdditionalMaintenanceFireExtinguisher = computed(() => {
  return Object.keys(additionalMaintenanceFireExtinguisherWeight.value).length > 0
})

const hasStatusFireHose = computed(() => {
  return Object.keys(statusFireHoseModel.value).length > 0
})

const hasInspectedFireHose = computed(() => {
  return Object.keys(inspectedFireHoseModel.value).length > 0
})

const hasOutOfOrderQrcFireHose = computed(() => {
  return Object.keys(outOfOrderQrcFireHoseModel.value).length > 0
})

const hasProtectionFireHose = computed(() => {
  return Object.keys(protectionFireHoseModel.value).length > 0
})

const hasAccessoryFireHose = computed(() => {
  return Object.keys(accessoryFireHoseModel.value).length > 0
})

const hasSupplyFireHose = computed(() => {
  return Object.keys(supplyFireHoseModel.value).length > 0
})

const hasMaintenanceFireHose = computed(() => {
  return Object.keys(maintenanceFireHoseModel.value).length > 0
})

const hasAdditionalMaintenanceFireHose = computed(() => {
  return Object.keys(additionalMaintenanceFireHoseModel.value).length > 0
})

const hasStatusOthersEquipment = computed(() => {
  return Object.keys(statusOthersEquipmentModel.value).length > 0
})

const hasInspectedOthersEquipment = computed(() => {
  return Object.keys(inspectedOthersEquipmentModel.value).length > 0
})

const hasProtectionOthersEquipment = computed(() => {
  return Object.keys(protectionOthersEquipmentModel.value).length > 0
})

const hasAccessoryOthersEquipment = computed(() => {
  return Object.keys(accessoryOthersEquipmentModel.value).length > 0
})

const hasSupplyOthersEquipment = computed(() => {
  return Object.keys(supplyOthersEquipmentModel.value).length > 0
})

const hasMaintenanceOthersEquipment = computed(() => {
  return Object.keys(maintenanceOthersEquipmentModel.value).length > 0
})

const hasAdditionalMaintenanceOthersEquipment = computed(() => {
  return Object.keys(additionalMaintenanceOthersEquipmentModel.value).length > 0
})
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 1000"
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />

    <VCard class="pa-sm-8 pa-5">
      <VCardItem class="text-center">
        <VCardTitle class="text-h3 mb-3">
          Attestation of Fire Safety Equipment Inspection
        </VCardTitle>
      </VCardItem>

      <VCardText>
        <VRow>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-0"
              elevation="2"
              class="pa-0"
            >
              <VCardText>
                <h5 class="text-h6">
                  Mission Date: {{ localMissionData.mission_date }}
                </h5>
                <p>
                  This document attests that SS PLUS has conducted a comprehensive inspection of fire safety equipment at:
                </p>
                <VRow>
                  <VCol cols="6">
                    <VList>
                      <VListItem>
                        <VListItemTitle>Client ID: </VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.mission_client_id }}</VListItemSubtitle>
                        <VListItemTitle>Client Name: </VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.client_name }}</VListItemSubtitle>
                      </VListItem>
                    </VList>
                  </VCol>
                  <VCol cols="6">
                    <VList>
                      <VListItem>
                        <VListItemTitle>Park : </VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.park_title }}</VListItemSubtitle>
                        <VListItemTitle>Address : </VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.park_address }} {{ localMissionData.park_postcode }} {{ localMissionData.park_city }} {{ localMissionData.park_country }}</VListItemSubtitle>
                      </VListItem>
                    </VList>
                  </VCol>
                </VRow>
                <VRow class="mt-0">
                  <VCol
                    cols="12"
                    class="pa-0"
                  >
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText class="pa-0">
                        <h3 class="text-h6">
                          Scope of Inspection
                        </h3>
                        <p>
                          Our team has thoroughly inspected and tested the following fire safety equipment:
                        </p>
                        <h4>1.1 Fire Extinguishers</h4>
                        <VTable class="text-no-wrap">
                          <tbody>
                            <tr
                              v-for="(label, index) in fireExtinguisherModelLabels"
                              :key="index"
                            >
                              <td class="text-uppercase">
                                FIRE EXTINGUISHER {{ label }}
                              </td>
                              <td class="text-center">
                                {{ fireExtinguisherModelSeries[index] }}
                              </td>
                            </tr>
                          </tbody>
                        </VTable>
                        <h4>1.2 Fire Hoses</h4>
                        <VTable class="text-no-wrap">
                          <tbody>
                            <tr
                              v-for="(label, index) in inspectedFireHoseModelLabels"
                              :key="index"
                            >
                              <td class="text-uppercase">
                                {{ label }}
                              </td>
                              <td class="text-center ">
                                {{ inspectedFireHoseModelSeries[index] }}
                              </td>
                            </tr>
                          </tbody>
                        </VTable>
                        <h4>1.3 Others Equipment</h4>
                        <VTable class="text-no-wrap">
                          <tbody>
                            <tr
                              v-for="(label, index) in inspectedOthersEquipmentModelLabels"
                              :key="index"
                            >
                              <td class="text-uppercase">
                                {{ label }}
                              </td>
                              <td class="text-center ">
                                {{ inspectedOthersEquipmentModelSeries[index] }}
                              </td>
                            </tr>
                          </tbody>
                        </VTable>
                      </VCardText>
                      <VDivider />
                      <VCardText>
                        <h3 class="text-h6">
                          Inspection Details
                        </h3>
                        <VList>
                          <VListItem>
                            <VListItemTitle>Date of Inspection: </VListItemTitle>
                            <VListItemSubtitle>{{ localMissionData.mission_date }}</VListItemSubtitle>
                            <VListItemTitle>Lead Technician : </VListItemTitle>
                            <VListItemSubtitle>{{ localMissionData.team_leader }} </VListItemSubtitle>
                            <VListItemTitle>Assisting Technicians::</VListItemTitle>
                            <VListItemSubtitle
                              v-for="teamMember in parsedTeamMembers(localMissionData.team_members)"
                              :key="teamMember"
                            >
                              {{ teamMember }}
                            </VListItemSubtitle>
                          </VListItem>
                        </VList>
                      </VCardText>
                      <VCardText class="pa-0">
                        <h4 class="text-h6">
                          Summary of Findings
                        </h4>
                        <VRow>
                          <VCol cols="7">
                            <VList>
                              <VListItem>
                                <VListItemTitle>Equipment Inspected : </VListItemTitle>
                                <VListItemSubtitle>{{ totalEquipment }}  equipment</VListItemSubtitle>
                                <VListItemTitle> Compliance Rate: </VListItemTitle>
                                <VListItemSubtitle>{{ localMissionData.compliance_rate }} % compliance with current safety standards and regulations</VListItemSubtitle>
                              </VListItem>
                            </VList>
                          </VCol>
                          <VCol cols="5">
                            <VList>
                              <VListItem>
                                <VListItemTitle>Operational Status :</VListItemTitle>
                                <VListItemSubtitle>{{ totalEquipmentInService }}  equipment found in good working order</VListItemSubtitle>
                                <VListItemSubtitle>{{ totalEquipmentLimitedUse }}  equipment found in limited use</VListItemSubtitle>
                                <VListItemSubtitle>{{ totalEquipmentOutOfService }}  equipment found in out of service</VListItemSubtitle>
                              </VListItem>
                            </VList>
                          </VCol>
                        </VRow>
                      </VCardText>
                      <VDivider />
                      <VCardText>
                        <h3 class="text-h6">
                          Certification
                        </h3>
                        <p>
                          I hereby certify that the above-mentioned fire safety equipment has been inspected and tested in accordance with the relevant safety standards and manufacturer guidelines. Any deficiencies found have been noted in our detailed report and communicated to the client.
                        </p>
                        <p>
                          Operational Manager's Signature
                        </p>
                        <p>
                          Name: Mohamed CHRAITI
                        </p>
                        <p>
                          SS PLUS Fire Safety Services
                        </p>
                      </VCardText>
                    </VCard>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>
