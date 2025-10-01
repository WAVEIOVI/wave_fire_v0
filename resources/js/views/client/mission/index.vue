<script setup>
import { useUserClientDashboardStore } from '@/stores/useUserClientDashboardStore'
import { avatarText } from '@core/utils/formatters'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import MissionAttestationDialog from './dialog/ViewMissionAttestationDialog.vue'
import MissionReportDialog from './dialog/ViewMissionReportDialog.vue'
import MissionSpecificsDialog from './dialog/ViewMissionSpecificsDialog.vue'


const props = defineProps({
  clientData: {
    type: Object,
    required: true,
  },
  parks: {
    type: Number,  // Assuming parks is a number based on previous context
    required: true,
  },
  equipments: {
    type: Number,  // Assuming equipments is a number based on previous context
    required: true,
  },
  missionHeaders: {
    type: Array,
    required: true,
  },
})

const isViewMissionReportDialogVisible = ref(false)
const isViewMissionAttestationDialogVisible = ref(false)
const isViewMissionSpecificsDialogVisible = ref(false)

const clientData = ref((props.clientData))
const clientDashboardStore = useUserClientDashboardStore()
const missionData = ref([])

// 👉 Fetch Equipment on mount
onMounted(() => {
  fetchMissions(clientData.value.client_name)
})

const fetchMissions = clientName => {
  if (!clientName) return // Check if clientName has a value
  clientDashboardStore.fetchMissions({
    client: clientName,
    options: options.value,
  }).then(response => {
    missions.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalMissions.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
    console.log(missions.value)
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Fetch Mission
const fetchMission = async missionId => {
  try {
    const response = await clientDashboardStore.fetchMission(missionId)

    missionData.value = response.data.data
  } catch (error) {
    console.error('Error fetching mission:', error)
  }
}

// 👉 Watch for clientData changes
watch(
  () => props.clientData,
  newValue => {
    clientData.value = newValue
    fetchMissions(newValue.client_name)
    console.log('clientData in child:', clientData.value)
  },
  { deep: true },
)

//SECTION UI
const resolveMissionTypeVariant = type => {
  const typeLowerCase = type.toLowerCase()
  if (typeLowerCase === 'intervention')
    return {
      color: 'primary',
      icon: 'tabler-progress-check',
    }
  if (typeLowerCase === 'workshop')
    return {
      color: 'success',
      icon: 'tabler-building-warehouse',
    }
  
  return {
    color: 'secondary',
    icon: 'tabler-home-question',
  }
}

const resolveMissionStatusVariant = stat => {
  if (stat === 'pending')
    return 'warning'
  if (stat === 'in progress')
    return 'success'
  if (stat === 'completed')
    return 'info'
  if (stat === 'closure')
    return 'error'
  
  return 'primary'
}

const totalPage = ref(1)
const totalMissions = ref(0)
const missions = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
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

const recommendationsViewHeaders = [
  {
    title: 'recommendation',
    key: 'name',
  },
]

const suggestionsViewHeaders = [
  {
    title: 'suggestion',
    key: 'name',
  },
]

const serviceViewHeaders = [
  {
    title: 'service id',
    key: 'service_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
]

const areaViewHeaders = [
  {
    title: 'area',
    key: 'area_description',
  },
  {
    title: 'accessibility',
    key: 'area_accessibility',
  },
  {
    title: 'classification',
    key: 'area_classification',
  },
]

const outsViewHeaders = [
  {
    title: 'equipment',
    key: 'equipment',
  },
  {
    title: 'the reason',
    key: 'the_reason',
  },
]

const standardViewHeaders = [
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'version',
    key: 'version',
  },
]

const hazardsViewHeaders = [
  {
    title: 'Hazard',
    key: 'hazard',
  },
  {
    title: 'Description',
    key: 'description',
  },
  {
    title: 'Risk Level',
    key: 'risk_level',
  },
  {
    title: 'Mitigation Strategy',
    key: 'mitigation_strategy',
  },
]

const riskLevelViewHeaders = [
  {
    title: 'Hazard',
    key: 'hazard',
  },
  {
    title: 'Likelihood',
    key: 'likelihood',
  },
  {
    title: 'Severity',
    key: 'severity',
  },
  {
    title: 'Risk Level',
    key: 'risk_level',
  },
]

const compliancesViewHeaders = [
  {
    title: 'compliance',
    key: 'compliance_desc',
  },
  {
    title: 'action',
    key: 'pivot.action',
  },
  {
    title: 'standard',
    key: 'applicable_standard',
  },
]

const equipmentHeaders = [
  {
    title: 'EQUIPMENT',
    key: 'equipment',
  },
  {
    title: 'Accessory',
    key: 'accessory',
  },
  {
    title: 'Maintenance',
    key: 'maintenance',
  },
  {
    title: 'Supply',
    key: 'supply',
  },
  {
    title: 'STATUS',
    key: 'equipment_status',
  },
] 
</script>

<template>
  <section>
    <!-- Child Components -->
    <MissionReportDialog 
      v-model:isDialogVisible="isViewMissionReportDialogVisible"
      :mission-data="missionData"
      :mission-id="missionData?.id"
      :recommendations-view-headers="recommendationsViewHeaders"
      :suggestions-view-headers="suggestionsViewHeaders"
      :service-view-headers="serviceViewHeaders"
      :area-view-headers="areaViewHeaders"
      :outs-view-headers="outsViewHeaders"
      :standard-view-headers="standardViewHeaders"
      :hazards-view-headers="hazardsViewHeaders"
      :risk-level-view-headers="riskLevelViewHeaders"
      :compliances-view-headers="compliancesViewHeaders"
    />
    <MissionAttestationDialog
      v-model:isDialogVisible="isViewMissionAttestationDialogVisible"
      :mission-data="missionData"
      :mission-id="missionData?.id"
      :recommendations-view-headers="recommendationsViewHeaders"
      :suggestions-view-headers="suggestionsViewHeaders"
      :service-view-headers="serviceViewHeaders"
      :area-view-headers="areaViewHeaders"
      :outs-view-headers="outsViewHeaders"
      :standard-view-headers="standardViewHeaders"
      :hazards-view-headers="hazardsViewHeaders"
      :risk-level-view-headers="riskLevelViewHeaders"
      :compliances-view-headers="compliancesViewHeaders"
    />
    <MissionSpecificsDialog
      v-model:isDialogVisible="isViewMissionSpecificsDialogVisible"
      :mission-data="missionData"
      :mission-id="missionData?.id"
      :equipment-headers="equipmentHeaders"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Missions">
          <VDivider />
          <!-- SECTION - Table Tools -->
          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3 d-flex gap-3">
              <AppSelect
                :model-value="options.itemsPerPage"
                :items="[
                  { value: 10, title: '10' },
                  { value: 25, title: '25' },
                  { value: 50, title: '50' },
                  { value: 100, title: '100' },
                ]"
                style="width: 6.25rem;"
                @update:model-value="options.itemsPerPage = parseInt($event, 10)"
              />
            </div>
            <VSpacer />
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="missions"
            :items-length="totalMissions"
            :headers="missionHeaders"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Mission ID -->
            <template #[`item.mission_id`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveMissionTypeVariant(item.raw.mission_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="font-weight-medium user-list-name text-base">
                    #{{ item.raw.mission_id }}
                  </h6>
                </div>
              </div>
            </template>
            <!-- 👉 Type -->
            <template #[`item.mission_type`]="{ item }">
              <div class="d-flex align-center gap-4">
                <VAvatar
                  :size="30"
                  :color="resolveMissionTypeVariant(item.raw.mission_type).color"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    :icon="resolveMissionTypeVariant(item.raw.mission_type).icon"
                  />
                </VAvatar>
                <span class="text-capitalize">{{ item.raw.mission_type }}</span>
              </div>
            </template>
            <!-- 👉 Client Name -->
            <template #[`item.mission_client`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveMissionTypeVariant(item.raw.mission_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="font-weight-medium user-list-name text-base">
                    {{ item.raw.client_name }}
                  </h6>
                  <span class="text-sm text-medium-emphasis">#{{ item.raw.mission_client_id }}</span>
                </div>
              </div>
            </template>
            <!-- 👉 Status -->
            <template #[`item.mission_status`]="{ item }">
              <VChip
                :color="resolveMissionStatusVariant(item.raw.mission_status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.mission_status }}
              </VChip>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn
                @click="fetchMission(item.raw.id),
                        isViewMissionReportDialogVisible = !isViewMissionReportDialogVisible"
              >
                <VIcon icon="tabler-file-analytics" />
              </IconBtn>
              <IconBtn 
                @click=" fetchMission(item.raw.id),
                         isViewMissionAttestationDialogVisible = !isViewMissionAttestationDialogVisible"
              >
                <VIcon icon="tabler-certificate" />
              </IconBtn>
              <IconBtn 
                @click=" fetchMission(item.raw.id),
                         isViewMissionSpecificsDialogVisible = !isViewMissionSpecificsDialogVisible"
              >
                <VIcon icon="tabler-chart-bar" />
              </IconBtn>
            </template>

            <!-- 👉 pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalMissions) }}
                </p>

                <VPagination
                  v-model="options.page"
                  :length="totalPage"
                  :total-visible="$vuetify.display.xs ? 1 : totalPage"
                >
                  <template #prev="slotProps">
                    <VBtn
                      variant="tonal"
                      color="default"
                      v-bind="slotProps"
                      :icon="false"
                    >
                      Previous
                    </VBtn>
                  </template>

                  <template #next="slotProps">
                    <VBtn
                      variant="tonal"
                      color="default"
                      v-bind="slotProps"
                      :icon="false"
                    >
                      Next
                    </VBtn>
                  </template>
                </VPagination>
              </div>
            </template>
          </VDataTableServer>
          <!-- !SECTION dataTable -->
        </VCard>
      </VCol>
    </VRow>
  </section>
</template>
