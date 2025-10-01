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
  recommendationsHeaders: {
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
const totalRecommendations = ref(0)
const recommendations = ref([])
const recommendationsOptions = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 1000,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const recommendationStatusOptions = [
  {
    title: 'Critical Recommendation',
    value: 'critical',
  },
  {
    title: 'Immediate Recommendation',
    value: 'immediate',
  },
  {
    title: 'Short-Term Recommendation',
    value: 'short_term',
  },
  {
    title: 'Long-Term Recommendation',
    value: 'long_term',
  },
]

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

const fetchRecommendationsOptions = () => {
  missionParamsStore.fetchRecommendations({
    options: options.value,
    search: searchQuery.value,
  }).then(response => {
    recommendationsOptions.value = response.data.data
  }).catch(error => {
    console.error(error)
  })
}

const recommendationData = ref({
  id: '',
  recommendation_status: '',
})

const resetForm = () => {
  recommendationData.value = {
    id: '',
    recommendation_status: '',
  } 
}

const fetchRecommendations = () => {
  missionListStore.fetchMissionRecommendations({
    id: Number(route.params.id),
    search: searchQuery.value,
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

const attachRecommendation = async recommendationData => {
  try {
    const formattedData = {
      resources: {
        [recommendationData.id]: {
          recommendation_status: recommendationData.recommendation_status,
        },
      },
    }

    const response = await missionListStore.attachMissionRecommendation(Number(route.params.id), formattedData)
    if (response.status === 200) {
      emit('submit')
      fetchRecommendations()
    } else {
      throw new Error(`Failed to attach recommendation: ${response.statusText}`)
    }
  } catch (error) {
    console.error(error.message)
  }  
}

const deleteRecommendation = recommendationId => {
  missionListStore.detachMissionRecommendation(Number(route.params.id), recommendationId)
    .then(response => {
      if (response.status === 200) {
        fetchRecommendations()
      } else {
        throw new Error('Failed to detach Recommendation')
      }
    })
    .catch(error => {
      console.error('Error deleting Recommendation:', error)
    })
}

const onFormSubmit = () => {
  attachRecommendation(recommendationData.value)
  resetForm()
}

watchEffect(fetchRecommendations)
watchEffect(fetchRecommendationsOptions)

const filteredRecommendations = computed(() => {
  return {
    critical: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'critical'),
    immediate: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'immediate'),
    short_term: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'short_term'),
    long_term: recommendations.value.filter(rec => rec.pivot.recommendation_status === 'long_term'),
  }
})
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
          Recommendations
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Attach A Recommendation With Mission Report">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="12">
                      <AppAutocomplete
                        v-model="recommendationData.id"
                        :items="recommendationsOptions"
                        clearable
                        :item-title="item => item.name"
                        item-value="id"
                        clear-icon="tabler-x"
                      />
                    </VCol>
                    <VCol cols="8">
                      <AppAutocomplete
                        v-model="recommendationData.recommendation_status"
                        :items="recommendationStatusOptions"
                        clearable
                        clear-icon="tabler-x"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VBtn
                        block
                        type="submit"
                      >
                        Add Recommendation
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
            <VCard title="Critical Recommendations">
              <VDivider />
              <VDataTableServer
                :items="filteredRecommendations.critical"
                :headers="props.recommendationsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteRecommendation(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredRecommendations.critical) }}
                    </p>
                  </div>
                </template>
              </VDataTableServer>
            </VCard>
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="12">
            <VCard title="Immediate Recommendations">
              <VDivider />
              <VDataTableServer
                :items="filteredRecommendations.immediate"
                :headers="props.recommendationsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteRecommendation(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredRecommendations.immediate) }}
                    </p>
                  </div>
                </template>
              </VDataTableServer>
            </VCard>
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="12">
            <VCard title="Short-Term Recommendations">
              <VDivider />
              <VDataTableServer
                :items="filteredRecommendations.short_term"
                :headers="props.recommendationsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteRecommendation(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredRecommendations.short_term) }}
                    </p>
                  </div>
                </template>
              </VDataTableServer>
            </VCard>
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="12">
            <VCard title="Long-Term Recommendations">
              <VDivider />
              <VDataTableServer
                :items="filteredRecommendations.long_term"
                :headers="props.recommendationsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteRecommendation(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredRecommendations.long_term) }}
                    </p>
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
