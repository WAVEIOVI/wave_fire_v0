<script setup>
import { useUserClientDashboardStore } from '@/stores/useUserClientDashboardStore'

const props = defineProps({
  clientData: {
    type: Object,
    required: true,
  },
  parks: {
    type: Array,
    required: true,
  },
  equipments: {
    type: Array,
    required: true,
  },
})

const clientDashboardStore = useUserClientDashboardStore()

const parks = ref((props.parks))
const clientData = ref((props.clientData))
const totalEquipment = ref()
const totalFireExtinguisher = ref()
const activeEquipment = ref()
const limitedUseEquipment = ref()
const outOfOrderEquipment = ref()
const workshopEquipment = ref()

const fetchMetaEquipment = clientName => {
  if (!clientName) return // Check if clientName has a value
  clientDashboardStore.fetchMetaEquipment({
    client: clientName,
  }).then(response => {
    totalEquipment.value = response.data.data.total_client.total_equipment
    totalFireExtinguisher.value = response.data.data.total_client.total_fire_extinguisher
    activeEquipment.value = response.data.data.total_client.total_active_extinguisher
    limitedUseEquipment.value = response.data.data.total_client.total_limited_use_extinguisher
    outOfOrderEquipment.value = response.data.data.total_client.out_of_order
    workshopEquipment.value = response.data.data.total_client.total_workshop_extinguisher
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Fetch Equipment on mount
onMounted(() => {
  fetchMetaEquipment(clientData.value.client_name)
})

// 👉 Watch for clientData changes
watch(
  () => props.clientData,
  newValue => {
    clientData.value = newValue
    fetchMetaEquipment(newValue.client_name)
    console.log('clientData in child:', clientData.value)
  },
  { deep: true },
)

// 👉 Park List Meta
const parkListMeta = [
  {
    icon: 'tabler-map-pin',
    color: 'primary',
    title: 'Total Parks',
    count: parks,
  },
  {
    icon: 'tabler-tool',
    color: 'error',
    title: 'Total Equipment',
    count: totalEquipment,
  },
  {
    icon: 'tabler-fire-extinguisher',
    color: 'error',
    title: 'Fire Extinguisher',
    count: totalFireExtinguisher,
  },
  {
    icon: 'tabler-checkbox',
    color: 'success',
    title: 'In Service',
    count: activeEquipment,
  },
  {
    icon: 'tabler-abacus',
    color: 'primary',
    title: 'Limited Use',
    count: limitedUseEquipment,
  },
  {
    icon: 'tabler-abacus',
    color: 'primary',
    title: 'Workshop',
    count: workshopEquipment,
  },
  {
    icon: 'tabler-abacus',
    color: 'primary',
    title: 'out Of Order',
    count: outOfOrderEquipment,
  },
]

watch(
  () => props.parks,
  newValue => {
    parks.value = newValue
    console.log('parks in child:', parks.value)
  },
  { deep: true },
)
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in parkListMeta"
        :key="meta.title"
        cols="12"
        sm="6"
        lg="6"
      >
        <VCard>
          <VCardText class="d-flex justify-space-between">
            <div>
              <h5 class="text-h4">
                {{ meta.count }}
              </h5>

              <div class="d-flex align-center gap-2 my-1">
                <h5 class="text-h4">
                  {{ meta.title }}
                </h5>
              </div>
            </div>

            <VAvatar
              rounded
              variant="tonal"
              :color="meta.color"
              :icon="meta.icon"
            />
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </section>
</template>
