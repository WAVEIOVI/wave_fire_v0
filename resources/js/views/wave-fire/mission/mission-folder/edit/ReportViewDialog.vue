<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useMissionListStore } from '../useMissionListStore'
import { useMissionParamsStore } from '../useMissionParamsStore'
import ChartCategories from './meta-data/ChartCategories.vue'
import ChartStatus from './meta-data/ChartStatus.vue'

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
})

const emit = defineEmits([
  'update:isDialogVisible',
])

const sections = ref([
  { title: '1. Executive Summary' },
  { title: '2. Client and Site Details' },
  { title: '3. Scope of Work' },
  { title: '4. Findings and Actions' },
  { title: '5. Recommendations' },
  { title: '6. Follow-up Plan' },
  { title: '7. Client Acknowledgment' },
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

const fetchServices = () => {
  missionListStore.fetchMissionServices({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    services.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalServices.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchServices)

const fetchRecommendations = () => {
  missionListStore.fetchMissionRecommendations({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    recommendations.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalRecommendations.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchRecommendations)

const fetchSuggestions = () => {
  missionListStore.fetchMissionSuggestions({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    suggestions.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalSuggestions.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchSuggestions)

const fetchOuts = () => {
  missionListStore.fetchMissionOuts({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    outs.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalOuts.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchOuts)

const fetchStandards = () => {
  missionListStore.fetchMissionStandards({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    standards.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalStandards.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchStandards)

const fetchCompliances = () => {
  missionListStore.fetchMissionCompliancesCompliant({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    compliantAreas.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalCompliantAreas.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchCompliances)

const fetchNonCompliances = () => {
  missionListStore.fetchMissionCompliancesNonCompliant({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    nonCompliantAreas.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalNonCompliantAreas.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchNonCompliances)

const fetchHazards = () => {
  missionListStore.fetchMissionHazards({
    id: Number(route.params.id),
    options: options.value,
  }).then(response => {
    hazards.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalHazards.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchHazards)


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

onMounted(() => {
  fetchIntervention()
})

const fetchIntervention = async () => {
  try {
    const response=await missionListStore
      .fetchIntervention(Number(route.params.id))

    interventionData.value = response.data.data
    interventionId.value = interventionData.value.id
    parkId.value = interventionData.value.park
    fetchInspectedEquipments() // Assuming this function exists
    // Assuming this function exists
    await fetchParkAreas()
  } catch(error) {
    console.error(error)
  }
}

// 👉 Fetching equipments
const fetchInspectedEquipments = () => {
  missionListStore.fetchMetaInspectedEquipments({
    id: interventionId.value,
  }).then(response => {
    console.log('Function called')
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
  }).catch(error => {
    console.error(error)
  })
}

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
    :width="$vuetify.display.smAndDown ? 'auto' : 1600"
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />

    <VCard class="pa-sm-8 pa-5">
      <VCardItem class="text-center">
        <VCardTitle class="text-h3 mb-3">
          Mission Report
        </VCardTitle>
      </VCardItem>

      <VCardText>
        <VRow>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              title="Table of Contents"
              elevation="2"
              class="pa-0"
            >
              <VCardText class="pa-0">
                <VList dense>
                  <VListItem
                    v-for="(section, index) in sections"
                    :key="index"
                    :href="'#section-' + index"
                    link
                  >
                    <VListItemTitle>{{ section.title }}</VListItemTitle>
                  </VListItem>
                </VList>
              </VCardText>
            </VCard>
          </VCol>
          
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-0"
              elevation="2"
              class="pa-0"
            >
              <VCardTitle class="text-h4">
                1. Executive Summary
              </VCardTitle>
              <VCardText>
                <h5 class="text-h6">
                  1.1 Brief Overview of Intervention
                </h5>
                <p>On {{ localMissionData.mission_date }}, our team, led by {{ localMissionData.team_leader }}, conducted a comprehensive fire safety equipment service inspection at {{ localMissionData.client_name }}. The intervention covered {{ totalAreas }} areas in {{ localMissionData.park_id }} {{ localMissionData.park_title }} located at {{ localMissionData.park_address }}. Our primary focus was on assessing the condition and functionality of various fire safety systems and equipment.</p>

                <h5 class="text-h6 mt-4">
                  1.2 Key Findings and Actions
                </h5>
                <VRow class="match-height"> 
                  <VCol
                    v-for="statistics in statisticsVerticalSimple"
                    :key="statistics.title"
                    cols="12"
                    sm="6"
                    md="3"
                  >
                    <CardOutlineStatisticsVerticalSimple v-bind="statistics" />
                  </VCol>
                </VRow>

                <VRow class="mt-0">
                  <VCol
                    cols="12"
                    md="8"
                    class="pa-0"
                  >
                    <VCard
                      title="Equipment Inspected"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText class="pa-0">
                        <VTable class="text-no-wrap">
                          <thead>
                            <tr>
                              <th class="text-uppercase">
                                Inspection
                              </th>
                              <th class="text-uppercase text-center">
                                Count
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Total Inspected Equipment</td>
                              <td class="text-center">
                                {{ totalInspectedEquipment }}
                              </td>
                            </tr>
                            <tr>
                              <td>Total Inspected Fire Extinguishers</td>
                              <td class="text-center">
                                {{ totalInspectedFireExtinguisher }}
                              </td>
                            </tr>
                            <tr>
                              <td>Total Inspected Fire Hoses</td>
                              <td class="text-center">
                                {{ totalInspectedFireHose }}
                              </td>
                            </tr>
                            <tr>
                              <td>Total Inspected Others Equipment</td>
                              <td class="text-center">
                                {{ totalInspectedOthersEquipment }}
                              </td>
                            </tr>
                          </tbody>
                        </VTable>
                      </VCardText>
                    </VCard>
                  </VCol>

                  <VCol
                    cols="12"
                    md="4"
                    class="pa-0"
                  >
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0"
                      style="height: 100%;"
                    >
                      <ChartCategories
                        v-if="categoriesLabels.length && categoriesSeries.length"
                        :categories-labels="categoriesLabels"
                        :categories-series="categoriesSeries"
                        :style="{ height: '100%' }"
                      />
                    </VCard>
                  </VCol>
                </VRow>

                <VRow class="mt-4">
                  <VCol
                    cols="12"
                    md="8"
                  >
                    <VCard
                      title="Status Summary"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VTable class="text-no-wrap">
                          <thead>
                            <tr>
                              <th class="text-uppercase">
                                Equipment per Status
                              </th>
                              <th class="text-uppercase text-center">
                                Count
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(label, index) in statusLabels"
                              :key="index"
                            >
                              <td class="text-capitalize">
                                {{ label }}
                              </td>
                              <td class="text-center">
                                {{ statusSeries[index] }}
                              </td>
                            </tr>
                          </tbody>
                        </VTable>
                      </VCardText>
                    </VCard>
                  </VCol>
                  
                  <VCol
                    cols="12"
                    md="4"
                  >
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <ChartStatus
                        v-if="statusLabels.length && statusSeries.length"
                        :status-labels="statusLabels"
                        :status-series="statusSeries"
                      />
                    </VCard>
                  </VCol>
                </VRow>
                <VCard 
                  title="1.3 Critical Recommendations"
                  variant="text"
                  color="surface-variant"
                  class="pa-1"
                >
                  <VCardText>
                    <VDataTableServer
                      :items="filteredRecommendations.critical"
                      :headers="props.recommendationsViewHeaders"
                      class="text-no-wrap"
                    >
                      <template #bottom>
                        <VDivider />
                      </template>
                    </VDataTableServer>
                  </VCardText>
                </VCard>
                <VCard
                  title="1.4 Intervention Outcome"
                  variant="text"
                  color="surface-variant"
                  class="pa-1"
                >
                  <VCardText>
                    <VList>
                      <VListItem>
                        <VListItemTitle>Operational Readiness: {{ localMissionData.operational_readiness }}</VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.operational_readiness_desc }}</VListItemSubtitle>
                      </VListItem>
                      <VListItem>
                        <VListItemTitle>Maintenance Quality: {{ localMissionData.maintenance_quality }}</VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.maintenance_quality_desc }}</VListItemSubtitle>
                      </VListItem>
                      <VListItem>
                        <VListItemTitle>Safety Compliance: {{ localMissionData.safety_compliance }}</VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.safety_compliance_desc }}</VListItemSubtitle>
                      </VListItem>
                      <VListItem>
                        <VListItemTitle>Overall Park Status: {{ localMissionData.park_status }}</VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.park_status_desc }}</VListItemSubtitle>
                      </VListItem>
                      <VListItem>
                        <VListItemTitle>Status of Intervention: {{ localMissionData.intervention_status }}</VListItemTitle>
                        <VListItemSubtitle>{{ localMissionData.intervention_status_desc }}</VListItemSubtitle>
                      </VListItem>
                    </VList>
                  </VCardText>
                </VCard>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-1"
              elevation="2"
              class="pa-0"
            >
              <VCardTitle class="text-h4">
                2. Client and Site Details
              </VCardTitle>
              <VCardText>
                <VRow>
                  <VCol cols="12">
                    <VCard
                      title="2.1 Client Information"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VList dense>
                        <VListItem>
                          <VListItemTitle>Client ID: {{ localMissionData.mission_client_id }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Client Name: {{ localMissionData.client_name }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Address: {{ localMissionData.address }} {{ localMissionData.postcode }} {{ localMissionData.city }} {{ localMissionData.country }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Phone: {{ localMissionData.main_phone_number }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Email: {{ localMissionData.client_email }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Website: {{ localMissionData.client_website }}</VListItemTitle>
                        </VListItem>
                      </VList>
                    </VCard>
                  </VCol>
                  
                  <VCol cols="12">
                    <VCard
                      title="2.2 Site Location and Description"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VList dense>
                        <VListItem>
                          <VListItemTitle>Site ID: {{ localMissionData.park_id }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Site Name: {{ localMissionData.park_title }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Address: {{ localMissionData.park_address }} {{ localMissionData.park_postcode }} {{ localMissionData.park_city }} {{ localMissionData.park_country }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Type of Facility: {{ localMissionData.park_type }}</VListItemTitle>
                        </VListItem>
                        <VListItem>
                          <VListItemTitle>Total Area: {{ totalAreas }} Areas</VListItemTitle>
                        </VListItem>
                      </VList>
                    </VCard>
                  </VCol>
                </VRow>

                <VCard
                  title="2.3 Intervention Details"
                  
                  variant="text"
                  color="surface-variant"
                  class="pa-0 mt-0"
                >
                  <VList dense>
                    <VListItem>
                      <VListItemTitle>Date of Service: {{ localMissionData.mission_date }}</VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <VListItemTitle>Duration: {{ localMissionData.mission_duration }} days</VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <VListItemTitle>Team Leader: {{ localMissionData.team_leader }}</VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <VListItemTitle>Technicians:</VListItemTitle>
                      <VListItemSubtitle>
                        <VList dense>
                          <VListItem
                            v-for="teamMember in parsedTeamMembers(localMissionData.team_members)"
                            :key="teamMember"
                          >
                            {{ teamMember }}
                          </VListItem>
                        </VList>
                      </VListItemSubtitle>
                    </VListItem>
                  </VList>
                </VCard>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-1"
              elevation="2"
              class="pa-0"
            >
              <VCardTitle class="text-h4">
                3. Scope of Work
              </VCardTitle>
              <VCardText>
                <VRow>
                  <VCol cols="12">
                    <VCard
                      title="3.1 Purpose of the Intervention"
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <VCardText>
                        <p>The primary objectives of this fire safety equipment service intervention were to:</p>
                        <VDataTableServer
                          v-model:items-per-page="options.itemsPerPage"
                          v-model:page="options.page"
                          :items="services"
                          :headers="props.serviceViewHeaders"
                          :items-length="totalServices"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      title="3.2 Areas Inspected"
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <VCardText>
                        <p>Our comprehensive inspection covered the following areas of {{ localMissionData.park_id }} {{ localMissionData.park_title }}:</p>
                        <VDataTableServer
                          v-model:items-per-page="options.itemsPerPage"
                          v-model:page="options.page"
                          :items="areas"
                          :headers="props.areaViewHeaders"
                          :items-length="totalAreas"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      title="3.3 Equipment Categories Serviced"
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <VCardText>
                        <p>During this intervention, we inspected, tested, and serviced the following categories of fire safety equipment:</p>
                        <VTable class="text-no-wrap">
                          <tbody>
                            <tr
                              v-for="(label, index) in categoriesLabels"
                              :key="index"
                            >
                              <td class="text-uppercase">
                                {{ label }}
                              </td>
                              <td class="text-center">
                                {{ categoriesSeries[index] }}
                              </td>
                            </tr>
                          </tbody>
                        </VTable>
                        <p>Each equipment category was thoroughly examined for proper installation, functionality, and compliance with current safety standards.</p>
                      </VCardText>
                    </VCard>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-1"
              elevation="2"
              class="pa-0"
            >
              <VCardTitle class="text-h4">
                4. Findings and Actions
              </VCardTitle>
              <VCardText>
                <VRow>
                  <VCol cols="12">
                    <VCard
                      title="4.1 Equipment Status"
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.1.1 Fire Extinguishers</p>
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Fire Extinguisher by Model
                              </VChip>
                            </th>
                          </tr>
                        </thead>

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
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Inspection per Fire Extinguisher
                              </VChip>                              
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in inspectedFireExtinguisherModelWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              Fire Extinguisher {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ inspectedFireExtinguisherModelWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol 
                    cols="12"
                    md="6"
                  >
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Fire Extinguishers Recharged
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td class="text-uppercase">
                              Fire Extinguishers Recharged (Raw Material)
                            </td>
                            <td class="text-center">
                              {{ rechargeRaw }}
                            </td>
                          </tr>
                          <tr>
                            <td class="text-uppercase">
                              Fire Extinguishers Recharged (Nitrogen)
                            </td>
                            <td class="text-center">
                              {{ nitrogenRecharge }}
                            </td>
                          </tr>
                          <tr>
                            <td class="text-uppercase">
                              Fire Extinguishers Recharged (Sparklet) 
                            </td>
                            <td class="text-center">
                              {{ rechargedSparklet }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol 
                    cols="12"
                    md="6"
                  >
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Total Raw Material
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in totalRawMaterialForFireExtinguishersLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }} 
                            </td>
                            <td class="text-center">
                              {{ totalRawMaterialForFireExtinguishersSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol 
                    md="6"
                    cols="12"
                  >
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Nitrogen per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in rechargeNitrogenModelWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ rechargeNitrogenModelWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol 
                    md="6"
                    cols="12"
                  >
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Raw Recharged per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in rechargeRawModelWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ rechargeRawModelWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                protections per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in protectionFireExtinguisherWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ protectionFireExtinguisherWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                accessories per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in accessoryFireExtinguisherWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ accessoryFireExtinguisherWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Supplies per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in supplyFireExtinguisherWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ supplyFireExtinguisherWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Maintenance Services per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in maintenanceFireExtinguisherWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ maintenanceFireExtinguisherWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Additional Maintenance Services per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in additionalMaintenanceFireExtinguisherWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ additionalMaintenanceFireExtinguisherWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      v-if="hasStatusFireExtinguisher"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Status per Fire Extinguisher
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in statusFireExtinguisherModelWeightLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ statusFireExtinguisherModelWeightSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.1.2 Fire Hoses</p>
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Inspection per Fire Hose
                              </VChip>
                            </th>
                          </tr>
                        </thead>

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
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                protections per Fire Hose
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in protectionFireHoseModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ protectionFireHoseModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                accessories per Fire Hose
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in accessoryFireHoseModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ accessoryFireHoseModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Supplies per Fire Hose
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in supplyFireHoseModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ supplyFireHoseModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Maintenance Services per Fire Hose
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in maintenanceFireHoseModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ maintenanceFireHoseModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>

                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Additional Maintenance Services per Fire Hose
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in additionalMaintenanceFireHoseModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ additionalMaintenanceFireHoseModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Status per Fire Hose
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in statusFireHoseModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ statusFireHoseModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      v-if="hasInspectedOthersEquipment"
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.1.3 Others Equipment</p>
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Inspection per Others Equipment
                              </VChip>
                            </th>
                          </tr>
                        </thead>

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
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      v-if="hasProtectionOthersEquipment"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                protections per Others Equipment
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in protectionOthersEquipmentModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ protectionOthersEquipmentModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      v-if="hasAccessoryOthersEquipment"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                accessories per other Equipment
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in accessoryOthersEquipmentModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ accessoryOthersEquipmentModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      v-if="hasSupplyOthersEquipment"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Supplies per others equipment
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in supplyOthersEquipmentModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ supplyOthersEquipmentModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      v-if="hasMaintenanceOthersEquipment"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Maintenance Services per others equipment
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in maintenanceOthersEquipmentModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ maintenanceOthersEquipmentModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>

                  <VCol cols="12">
                    <VCard
                      v-if="hasAdditionalMaintenanceOthersEquipment"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Additional Maintenance Services per others equipment
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in additionalMaintenanceOthersEquipmentModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ additionalMaintenanceOthersEquipmentModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  
                  <VCol cols="12">
                    <VCard
                      v-if="hasStatusOthersEquipment"
                      variant="text"
                      color="surface-variant"
                      class="pa-0 mt-0"
                    >
                      <VTable class="text-no-wrap">
                        <thead>
                          <tr>
                            <th class="text-uppercase">
                              <VChip
                                color="primary"
                                variant="text"
                              >
                                <VIcon
                                  start
                                  icon="tabler-files"
                                /> 
                                Status per others equipment
                              </VChip>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr
                            v-for="(label, index) in statusOthersEquipmentModelLabels"
                            :key="index"
                          >
                            <td class="text-uppercase">
                              {{ label }}
                            </td>
                            <td class="text-center ">
                              {{ statusOthersEquipmentModelSeries[index] }}
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.1.4 Out Of Service Equipment</p>

                      <VDataTableServer
                        v-model:items-per-page="options.itemsPerPage"
                        v-model:page="options.page"
                        :items="outs"
                        :headers="props.outsViewHeaders"
                        :items-length="totalOuts"
                        class="text-no-wrap"
                      >
                        <template #bottom>
                          <VDivider />
                        </template>
                      </VDataTableServer>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      title="4.2 Compliance Check"
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.2.1 Adherence to Safety Standards and Regulations</p>
                      <p>Overall Safety Compliance Rate: {{ localMissionData.compliance_rate }} %</p>
                      <p>Standards Referenced:</p>
                      <VDataTableServer
                        v-model:items-per-page="options.itemsPerPage"
                        v-model:page="options.page"
                        :items="standards"
                        :headers="props.standardViewHeaders"
                        :items-length="totalStandards"
                        class="text-no-wrap"
                      >
                        <template #bottom>
                          <VDivider />
                        </template>
                      </VDataTableServer>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.2.2 Identification of Compliant Areas</p>
                      <VDataTableServer
                        v-model:items-per-page="options.itemsPerPage"
                        v-model:page="options.page"
                        :items="compliantAreas"
                        :headers="compliancesViewHeaders"
                        :items-length="totalCompliantAreas"
                        class="text-no-wrap"
                      >
                        <template #bottom>
                          <VDivider />
                        </template>
                      </VDataTableServer>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.2.3 Identification of Non-Compliant Areas</p>
                      <VDataTableServer
                        v-model:items-per-page="options.itemsPerPage"
                        v-model:page="options.page"
                        :items="nonCompliantAreas"
                        :headers="compliancesViewHeaders"
                        :items-length="totalNonCompliantAreas"
                        class="text-no-wrap"
                      >
                        <template #bottom>
                          <VDivider />
                        </template>
                      </VDataTableServer>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard
                      title="4.3 Risk Assessment"
                      variant="text"
                      color="surface-variant"
                      class="pa-1 mt-0"
                    >
                      <p>4.3.1 Potential Hazards Identified</p>
                      <VDataTableServer
                        v-model:items-per-page="options.itemsPerPage"
                        v-model:page="options.page"
                        :items="hazards"
                        :headers="hazardsViewHeaders"
                        :items-length="totalHazards"
                        class="text-no-wrap"
                      >
                        <template #bottom>
                          <VDivider />
                        </template>
                      </VDataTableServer>
                      <p>4.3.2 Risk Level Classification</p>
                      <VDataTableServer
                        v-model:items-per-page="options.itemsPerPage"
                        v-model:page="options.page"
                        :items="hazards"
                        :headers="riskLevelViewHeaders"
                        :items-length="totalHazards"
                        class="text-no-wrap"
                      >
                        <template #bottom>
                          <VDivider />
                        </template>
                      </VDataTableServer>
                    </VCard>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-4"
              elevation="2"
              class="pa-0"
            >
              <VCardTitle class="text-h4">
                5. Recommendations
              </VCardTitle>
              <VCardText>
                <VRow class="mt-4">
                  <VCol cols="12">
                    <VCard 
                      title="5.1 Immediate Actions Required"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredRecommendations.immediate"
                          :headers="props.recommendationsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard 
                      title="5.2 Short-term Improvements (1-3 months)"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredRecommendations.short_term"
                          :headers="props.recommendationsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard 
                      title="5.3 Long-term Strategic Recommendations (3-12 months)"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredRecommendations.long_term"
                          :headers="props.recommendationsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-5"
              elevation="2"
              class="pa-0"
            >
              <VCardTitle class="text-h4">
                6. Follow-up Plan
              </VCardTitle>
              <VCardText>
                <VRow class="mt-4">
                  <VCol cols="12">
                    <h5 class="text-h6">
                      6.1 Proposed Next Inspection Date
                    </h5>
                    <p>
                      We recommend scheduling the next comprehensive fire safety inspection for {{ localMissionData.mission_frequency }} , from the date of this service.
                    </p>
                  </VCol>
                  <VCol cols="12">
                    <h5 class="text-h6">
                      6.2 Ongoing Maintenance Suggestions for Fire Fighting Equipment
                    </h5>
                    <VCard 
                      title="Monthly Tasks"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredSuggestions.monthly"
                          :headers="props.suggestionsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard 
                      title="Quarterly Tasks"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredSuggestions.quarterly"
                          :headers="props.suggestionsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard 
                      title="Semi-Annual Tasks"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredSuggestions.semi_annual"
                          :headers="props.suggestionsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard 
                      title="Annual Tasks"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredSuggestions.annual"
                          :headers="props.suggestionsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <VCard 
                      title="As Needed"
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VDataTableServer
                          :items="filteredSuggestions.as_needed"
                          :headers="props.suggestionsViewHeaders"
                          class="text-no-wrap"
                        >
                          <template #bottom>
                            <VDivider />
                          </template>
                        </VDataTableServer>
                      </VCardText>
                    </VCard>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            cols="12"
            class="pa-1"
          >
            <VCard
              id="section-6"
              elevation="2"
              class="pa-0"
            >
              <VCardTitle class="text-h4">
                7. Client Acknowledgment
              </VCardTitle>
              <VCardText>
                <VRow class="mt-4">
                  <VCol cols="12">
                    <h5 class="text-h6">
                      7.1 Client's Satisfaction
                    </h5>
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VList>
                          <VListItem>
                            <VListItemTitle>7.1.1. Overall Quality of Service</VListItemTitle>
                            <VListItemSubtitle>Client's Rating: {{ interventionData.client_feedback_quality_service }}</VListItemSubtitle>
                          </VListItem>
                          <VListItem>
                            <VListItemTitle>7.1.2. Punctuality of Team</VListItemTitle>
                            <VListItemSubtitle>Client's Response: {{ interventionData.client_feedback_arrive_time }}</VListItemSubtitle>
                          </VListItem>
                          <VListItem>
                            <VListItemTitle>7.1.3. Professionalism of Our Team</VListItemTitle>
                            <VListItemSubtitle>Client's Satisfaction Level: {{ interventionData.client_feedback_professionalism }}</VListItemSubtitle>
                          </VListItem>
                          <VListItem>
                            <VListItemTitle>7.1.4. Addressing Specific Needs and Concerns</VListItemTitle>
                            <VListItemSubtitle>Client's Assessment: {{ interventionData.client_feedback_specific_needs }}</VListItemSubtitle>
                          </VListItem>
                          <VListItem>
                            <VListItemTitle>7.1.5. Likelihood of Recommending Our Services</VListItemTitle>
                            <VListItemSubtitle>Client's Likelihood: {{ interventionData.client_feedback_recommend_our_services }}</VListItemSubtitle>
                          </VListItem>
                        </VList>
                      </VCardText>
                    </VCard>
                  </VCol>
                  <VCol cols="12">
                    <h5 class="text-h6">
                      7.2 Additional Comments or Feedback
                    </h5>
                    <VCard
                      variant="text"
                      color="surface-variant"
                      class="pa-1"
                    >
                      <VCardText>
                        <VList>
                          <VListItem>
                            <VListItemTitle>Additional Comments or Feedback</VListItemTitle>
                            <VListItemText>{{ interventionData.client_feedback }}</VListItemText>
                          </VListItem>
                        </VList>
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
