<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useMissionParamsStore } from './useMissionParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  complianceHeaders: {
    type: Array,
    required: true,
  },
  status: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
])

//!SECTION UI
//SECTION Declaration
const missionParamsStore = useMissionParamsStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalCompliances = ref(0)
const compliances = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 1000,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

const complianceData = ref({
  compliance_desc: '',
  applicable_standard: '',
  compliance_status: '',

})

const resetForm = () => {
  complianceData.value ={
    compliance_desc: '',
    applicable_standard: '',
    compliance_status: '',
  }
}

const standards = ref([])

// 👉 Fetching standards
const fetchStandards = () => {
  missionParamsStore.fetchStandards({
    options: options.value,
  }).then(response => {
    standards.value = response.data.data
    options.value.page = response.data.meta.current_page
    emitCategories() 
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Fetching compliances
const fetchCompliances = () => {
  missionParamsStore.fetchCompliances({
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

// 👉 Add Compliance
const addCompliance = async complianceData => {
  try {
    const response = await missionParamsStore.addCompliance(complianceData)

    if (response.status === 201) {
      fetchCompliances()
    } else {
      throw new Error(`Failed to create compliance: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Compliance
const deleteCompliance = id => {
  missionParamsStore.deleteCompliance(id)
    .then(response => {
      console.log(response.data)
      fetchCompliances()
    })
    .catch(error => {
      console.error('Error deleting compliance:', error)
    })
}

const onFormSubmit = () => {
  addCompliance(complianceData.value)
  resetForm()
}

onMounted(() => {
  fetchStandards()
})

watchEffect(fetchCompliances)
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 1200"
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <!-- 👉 Dialog close btn -->
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />

    <VCard class="pa-sm-8 pa-5">
      <!-- 👉 Title -->
      <VCardItem class="text-center">
        <VCardTitle class="text-h3 mb-3">
          Compliances                       {{ complianceData.applicable_standard }}
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Add New Compliance">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="12">
                      <VTextField 
                        v-model="complianceData.compliance_desc"
                        label="Compliance"
                      />
                    </VCol>
                    <VCol cols="6">
                      <!-- 👉 Compliance -->
                      <AppSelect
                        v-model="complianceData.applicable_standard"
                        label="Select Applicable Standard"
                        item-title="name"
                        :item-value="item => `${item.name} - ${item.version}`"
                        :items="standards"
                        clearable
                        clear-icon="tabler-x"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.name + ' - ' + item.raw.version"
                          />
                        </template>
                      </AppSelect>
                    </VCol>
                    <VCol cols="6">
                      <!-- 👉 compliance_status -->
                      <AppSelect
                        v-model="complianceData.compliance_status"
                        label="Select Status"
                        :items="status"
                        persistent-hint
                        single-line
                        clearable
                        clear-icon="tabler-x"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VBtn type="submit">
                        Add New Compliance
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
            <VCard title="Compliances List">
              <VDivider />
              <!-- SECTION - Table Tools -->
              <VCardText class="d-flex flex-wrap py-4 gap-4">
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

              <VDivider />
              <!-- SECTION dataTable -->
              <VDataTableServer
                v-model:items-per-page="options.itemsPerPage"
                v-model:page="options.page"
                :items="compliances"
                :items-length="totalCompliances"
                :headers="complianceHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <!-- 👉 Actions -->
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteCompliance(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>

                <!-- 👉 pagination -->
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
              <!-- !SECTION dataTable -->
            </VCard>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>
