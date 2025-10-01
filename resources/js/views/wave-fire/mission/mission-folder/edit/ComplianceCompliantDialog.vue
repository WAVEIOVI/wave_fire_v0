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
  compliancesHeaders: {
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
const totalCompliances = ref(0)
const compliances = ref([])
const compliancesOptions = ref([])

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

const fetchCompliancesOptions = () => {
  missionParamsStore.fetchCompliancesCompliant({
    options: options.value,
    search: searchQuery.value,
  }).then(response => {
    compliancesOptions.value = response.data.data
  }).catch(error => {
    console.error(error)
  })
}

const complianceData = ref({
  id: '',
  action: '',
})

const resetForm = () => {
  complianceData.value = {
    id: '',
    action: '',
  }
}

const fetchCompliances = () => {
  missionListStore.fetchMissionCompliancesCompliant({
    id: Number(route.params.id),
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    compliances.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalCompliances.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

const attachCompliance = async complianceData => {
  try {
    const formattedData = {
      resources: {
        [complianceData.id]: {
          action: complianceData.action,
        },
      },
    }

    const response = await missionListStore.attachMissionCompliance(Number(route.params.id), formattedData)
    if (response.status === 200) {
      emit('submit')
      fetchCompliances()
    } else {
      throw new Error(`Failed to attach compliance: ${response.statusText}`)
    }
  } catch (error) {
    console.error(error.message)
  }  
}

// 👉 Delete Compliance
const deleteCompliance = complianceId => {
  missionListStore.detachMissionCompliance(Number(route.params.id), complianceId)
    .then(response => {
      if (response.status === 200) {
        console.log('Compliance detached successfully:', response.data)
        fetchCompliances()

        // You might want to add a success notification here
      } else {
        throw new Error('Failed to detach compliance')
      }
    })
    .catch(error => {
      console.error('Error deleting compliance:', error)

      // You might want to add an error notification here
    })
}

const onFormSubmit = () => {
  attachCompliance(complianceData.value)
  resetForm()
}

watchEffect(fetchCompliances)
watchEffect(fetchCompliancesOptions)
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
          Compliances (Compliant)
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Attach A Compliant Point With Mission Report">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="12">
                      <AppAutocomplete
                        v-model="complianceData.id"
                        :items="compliancesOptions"
                        clearable
                        :item-title="item => item.compliance_desc"
                        item-value="id"
                        clear-icon="tabler-x"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.applicable_standard + ' - ' + item.raw.compliance_status"
                          />
                        </template>
                      </AppAutocomplete>
                    </VCol>
                    <VCol cols="12">
                      <VTextField 
                        v-model="complianceData.action"
                        label="Action"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VBtn
                        block
                        type="submit"
                      >
                        Add Compliant
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
            <VCard title="Compliant List">
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
                :items="compliances"
                :items-length="totalCompliances"
                :headers="compliancesHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteCompliance(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ paginationMeta(options, totalCompliances) }}
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
