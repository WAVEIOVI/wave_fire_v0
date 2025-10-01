<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useMissionParamsStore } from './useMissionParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  standardHeaders: {
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
const totalStandards = ref(0)
const standards = ref([])

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

const standardData = ref({
  standard_id: '',
  name: '',
  description: '',
  version: '',
})

const resetForm = () => {
  standardData.value ={
    standard_id: '',
    name: '',
    description: '',
    version: '',
  }
}

// 👉 Fetching standards
const fetchStandards = () => {
  missionParamsStore.fetchStandards({
    search: searchQuery.value,
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

// 👉 Add Standard
const addStandard = async standardData => {
  try {
    const response = await missionParamsStore.addStandard(standardData)

    if (response.status === 201) {
      fetchStandards()
    } else {
      throw new Error(`Failed to create standard: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Standard
const deleteStandard = id => {
  missionParamsStore.deleteStandard(id)
    .then(response => {
      console.log(response.data)
      fetchStandards()
    })
    .catch(error => {
      console.error('Error deleting standard:', error)
    })
}

const onFormSubmit = () => {
  addStandard(standardData.value)
  resetForm()
}

watchEffect(fetchStandards)
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
          Standards Referenced
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Add New Standard">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="3">
                      <VTextField 
                        v-model="standardData.standard_id"
                        label="Standard ID"
                      />
                    </VCol>
                    <VCol cols="5">
                      <VTextField 
                        v-model="standardData.name"
                        label="Standard Name"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VBtn type="submit">
                        Add New Standard
                      </VBtn>
                    </VCol>
                    <VCol cols="8">
                      <VTextField
                        v-model="standardData.description"
                        rows="1"
                        variant="outlined"
                        label="Description"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VTextField
                        v-model="standardData.version"
                        variant="outlined"
                        label="Version"
                      />
                    </VCol>
                  </VRow>
                </VForm>
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
        <VRow>
          <VCol cols="12">
            <VCard title="Standards List">
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
                :items="standards"
                :items-length="totalStandards"
                :headers="standardHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <!-- 👉 Actions -->
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteStandard(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>

                <!-- 👉 pagination -->
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ paginationMeta(options, totalStandards) }}
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
