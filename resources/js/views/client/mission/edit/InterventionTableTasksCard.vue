<script setup>
import { useMissionListStore } from '../useMissionListStore'

const props = defineProps({
  missionData: {
    type: Array,
    required: true,
  },
})


//SECTION Declaration

const operationalReadinessItems = [
  {
    desc: 'All systems and personnel ready for immediate deployment.',
    name: 'Fully Operational',
  },
  {
    desc: 'Minor issues present, but core functionality maintained.',
    name: 'Conditionally Operational',
  },
  {
    desc: 'Significant constraints affecting readiness.',
    name: 'Limited Operational Capacity',
  },
  {
    desc: 'Critical issues preventing effective response.',
    name: 'Non-Operational',
  },
  {
    desc: 'Systems inactive but can be activated if needed.',
    name: 'Standby Mode',
  },
  {
    desc: null,
    name: null,
  },
]

const maintenanceQualityItems = [
  {
    desc: 'Exceeds industry standards; proactive maintenance evident.',
    name: 'Optimal',
  },
  {
    desc: 'Meets all required standards with no significant issues.',
    name: 'Satisfactory',
  },
  {
    desc: 'Minor deficiencies noted; corrective action recommended.',
    name: 'Requires Attention',
  },
  {
    desc: 'Multiple issues identified; immediate action required.',
    name: 'Substandard',
  },
  {
    desc: 'Severe maintenance lapses posing imminent safety risks.',
    name: 'Critical',
  },
  {
    desc: null,
    name: null,
  },
]

const safetyComplianceItems = [
  {
    desc: 'Meets or exceeds all applicable safety regulations.',
    name: 'Full Compliance',
    rate: 100,
  },
  {
    desc: 'Minor issues present, but core functionality maintained.',
    name: 'Substantial Compliance',
    rate: 75,
  },
  {
    desc: 'Significant gaps in regulatory adherence identified.',
    name: 'Partial Compliance',
    rate: 50,
  },
  {
    desc: 'Compliance status being reassessed due to recent changes.',
    name: 'Under Review',
    rate: 25,
  },
  {
    desc: 'Major violations of safety regulations observed.',
    name: 'Non-Compliant',
    rate: 0,
  },
  {
    desc: null,
    name: null,
    rate: null,
  },
]

const parkStatusItems = [
  {
    desc: 'All areas functioning normally with no restrictions.',
    name: 'Fully Operational',
  },
  {
    desc: 'Some areas restricted or operating at reduced capacity.',
    name: 'Limited Operations',
  },
  {
    desc: 'Significant portions of the facility closed or inaccessible.',
    name: 'Partial Closure',
  },
  {
    desc: 'Entire facility closed for a defined period.',
    name: 'Temporary Shutdown',
  },
  {
    desc: 'Gradual resumption of operations in progress.',
    name: 'Phased Reopening',
  },
  {
    desc: null,
    name: null,
  },
]

const interventionStatusItems = [
  {
    desc: 'All planned tasks were successfully executed without any issues.',
    name: 'Fully Completed',
  },
  {
    desc: 'Most tasks were completed successfully, with some minor problems addressed on-site.',
    name: 'Completed with Minor Issues',
  },
  {
    desc: 'Some critical tasks were completed, but others require follow-up.',
    name: 'Partially Completed',
  },
  {
    desc: 'The intervention was started but had to be stopped due to unforeseen circumstances.',
    name: 'Interrupted',
  },
  {
    desc: 'The intervention could not be carried out as planned and has been postponed.',
    name: 'Rescheduled',
  },
  {
    desc: null,
    name: null,
  },
]

const panel = ref(0)

const route = useRoute()
const missionListStore = useMissionListStore()
const interventionId = ref('')
const interventionData = ref([])

const categoryChart = ref({})
const categoriesLabels = ref({})
const categoriesSeries = ref({})

const fireExtinguisherModelChart = ref({})
const fireExtinguisherModelLabels = ref({})
const fireExtinguisherModelSeries = ref({})

const statusChart = ref({})
const statusLabels = ref({})
const statusSeries = ref({})

const totalInspectedEquipment = ref()
const totalInspectedFireExtinguisher = ref()
const totalInspectedFireHose = ref()
const totalInspectedOthersEquipment = ref()

const nitrogenRecharge = ref()
const rechargedSparklet = ref()
const rechargeRaw = ref()
const rechargeRawModelWeight = ref({})
const rechargeRawModelWeightLabels = ref({})
const rechargeRawModelWeightSeries = ref({})
const rechargeNitrogenModelWeight = ref({})
const rechargeNitrogenModelWeightLabels = ref({})
const rechargeNitrogenModelWeightSeries = ref({})
const inspectedFireExtinguisherModelWeight = ref({})
const inspectedFireExtinguisherModelWeightLabels = ref({})
const inspectedFireExtinguisherModelWeightSeries = ref({})

const accessory = ref({})
const accessoryLabels = ref({})
const accessorySeries = ref({})

const supply = ref({})
const supplyLabels = ref({})
const supplySeries = ref({})

const maintenance = ref({})
const maintenanceLabels = ref({})
const maintenanceSeries = ref({})

const additionalMaintenance = ref({})
const additionalMaintenanceLabels = ref({})
const additionalMaintenanceSeries = ref({})

const totalProtectionEquipment = ref({})
const totalProtectionEquipmentLabels = ref({})
const totalProtectionEquipmentSeries = ref({})

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

const totalRawMaterialForFireExtinguishers = ref({})
const totalRawMaterialForFireExtinguishersLabels = ref({})
const totalRawMaterialForFireExtinguishersSeries = ref({})

const statusFireExtinguisherModelWeight = ref({})
const statusFireExtinguisherModelWeightLabels = ref({})
const statusFireExtinguisherModelWeightSeries = ref({})

const outOfOrderQrcFireExtinguisherModelWeight = ref({})
const outOfOrderQrcFireExtinguisherModelWeightLabels = ref({})
const outOfOrderQrcFireExtinguisherModelWeightSeries = ref({})

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

const outOfOrderQrcFireHoseModel = ref({})
const outOfOrderQrcFireHoseModelLabels = ref({})
const outOfOrderQrcFireHoseModelSeries = ref({})

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

const outOfOrderQrcOthersEquipmentModel = ref({})
const outOfOrderQrcOthersEquipmentModelLabels = ref({})
const outOfOrderQrcOthersEquipmentModelSeries = ref({})

const isSnackbarVisible = ref(false)

const localMissionData = ref({
  ...props.missionData,
  operational_readiness: {
    name: props.missionData.operational_readiness,
    desc: props.missionData.operational_readiness_desc,
  },
  maintenance_quality: {
    name: props.missionData.maintenance_quality,
    desc: props.missionData.maintenance_quality_desc,
  },
  safety_compliance: {
    name: props.missionData.safety_compliance,
    desc: props.missionData.safety_compliance_desc,
    rate: props.missionData.compliance_rate,
  },
  park_status: {
    name: props.missionData.park_status,
    desc: props.missionData.park_status_desc,
  },
  intervention_status: {
    name: props.missionData.intervention_status,
    desc: props.missionData.intervention_status_desc,
  },
})

// Update Mission
const updateMission = async missionData => {
  try {
    const formattedData = {
      ...missionData,
      operational_readiness: missionData.operational_readiness.name,
      operational_readiness_desc: missionData.operational_readiness.desc,
      maintenance_quality: missionData.maintenance_quality.name,
      maintenance_quality_desc: missionData.maintenance_quality.desc,
      safety_compliance: missionData.safety_compliance.name,
      safety_compliance_desc: missionData.safety_compliance.desc,
      compliance_rate: missionData.safety_compliance.rate,
      park_status: missionData.park_status.name,
      park_status_desc: missionData.park_status.desc,
      intervention_status: missionData.intervention_status.name,
      intervention_status_desc: missionData.intervention_status.desc,
    }
    
    const response = await missionListStore.updateMission(Number(route.params.id), formattedData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update mission: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const onFormSubmit = () => {
  updateMission(localMissionData.value)
}

onMounted(() => {
  fetchIntervention()
})

const fetchIntervention = async () => {
  try {
    const response=await missionListStore
      .fetchIntervention(Number(route.params.id))

    interventionData.value=response.data.data
    interventionId.value=interventionData.value.id
    fetchInspectedEquipments()
  } catch(error) {
    console.error(error)
  }
}

// 👉 Fetching equipments
const fetchInspectedEquipments = () => {
  missionListStore.fetchMetaInspectedEquipments({
    id: interventionId.value,
  }).then(response => {
    categoryChart.value = response.data.meta.total_equipment_by_category
    categoriesLabels.value = Object.keys(categoryChart.value)
    categoriesSeries.value = Object.values(categoryChart.value)

    fireExtinguisherModelChart.value = response.data.meta.total_fire_extinguishers_by_model
    fireExtinguisherModelLabels.value = Object.keys(fireExtinguisherModelChart.value)
    fireExtinguisherModelSeries.value = Object.values(fireExtinguisherModelChart.value)
    
    statusChart.value = response.data.meta.equipment_by_status
    statusLabels.value = Object.keys(statusChart.value)
    statusSeries.value = Object.values(statusChart.value)
    
    totalInspectedEquipment.value = response.data.meta.inspected_equipment
    totalInspectedFireExtinguisher.value = response.data.meta.inspected_fire_extinguisher
    totalInspectedFireHose.value = response.data.meta.inspected_fire_hose
    totalInspectedOthersEquipment.value = response.data.meta.inspected_others_equipment
    nitrogenRecharge.value = response.data.meta.nitrogen_recharged_fire_extinguisher_count
    rechargedSparklet.value = response.data.meta.recharged_sparklet_count
    rechargeRaw.value = response.data.meta.raw_recharged_fire_extinguisher_count
    
    rechargeRawModelWeight.value = response.data.meta.raw_recharged_fire_extinguisher_by_model_weight
    rechargeRawModelWeightLabels.value = Object.keys(rechargeRawModelWeight.value)
    rechargeRawModelWeightSeries.value = Object.values(rechargeRawModelWeight.value)

    rechargeNitrogenModelWeight.value = response.data.meta.nitrogen_recharged_fire_extinguisher_by_model_weight
    rechargeNitrogenModelWeightLabels.value = Object.keys(rechargeNitrogenModelWeight.value)
    rechargeNitrogenModelWeightSeries.value = Object.values(rechargeNitrogenModelWeight.value)
    
    inspectedFireExtinguisherModelWeight.value = response.data.meta.inspected_fire_extinguisher_by_model_weight
    inspectedFireExtinguisherModelWeightLabels.value = Object.keys(inspectedFireExtinguisherModelWeight.value)
    inspectedFireExtinguisherModelWeightSeries.value = Object.values(inspectedFireExtinguisherModelWeight.value)

    inspectedFireHoseModel.value = response.data.meta.inspected_fire_hose_by_model
    inspectedFireHoseModelLabels.value = Object.keys(inspectedFireHoseModel.value)
    inspectedFireHoseModelSeries.value = Object.values(inspectedFireHoseModel.value)

    inspectedOthersEquipmentModel.value = response.data.meta.inspected_others_equipment_by_model
    inspectedOthersEquipmentModelLabels.value = Object.keys(inspectedOthersEquipmentModel.value)
    inspectedOthersEquipmentModelSeries.value = Object.values(inspectedOthersEquipmentModel.value)

    statusFireExtinguisherModelWeight.value = response.data.meta.fire_extinguisher_by_status
    statusFireExtinguisherModelWeightLabels.value = Object.keys(statusFireExtinguisherModelWeight.value)
    statusFireExtinguisherModelWeightSeries.value = Object.values(statusFireExtinguisherModelWeight.value)

    statusFireHoseModel.value = response.data.meta.fire_hose_by_status
    statusFireHoseModelLabels.value = Object.keys(statusFireHoseModel.value)
    statusFireHoseModelSeries.value = Object.values(statusFireHoseModel.value)

    statusOthersEquipmentModel.value = response.data.meta.others_equipment_by_status
    statusOthersEquipmentModelLabels.value = Object.keys(statusOthersEquipmentModel.value)
    statusOthersEquipmentModelSeries.value = Object.values(statusOthersEquipmentModel.value)

    outOfOrderQrcFireExtinguisherModelWeight.value = response.data.meta.out_of_order_fire_extinguisher_by_qrc_model_weight
    outOfOrderQrcFireExtinguisherModelWeightLabels.value = Object.keys(outOfOrderQrcFireExtinguisherModelWeight.value)
    outOfOrderQrcFireExtinguisherModelWeightSeries.value = Object.values(outOfOrderQrcFireExtinguisherModelWeight.value)
    
    outOfOrderQrcFireHoseModel.value = response.data.meta.out_of_order_fire_hose_by_qrc_model
    outOfOrderQrcFireHoseModelLabels.value = Object.keys(outOfOrderQrcFireHoseModel.value)
    outOfOrderQrcFireHoseModelSeries.value = Object.values(outOfOrderQrcFireHoseModel.value)
    
    outOfOrderQrcOthersEquipmentModel.value = response.data.meta.out_of_order_others_equipment_by_qrc_model
    outOfOrderQrcOthersEquipmentModelLabels.value = Object.keys(outOfOrderQrcOthersEquipmentModel.value)
    outOfOrderQrcOthersEquipmentModelSeries.value = Object.values(outOfOrderQrcOthersEquipmentModel.value)
    
    totalProtectionEquipment.value = response.data.meta.protection_by_equipment
    totalProtectionEquipmentLabels.value = Object.keys(totalProtectionEquipment.value)
    totalProtectionEquipmentSeries.value = Object.values(totalProtectionEquipment.value)

    accessory.value = response.data.meta.accessory_counts
    accessoryLabels.value = Object.keys(accessory.value)
    accessorySeries.value = Object.values(accessory.value)

    supply.value = response.data.meta.supply_counts
    supplyLabels.value = Object.keys(supply.value)
    supplySeries.value = Object.values(supply.value)

    maintenance.value = response.data.meta.maintenance_counts
    maintenanceLabels.value = Object.keys(maintenance.value)
    maintenanceSeries.value = Object.values(maintenance.value)

    additionalMaintenance.value = response.data.meta.additional_maintenance_counts
    additionalMaintenanceLabels.value = Object.keys(additionalMaintenance.value)
    additionalMaintenanceSeries.value = Object.values(additionalMaintenance.value)

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

    totalRawMaterialForFireExtinguishers.value = response.data.meta.total_raw_material_for_fire_extinguishers
    totalRawMaterialForFireExtinguishersLabels.value = Object.keys(totalRawMaterialForFireExtinguishers.value)
    totalRawMaterialForFireExtinguishersSeries.value = Object.values(totalRawMaterialForFireExtinguishers.value)

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
  }).catch(error => {
    console.error(error)
  })
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

const hasOutOfOrderQrcOthersEquipment = computed(() => {
  return Object.keys(outOfOrderQrcOthersEquipmentModel.value).length > 0
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
  <section>
    <VSnackbar 
      v-model="isSnackbarVisible"
      transition="scroll-y-reverse-transition"
    >
      Mission Data Updated Successfully
    </VSnackbar>
    <VExpansionPanels
      v-model="panel"
      multiple
      class="no-icon-rotate"
    >
      <VExpansionPanel>
        <VForm
          class="mt-1"
          @submit.prevent="onFormSubmit"
        >
          <VExpansionPanelTitle
            class="text-uppercase"
            disable-icon-rotate
          >
            Intervention Outcome
            <template #actions>
              <VIcon
                size="35"
                icon="tabler-abacus"
                color="primary"
              />
            </template>
          </VExpansionPanelTitle>
          <VExpansionPanelText>
            <VRow class="match-height">
              <VCol
                md="6"
                cols="12"
              >
                <VCard>
                  <VCol cols="12">
                    <h5 class="text-h5 mb-0">
                      Operational Readiness
                    </h5>
                    <h6 class="text-h6 mb-0">
                      Assesses the overall preparedness of fire fighting systems and personnel.
                    </h6>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="localMissionData.operational_readiness"
                      :hint="localMissionData.operational_readiness.desc"
                      :items="operationalReadinessItems"
                      item-title="name"
                      item-value="name"
                      label="Select Operational Readiness Status"
                      persistent-hint
                      return-object
                      single-line
                      placeholder="Select Status"
                    />
                  </VCol>
                </VCard>
              </VCol>
              <VCol
                md="6"
                cols="12"
              >
                <VCard>
                  <VCol cols="12">
                    <h5 class="text-h5 mb-0">
                      Maintenance Quality
                    </h5>
                    <h6 class="text-h6 mb-0">
                      Evaluates the standard of upkeep and repairs on fire safety equipment.
                    </h6>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="localMissionData.maintenance_quality"
                      :hint="localMissionData.maintenance_quality.desc"
                      :items="maintenanceQualityItems"
                      item-title="name"
                      item-value="name"
                      label="Select maintenance Quality Status"
                      persistent-hint
                      return-object
                      single-line
                      clearable
                      clear-icon="tabler-x"
                      placeholder="Select Status"
                    />
                  </VCol>
                </VCard>
              </VCol>
              <VCol
                md="6"
                cols="12"
              >
                <VCard>
                  <VCol cols="12">
                    <h5 class="text-h5 mb-0">
                      Safety Compliance
                    </h5>
                    <h6 class="text-h6 mb-0">
                      Indicates adherence to relevant fire safety regulations and standards.
                    </h6>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="localMissionData.safety_compliance"
                      :hint="localMissionData.safety_compliance.desc"
                      :items="safetyComplianceItems"
                      item-title="name"
                      item-value="name"
                      label="Select Safety Compliance Status"
                      persistent-hint
                      return-object
                      single-line
                      placeholder="Select Status"
                    />
                  </VCol>
                </VCard>
              </VCol>
              <VCol
                md="6"
                cols="12"
              >
                <VCard>
                  <VCol cols="12">
                    <h5 class="text-h5 mb-0">
                      Park Status
                    </h5>
                    <h6 class="text-h6 mb-0">
                      Reflects the current operational desc of the client's facility or site.
                    </h6>
                  </VCol>
                  <VCol cols="12"> 
                    <AppSelect
                      v-model="localMissionData.park_status"
                      :hint="localMissionData.park_status.desc"
                      :items="parkStatusItems"
                      item-title="name"
                      item-value="name"
                      label="Select park Status"
                      persistent-hint
                      return-object
                      single-line
                      placeholder="Select Status"
                    />
                  </VCol>
                </VCard>
              </VCol>
              <VCol cols="12">
                <VCard>
                  <VCol cols="12">
                    <h5 class="text-h5 mb-0">
                      Status of Intervention
                    </h5>
                    <h6 class="text-h6 mb-0">
                      Indicates the progress and outcome of the fire safety inspection and maintenance mission.
                    </h6>
                  </VCol>
                  <VCol cols="12"> 
                    <AppSelect
                      v-model="localMissionData.intervention_status"
                      :hint="localMissionData.intervention_status.desc"
                      :items="interventionStatusItems"
                      item-title="name"
                      item-value="name"
                      label="Select Intervention Status"
                      persistent-hint
                      return-object
                      single-line
                      placeholder="Select Status"
                    />
                  </VCol>
                </VCard>
              </VCol>
              <VCol cols="12">
                <VBtn 
                  block 
                  type="submit"
                >
                  Submit
                  <VIcon
                    icon="tabler-checklist"
                    end
                    class="flip-in-rtl"
                  />
                </VBtn>
              </VCol>
            </VRow>  
          </VExpansionPanelText>
        </VForm>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Inventory (Recap)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-building-warehouse"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              cols="12"
              md="4"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Category
                        </VChip>
                      </th>
                    </tr>
                  </thead>

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
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="4"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Extinguisher
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
            <VCol
              cols="12"
              md="4"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Equipment per Status
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in statusLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ statusSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow>
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Recap)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-tool"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              cols="12"
              lg="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Inspection
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Equipment
                      </td>
                      <td class="text-center">
                        {{ totalInspectedEquipment }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Fire Extinguishers
                      </td>
                      <td class="text-center">
                        {{ totalInspectedFireExtinguisher }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Fire Hoses
                      </td>
                      <td class="text-center">
                        {{ totalInspectedFireHose }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Others Equipment
                      </td>
                      <td class="text-center">
                        {{ totalInspectedOthersEquipment }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              lg="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
              v-if="hasTotalRawMaterialFireExtinguisher"
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Total PROTECTION EQUIPMENT
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in totalProtectionEquipmentLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }} 
                      </td>
                      <td class="text-center">
                        {{ totalProtectionEquipmentSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              lg="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Accessories
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in accessoryLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ accessorySeries[index] }}
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
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Supplies
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in supplyLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ supplySeries[index] }}
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
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Maintenance Services
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in maintenanceLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ maintenanceSeries[index] }}
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
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Additional Maintenance Services
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in additionalMaintenanceLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ additionalMaintenanceSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow> 
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Fire Extinguisher)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-fire-extinguisher"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol 
              v-if="hasInspectedFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
              v-if="hasRechargeRawFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol 
              v-if="hasRechargeNitrogenFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
              v-if="hasProtectionFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol
              v-if="hasAccessoryFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol
              v-if="hasSupplyFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol
              v-if="hasMaintenanceFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol
              v-if="hasAdditionalMaintenanceFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol
              v-if="hasStatusFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Extinguisher Per Status
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
            <VCol 
              v-if="hasOutOfOrderQrcFireExtinguisher"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Extinguisher Status (Out Of Order)
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in outOfOrderQrcFireExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow> 
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Fire Hose)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-firetruck"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol 
              v-if="hasInspectedFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol 
              v-if="hasProtectionFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol
              v-if="hasAccessoryFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol 
              v-if="hasSupplyFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol 
              v-if="hasMaintenanceFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol
            
              v-if="hasAdditionalMaintenanceFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol 
              v-if="hasStatusFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Hose Per Status
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
            <VCol 
              v-if="hasOutOfOrderQrcFireHose"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Hose Status (Out Of Order)
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in outOfOrderQrcFireHoseModelLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow> 
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Others Equipment)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-tools"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              v-if="hasInspectedOthersEquipment"
              cols="12"
            >  
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol 
              v-if="hasProtectionOthersEquipment"
              cols="12"
            >  
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
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
            <VCol 
              v-if="hasAccessoryOthersEquipment"
              cols="12"
            > 
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          accessories per Others Equipment
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
            <VCol
              v-if="hasSupplyOthersEquipment"

              cols="12"
            >  
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Supplies per Others Equipment
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
            <VCol
              v-if="hasMaintenanceOthersEquipment"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Maintenance Services per Others Equipment
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
            <VCol 
              v-if="hasAdditionalMaintenanceOthersEquipment"
            
              cols="12"
            >  
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Additional Maintenance Services per Others Equipment
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
            <VCol 
              v-if="hasStatusOthersEquipment"
            
              cols="12"
            >    
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Others Equipment Per Status
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
            <VCol
              v-if="hasOutOfOrderQrcOthersEquipment"
              cols="12"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Others Equipment Status (Out Of Order)
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in outOfOrderQrcOthersEquipmentModelLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow> 
        </VExpansionPanelText>
      </VExpansionPanel>
    </VExpansionPanels>
  </section>
</template>
