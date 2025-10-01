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
  suggestionsHeaders: {
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
const totalSuggestions = ref(0)
const suggestions = ref([])
const suggestionsOptions = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 1000,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const suggestionStatusOptions = [
  {
    title: 'Monthly Tasks',
    value: 'monthly',
  },
  {
    title: 'Quarterly Tasks',
    value: 'quarterly',
  },
  {
    title: 'Semi-Annual Tasks',
    value: 'semi_annual',
  },
  {
    title: 'Annual Tasks',
    value: 'annual',
  },
  {
    title: 'As Needed',
    value: 'as_needed',
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

const fetchSuggestionsOptions = () => {
  missionParamsStore.fetchSuggestions({
    options: options.value,
    search: searchQuery.value,
  }).then(response => {
    suggestionsOptions.value = response.data.data
  }).catch(error => {
    console.error(error)
  })
}

const suggestionData = ref({
  id: '',
  suggestion_status: '',
})

const resetForm = () => {
  suggestionData.value = {
    id: '',
    suggestion_status: '',
  } 
}

const fetchSuggestions = () => {
  missionListStore.fetchMissionSuggestions({
    id: Number(route.params.id),
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    suggestions.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalSuggestions.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

const attachSuggestion = async suggestionData => {
  try {
    const formattedData = {
      resources: {
        [suggestionData.id]: {
          suggestion_status: suggestionData.suggestion_status,
        },
      },
    }

    const response = await missionListStore.attachMissionSuggestion(Number(route.params.id), formattedData)
    if (response.status === 200) {
      emit('submit')
      fetchSuggestions()
    } else {
      throw new Error(`Failed to attach suggestion: ${response.statusText}`)
    }
  } catch (error) {
    console.error(error.message)
  }  
}

const deleteSuggestion = suggestionId => {
  missionListStore.detachMissionSuggestion(Number(route.params.id), suggestionId)
    .then(response => {
      if (response.status === 200) {
        fetchSuggestions()
      } else {
        throw new Error('Failed to detach Suggestion')
      }
    })
    .catch(error => {
      console.error('Error deleting Suggestion:', error)
    })
}

const onFormSubmit = () => {
  attachSuggestion(suggestionData.value)
  resetForm()
}

watchEffect(fetchSuggestions)
watchEffect(fetchSuggestionsOptions)

const filteredSuggestions = computed(() => {
  return {
    monthly: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'monthly'),
    quarterly: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'quarterly'),
    semi_annual: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'semi_annual'),
    annual: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'annual'),
    as_needed: suggestions.value.filter(rec => rec.pivot.suggestion_status === 'as_needed'),
    
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
          Suggestions (Tasks)
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Attach A Suggestion With Mission Report">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="12">
                      <AppAutocomplete
                        v-model="suggestionData.id"
                        :items="suggestionsOptions"
                        clearable
                        :item-title="item => item.name"
                        item-value="id"
                        clear-icon="tabler-x"
                      />
                    </VCol>
                    <VCol cols="8">
                      <AppAutocomplete
                        v-model="suggestionData.suggestion_status"
                        :items="suggestionStatusOptions"
                        clearable
                        clear-icon="tabler-x"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VBtn
                        block
                        type="submit"
                      >
                        Add Suggestion
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
            <VCard title="Monthly Tasks">
              <VDivider />
              <VDataTableServer
                :items="filteredSuggestions.monthly"
                :headers="props.suggestionsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteSuggestion(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredSuggestions.monthly) }}
                    </p>
                  </div>
                </template>
              </VDataTableServer>
            </VCard>
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="12">
            <VCard title="Quarterly Tasks">
              <VDivider />
              <VDataTableServer
                :items="filteredSuggestions.quarterly"
                :headers="props.suggestionsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteSuggestion(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredSuggestions.quarterly) }}
                    </p>
                  </div>
                </template>
              </VDataTableServer>
            </VCard>
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="12">
            <VCard title="Semi Annual Tasks"> 
              <VDivider />
              <VDataTableServer
                :items="filteredSuggestions.semi_annual"
                :headers="props.suggestionsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteSuggestion(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredSuggestions.semi_annual) }}
                    </p>
                  </div>
                </template>
              </VDataTableServer>
            </VCard>
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="12">
            <VCard title="Annual Tasks">
              <VDivider />
              <VDataTableServer
                :items="filteredSuggestions.annual"
                :headers="props.suggestionsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteSuggestion(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredSuggestions.annual) }}
                    </p>
                  </div>
                </template>
              </VDataTableServer>
            </VCard>
          </VCol>
        </VRow>
        <VRow>
          <VCol cols="12">
            <VCard title="As Needed">
              <VDivider />
              <VDataTableServer
                :items="filteredSuggestions.as_needed"
                :headers="props.suggestionsHeaders"
                class="text-no-wrap"
              >
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteSuggestion(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ getPaginationMeta(filteredSuggestions.as_needed) }}
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
