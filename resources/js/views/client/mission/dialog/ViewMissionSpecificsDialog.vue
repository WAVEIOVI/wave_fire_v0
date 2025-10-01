<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useMissionListStore } from '../useMissionListStore'
import { useMissionParamsStore } from '../useMissionParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  equipmentHeaders: {
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

const missionParamsStore = useMissionParamsStore()
const missionListStore = useMissionListStore()
const localMissionData = ref((props.missionData))

// Reactive state
const searchQuery = ref('')
const totalPage = ref(1)
const totalEquipments = ref(0)
const equipments = ref([])
const interventionId = ref('')
const interventionData = ref([])

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

// 👉 Watch for Dialog Visibility
watch(
  () => props.isDialogVisible,
  newVal => {
    if (newVal) {
      fetchIntervention()
    }
  },
)

// 👉 Watch for Mission Data Changes
watch(
  () => props.missionData,
  newVal => {
    localMissionData.value = newVal
    fetchIntervention()
  },
  { deep: true },
)

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
    fetchInspectedEquipments()
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

  missionListStore.fetchInspectedEquipments({
    id: interventionId.value,
    search: searchQuery.value,
    options: options.value,
  })
    .then(response => {
      equipments.value = response.data.data
      totalPage.value = response.data.meta.last_page
      totalEquipments.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
      console.log('Fetched equipments:', equipments.value)
    })
    .catch(error => {
      console.error('Error fetching hazards:', error)
    })
}

// Utility functions
const resolveEquipmentStatusVariant = stat => {
  if (stat === 'in service') return 'success'
  if (stat === 'limited use') return 'warning'
  if (stat === 'out of order') return 'error'
  if (stat === 'workshop') return 'warning'
  
  return 'primary'
}

const parsedMaintenance = maintenance => {
  try {
    return JSON.parse(maintenance)
  } catch (error) {
    return []
  }
}

const parsedAdditionalMaintenance = additionalMaintenance => {
  try {
    return JSON.parse(additionalMaintenance)
  } catch (error) {
    return []
  }
}

const parsedSupply = supply => {
  try {
    return JSON.parse(supply)
  } catch (error) {
    return []
  }
}

const parsedAccessory = accessory => {
  try {
    return JSON.parse(accessory)
  } catch (error) {
    return []
  }
}

// Watch for changes in options or searchQuery
watch([() => options.value, searchQuery], () => {
  fetchInspectedEquipments()
}, { deep: true })
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 1400"
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
          <VCol cols="12">
            <VCard title="Performed Tasks">
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

                <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
                  <!-- 👉 Search  -->
                  <div style="inline-size: 10rem;">
                    <AppTextField
                      v-model="searchQuery"
                      placeholder="Search"
                      density="compact"
                    />
                  </div>
                </div>
              </VCardText>
              <!-- !SECTION - Table Tools -->

              <!-- SECTION dataTable -->
              <VDataTableServer
                v-model:items-per-page="options.itemsPerPage"
                v-model:page="options.page"
                :items="equipments"
                :items-length="totalEquipments"
                :headers="equipmentHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <!-- 👉 Equipment Title -->
                <template #[`item.equipment`]="{ item }">
                  <div class="d-flex align-center">
                    <div class="d-flex flex-column">
                      <h6 class="text-base text-uppercase">
                        {{ item.raw.qrc_id }} | {{ item.raw.internal_id }}
                      </h6>
                      <h6 class="text-base text-uppercase">
                        <span class="text-sm text-medium-emphasis"> {{ item.raw.equipment_category }} {{ item.raw.equipment_model }}</span>
                      </h6>
                      <h6 class="text-base text-uppercase">
                        <span class="text-sm text-medium-emphasis"> {{ item.raw.equipment_weight_value }} {{ item.raw.equipment_weight_unit }} {{ item.raw.equipment_pressure }}</span>
                      </h6>
                      <h6 class="text-base text-uppercase">
                        <span class="text-sm text-medium-emphasis"> {{ item.raw.pivot.equipment_protection_name }}</span>
                      </h6>
                    </div>
                  </div>
                  <div class="ga-0">
                    <div class="d-flex align-center mb-0">
                      <span class="text-sm text-medium-emphasis font-weight-medium me-1 text-uppercase">Inspection</span>
                      <VIcon
                        v-if="item.raw.pivot.inspection === 'inspected'"
                        class="me-2"
                        size="16"
                        color="success"
                        icon="tabler-square-check-filled"
                      />
                      <VIcon
                        v-else
                        class="me-2"
                        size="16"
                        color="error"
                        icon="tabler-square-x-filled"
                      />
                      <span class="text-sm text-medium-emphasis font-weight-medium me-1 text-uppercase">Raw Material</span>
                      <VIcon
                        v-if="item.raw.pivot.raw_recharge === 'raw charged'"
                        class="me-2"
                        size="16"
                        color="success"
                        icon="tabler-square-check-filled"
                      />
                      <VIcon
                        v-else
                        class="me-2"
                        size="16"
                        color="error"
                        icon="tabler-square-x-filled"
                      />
                      <span class="text-sm text-medium-emphasis font-weight-medium me-1 text-uppercase">Nitrogen</span>
                      <VIcon
                        v-if="item.raw.pivot.nitrogen_recharge === 'nitrogen charged'"
                        class="me-2"
                        size="16"
                        color="success"
                        icon="tabler-square-check-filled"
                      />
                      <VIcon
                        v-else
                        class="me-2"
                        size="16"
                        color="error"
                        icon="tabler-square-x-filled"
                      />
                    </div>
                  </div>
                </template>
                <!-- 👉 Accessory -->
                <template #[`item.accessory`]="{ item }">
                  <div
                    v-if="item.raw.pivot.accessory && item.raw.pivot.accessory.length > 0 && item.raw.pivot.accessory !== '[]'"
                    class="d-flex align-center mb-0 overflow-x-auto"
                  >
                    <VChipGroup class="d-inline-flex align-center">
                      <VChip
                        v-for="accessory in parsedAccessory(item.raw.pivot.accessory)"
                        :key="accessory"
                        label
                        x-small
                        class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                      >
                        {{ accessory }}
                      </VChip>
                    </VChipGroup>
                  </div>
                </template>
                <!-- 👉 Maintenance -->
                <template #[`item.maintenance`]="{ item }">
                  <div
                    v-if="(item.raw.pivot.maintenance && item.raw.pivot.maintenance.length > 0 && item.raw.pivot.maintenance !== '[]') || 
                      (item.raw.pivot.additional_maintenance && item.raw.pivot.additional_maintenance.length > 0 && item.raw.pivot.additional_maintenance !== '[]')"
                    class="d-flex align-center mb-0  overflow-x-auto" 
                  >
                    <VChipGroup class="d-inline-flex align-center">
                      <VChip
                        v-for="maintenance in parsedMaintenance(item.raw.pivot.maintenance)"
                        :key="maintenance"
                        label
                        x-small
                        class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                      >
                        {{ maintenance }}
                      </VChip>
                      <VChip
                        v-for="additionalMaintenance in parsedAdditionalMaintenance(item.raw.pivot.additional_maintenance)"
                        :key="additionalMaintenance"
                        label
                        x-small
                        class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                      >
                        {{ additionalMaintenance }}
                      </VChip>
                    </VChipGroup>
                  </div>
                </template>
                <!-- 👉 Supply -->
                <template #[`item.supply`]="{ item }">
                  <div
                    v-if="item.raw.pivot.supply && item.raw.pivot.supply.length > 0 && item.raw.pivot.supply !== '[]'"
                    class="d-flex align-center mb-0 overflow-x-auto"
                  >
                    <VChipGroup class="d-inline-flex align-center">
                      <VChip
                        v-for="supply in parsedSupply(item.raw.pivot.supply)"
                        :key="supply"
                        label
                        x-small
                        class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                      >
                        {{ supply }}
                      </VChip>
                    </VChipGroup>
                  </div>
                </template>
                <!-- 👉 Status -->
                <template #[`item.equipment_status`]="{ item }">
                  <VChip
                    :color="resolveEquipmentStatusVariant(item.raw.pivot.equipment_status)"
                    size="small"
                    label
                    class="text-capitalize"
                  >
                    {{ item.raw.pivot.equipment_status }}
                  </VChip>
                </template>

                <!-- 👉 pagination -->
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ paginationMeta(options, totalEquipments) }}
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
      </VCardText>
    </VCard>
  </VDialog>
</template>
