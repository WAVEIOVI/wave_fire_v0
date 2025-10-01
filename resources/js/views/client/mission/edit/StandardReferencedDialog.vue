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
  headers: {
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
const totalStandards = ref(0)
const standards = ref([])
const standardsOptions = ref([])

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

const fetchStandardsOptions = () => {
  missionParamsStore.fetchStandards({
    options: options.value,
    search: searchQuery.value,
  }).then(response => {
    standardsOptions.value = response.data.data
  }).catch(error => {
    console.error(error)
  })
}

const standardData = ref({
  id: '',
})

const resetForm = () => {
  standardData.value = {
    id: '',
  }
}

const fetchStandards = () => {
  missionListStore.fetchMissionStandards({
    id: Number(route.params.id),
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

const attachStandard = async standardData => {
  try {
    const response = await missionListStore.attachMissionStandard(Number(route.params.id), standardData.id)
    if (response.status === 200) {
      emit('submit')
      fetchStandards()
    } else {
      throw new Error(`Failed to attach standard: ${response.statusText}`)
    }
  } catch (error) {
    console.error(error.message)
  }  
}

// 👉 Delete Standard
const deleteStandard = standardId => {
  missionListStore.detachMissionStandard(Number(route.params.id), standardId)
    .then(response => {
      if (response.status === 200) {
        console.log('Standard detached successfully:', response.data)
        fetchStandards()

        // You might want to add a success notification here
      } else {
        throw new Error('Failed to detach standard')
      }
    })
    .catch(error => {
      console.error('Error deleting standard:', error)

      // You might want to add an error notification here
    })
}

const onFormSubmit = () => {
  attachStandard(standardData.value)
  resetForm()
}

watchEffect(fetchStandards)
watchEffect(fetchStandardsOptions)
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
          Standards Referenced
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Attach A Standard With Mission Report">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="8">
                      <AppAutocomplete
                        v-model="standardData.id"
                        :items="standardsOptions"
                        clearable
                        :item-title="item => item.name"
                        item-value="id"
                        clear-icon="tabler-x"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.standard_id + ' - ' + item.raw.description + ' - ' + item.raw.version"
                          />
                        </template>
                      </AppAutocomplete>
                    </VCol>
                    <VCol cols="4">
                      <VBtn
                        block
                        type="submit"
                      >
                        Add Standard
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
            <VCard title="Standards List">
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
                :items="standards"
                :items-length="totalStandards"
                :headers="headers"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteStandard(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
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
            </VCard>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>
