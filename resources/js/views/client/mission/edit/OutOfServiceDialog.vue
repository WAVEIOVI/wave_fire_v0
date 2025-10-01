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
  outsHeaders: {
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
const totalOuts = ref(0)
const outs = ref([])
const outOfOrderQrcModelWeight = ref({})
const outsOptions = ref({})
const interventionId = ref('')
const interventionData = ref([])

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

const outData = ref({
  equipment: '',
  the_reason: '',
})

const resetForm = () => {
  outData.value = {
    equipment: '',
    the_reason: '',
  }
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
    fetchOutsOptions()
  } catch(error) {
    console.error(error)
  }
}

// 👉 fetch Outs Options
const fetchOutsOptions = () => {
  missionListStore.fetchMetaInspectedEquipments({
    id: interventionId.value,
  }).then(response => {
    outOfOrderQrcModelWeight.value = response.data.meta.out_of_order_fire_extinguisher_by_qrc_model_weight
    outsOptions.value = Object.keys(outOfOrderQrcModelWeight.value)      
  }).catch(error => {
    console.error(error)
  })
}

const fetchOuts = () => {
  missionListStore.fetchMissionOuts({
    id: Number(route.params.id),
    search: searchQuery.value,
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

const addOut = async outData => {
  try {
    const response = await missionListStore.addMissionOut(Number(route.params.id), outData)
    if (response.status === 201) {
      fetchOuts()
    } else {
      throw new Error(`Failed to create client: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const deleteOut = outId => {
  missionListStore.deleteMissionOut(Number(route.params.id), outId)
    .then(response => {
      console.log(response.data)
      fetchOuts()
    })
    .catch(error => {
      console.error('Error deleting client:', error)
    })
}

const onFormSubmit = () => {
  addOut(outData.value)
  resetForm()
}

watchEffect(fetchOuts)
watchEffect(fetchOutsOptions)
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
          OUT OF SERVICE EQUIPMENT
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Add A Out Of Service Equipment With This Mission">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <!-- Out -->
                    <VCol cols="12">
                      <AppAutocomplete
                        v-model="outData.equipment"
                        :items="outsOptions"
                        clearable
                        :item-title="item => item.name"
                        item-value="name"
                        clear-icon="tabler-x"
                        label="Out Of Service Equipment"
                      />
                    </VCol>
                    <VCol cols="12">
                      <AppTextField
                        v-model="outData.the_reason"
                        label="The Reason Desc"
                      />
                    </VCol>
                    <VCol cols="6">
                      <VBtn
                        block
                        type="submit"
                      >
                        Add Out Of Service Equipment
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
            <VCard title="Out Of Service Equipment List">
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
                :items="outs"
                :items-length="totalOuts"
                :headers="outsHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteOut(item.raw.id)">
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
                      {{ paginationMeta(options, totalOuts) }}
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
