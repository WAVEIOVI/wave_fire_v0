<script setup>
import { useRoute } from 'vue-router'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useMissionListStore } from '../useMissionListStore'
import { useMissionParamsStore } from '../useMissionParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  hazardsHeaders: {
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
  'submit',
])

const route = useRoute()
const missionParamsStore = useMissionParamsStore()
const missionListStore = useMissionListStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalHazards = ref(0)
const hazards = ref([])
const hazardsOptions = ref([])

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

const hazardData = ref({
  hazard: '',
  description: '',
  mitigation_strategy: '',
  likelihood: '',
  severity: '',
  risk_level: '',
})

const resetForm = () => {
  hazardData.value = {
    hazard: '',
    description: '',
    mitigation_strategy: '',
    likelihood: '',
    severity: '',
    risk_level: '',
  }
}

const fetchHazardsOptions = () => {
  missionParamsStore.fetchHazards({
    options: options.value,
  }).then(response => {
    hazardsOptions.value = response.data.data
  }).catch(error => {
    console.error(error)
  })
}

const fetchHazards = () => {
  missionListStore.fetchMissionHazards({
    id: Number(route.params.id),
    search: searchQuery.value,
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

const addHazard = async hazardData => {
  try {
    const response = await missionListStore.addMissionHazard(Number(route.params.id), hazardData)
    if (response.status === 201) {
      fetchHazards()
    } else {
      throw new Error(`Failed to create client: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const deleteHazard = hazardId => {
  missionListStore.deleteMissionHazard(Number(route.params.id), hazardId)
    .then(response => {
      console.log(response.data)
      fetchHazards()
    })
    .catch(error => {
      console.error('Error deleting client:', error)
    })
}

const onFormSubmit = () => {
  addHazard(hazardData.value)
  resetForm()
}

watchEffect(fetchHazards)
watchEffect(fetchHazardsOptions)


const likelihoodOptions = [
  { title: 'Very Likely', value: 'very-likely' },
  { title: 'Likely', value: 'likely' },
  { title: 'Medium', value: 'medium' },
  { title: 'Unlikely', value: 'unlikely' },
  { title: 'Very Unlikely', value: 'very-unlikely' },
]

const severityOptions = [
  { title: 'Low', value: 'low' },
  { title: 'Medium', value: 'medium' },
  { title: 'High', value: 'high' },
  { title: 'Very High', value: 'very-high' },
]

// Define the risk level matrix
const riskMatrix = {
  'very-likely': { 'low': 'medium', 'medium': 'High', 'high': 'High', 'very-high': 'high' },
  'likely': { 'low': 'low', 'medium': 'medium', 'high': 'high', 'very-high': 'high' },
  'medium': { 'low': 'low', 'medium': 'medium', 'high': 'medium', 'very-high': 'high' },
  'unlikely': { 'low': 'low', 'medium': 'low', 'high': 'medium', 'very-high': 'medium' },
  'very-unlikely': { 'low': 'low', 'medium': 'low', 'high': 'low', 'very-high': 'medium' },
}

// Calculate risk level based on likelihood and severity
const calculateRiskLevel = () => {
  const likelihood = hazardData.value.likelihood
  const severity = hazardData.value.severity

  hazardData.value.risk_level = riskMatrix[likelihood]?.[severity] || ''
}

// Watch for changes in likelihood and severity to recalculate risk level
watch(() => [hazardData.value.likelihood, hazardData.value.severity], calculateRiskLevel)
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 1200"
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />

    <VCard class="pa-sm-8 pa-5">
      <VCardItem class="text-center">
        <VCardTitle class="text-h3 mb-3">
          Risk Assessment
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Add A Hazard With This Mission">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <!-- Hazard -->
                    <VCol cols="4">
                      <AppAutocomplete
                        v-model="hazardData.hazard"
                        :items="hazardsOptions"
                        clearable
                        :item-title="item => item.name"
                        item-value="name"
                        clear-icon="tabler-x"
                        label="Hazard"
                      />
                    </VCol>
                    <VCol cols="8">
                      <AppTextField
                        v-model="hazardData.description"
                        label="Description"
                      />
                    </VCol>
                    <!-- Likelihood -->
                    <VCol
                      md="4"
                      cols="6"
                    >
                      <AppSelect
                        v-model="hazardData.likelihood"
                        label="Likelihood"
                        :items="likelihoodOptions"
                      />
                    </VCol>
                    <!-- Severity -->
                    <VCol
                      md="4"
                      cols="6"
                    >
                      <AppSelect
                        v-model="hazardData.severity"
                        label="Severity"
                        :items="severityOptions"
                      />
                    </VCol>
                    <!-- Risk Level -->
                    <VCol
                      md="4"
                      cols="12"
                    >
                      <AppTextField
                        v-model="hazardData.risk_level"
                        label="Risk Level"
                        placeholder="Risk Level"
                        readonly
                      />
                    </VCol>
                    <!-- Mitigation Strategy -->
                    <VCol
                      md="12"
                      cols="12"
                    >
                      <AppTextField
                        v-model="hazardData.mitigation_strategy"
                        label="Mitigation Strategy"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VBtn
                        block
                        type="submit"
                      >
                        Add Hazard
                      </VBtn>
                    </VCol>
                  </VRow>
                </VForm>
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
        <VRow>
          <VCol cols="12">
            <VCard title="Hazards List">
              <VDivider />
              <VCardText class="d-flex flex-wrap py-4 gap-4">
                <VSpacer />
                <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
                  <div style="inline-size: 10rem;">
                    <AppTextField
                      v-model="searchQuery"
                      placeholder="Search"
                      density="compact"
                    />
                  </div>
                </div>
              </VCardText>
              <VDivider />
              <VDataTableServer
                v-model:items-per-page="options.itemsPerPage"
                v-model:page="options.page"
                :items="hazards"
                :items-length="totalHazards"
                :headers="props.hazardsHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteHazard(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div
                    class="d-flex align-center justify-sm-space-between justify-center flex-wrap```html
                    gap-3 pa-5 pt-3"
                  >
                    <p class="text-sm text-disabled mb-0">
                      {{ paginationMeta(options, totalHazards) }}
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
            </VCard>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>
