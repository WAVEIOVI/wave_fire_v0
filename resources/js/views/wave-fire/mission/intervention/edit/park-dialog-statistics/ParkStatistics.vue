<script setup>
import { useMissionListStore } from '@/views/wave-fire/mission/mission-folder/useMissionListStore'
import { useRoute } from 'vue-router'

const props = defineProps({
  interventionData: {
    type: Array,
    required: true,
  },
})

const localInterventionData = ref(props.interventionData)

const totalEquipment = ref(null)
const totalFireExtinguisher = ref(null)
const totalFireHose = ref(null)
const othersEquipment = ref(null)

const route = useRoute()
const missionListStore = useMissionListStore()

// 👉 Fetch Equipment
onMounted(() => {
  const interventionId = Number(route.params.id)
  if (interventionId) {
    missionListStore.fetchMetaInspectedEquipments({
      id: interventionId,
    }).then(response => {
      console.log('Response:', response)  // Debugging log
      if (response.data && response.data.meta) {
        totalEquipment.value = response.data.meta.inspected_equipment
        totalFireExtinguisher.value = response.data.meta.inspected_fire_extinguisher
        totalFireHose.value = response.data.meta.inspected_fire_hose
        othersEquipment.value = response.data.meta.inspected_others_equipment
      }
    }).catch(error => {
      console.error('Fetch error:', error)  // Debugging log
    })
  }
})

const equipmentCount = computed(() => {
  return totalEquipment.value !== null ? totalEquipment.value : null
})

const fireExtinguisherCount = computed(() => {
  return totalFireExtinguisher.value !== null ? totalFireExtinguisher.value : null
})

const fireHoseCount = computed(() => {
  return totalFireHose.value !== null ? totalFireHose.value : null
})

const othersEquipmentCount = computed(() => {
  return othersEquipment.value !== null ? othersEquipment.value : null
})

const statistics = [
  {
    title: 'Equipment',
    stats: equipmentCount,
    icon: 'tabler-tool',
    color: 'primary',
  },
  {
    title: 'Fire Extinguisher',
    stats: fireExtinguisherCount,
    icon: 'tabler-fire-extinguisher',
    color: 'primary',
  },
  {
    title: 'Fire Hose',
    stats: fireHoseCount,
    icon: 'tabler-firetruck',
    color: 'primary',
  },
  {
    title: 'Others Equipment',
    stats: othersEquipmentCount,
    icon: 'tabler-tools',
    color: 'primary',
  },
]
</script>

<template>
  <VCard title="Statistics">
    <VCardText class="pt-0">
      <VRow>
        <VCol
          v-for="item in statistics"
          :key="item.title"
          cols="6"
          md="3"
        >
          <div class="d-flex align-center gap-4">
            <VAvatar
              :color="item.color"
              variant="tonal"
              size="42"
            >
              <VIcon :icon="item.icon" />
            </VAvatar>

            <div class="d-flex flex-column">
              <span class="text-h5 font-weight-medium">{{ item.stats }}</span>
              <span class="text-sm">
                {{ item.title }}
              </span>
            </div>
          </div>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>
