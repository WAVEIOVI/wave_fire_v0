<script setup>
import { useEquipmentParamsStore } from '@/views/config/inventory/useEquipmentParamsStore'
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'
import { useInterventionListStore } from '../../useInterventionListStore'
import AddNewAreaDialog from './AddNewAreaDialog.vue'
import AddNewEquipmentDialog from './AddNewEquipmentDialog.vue'
import AttachNewEquipmentDialog from './AttachNewEquipmentDialog.vue'
import StatisticsDetails from './park-charts/StatisticsDetails.vue'

const props = defineProps({
  interventionData: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const route = useRoute()
const interventionListStore = useInterventionListStore()

const localInterventionData = ref((props.interventionData))

const isReadOnly = computed(() => {
  return localInterventionData.value.intervention_status === 'completed'
})

//SECTION Declaration
const router = useRouter()
const parkListStore = useParkListStore()
const equipmentParamsStore = useEquipmentParamsStore()
const equipmentData = ref([])
const areas = ref([])
const parkId = localInterventionData.value.park
const interventionId = localInterventionData.value.intervention_id
const isAddNewEquipmentDialogVisible = ref(false)
const isAddNewAreaDialogVisible = ref(false)
const isAttachEquipmentDialogVisible = ref(false)
const isStatisticsDetailsDialogVisible = ref(false)
const isRedirectionToAttachEquipmentDialogVisible = ref(false)
const newEquipmentId = ref()
const newEquipmentQrcId = ref()
const equipmentFetched = ref('')

watch(equipmentFetched, newVal => {
  console.log('Equipment Fetched Updated:', newVal)
})


// SECTION Options
const areaAccessibilityOptions = [
  'Open Access Area',
  'Easy Access',
  'Limited Access',
  'Difficult Access',
  'Restricted Access Area',
  'Inaccessible',
]

const areaClassificationOptions = [
  'High Risk',
  'Medium Risk',
  'Low Risk',
  'Controlled Risk',
  'No Risk',
  'Special Risk',
  'Safe Area',
]

const resolveAccessibilityColor = {
  'Open Access Area': 'success',
  'Easy Access': 'info',
  'Limited Access': 'secondary',
  'Difficult Access': 'warning',
  'Restricted Access Area': 'error',
  'Inaccessible': 'error',
}

const resolveClassificationColor = {
  'Safe Area': 'success',
  'No Risk': 'info', 
  'Controlled Risk': 'secondary',
  'Low Risk': 'warning',
  'Medium Risk': 'error',
  'High Risk': 'error',
}

// 👉 Add Equipment
const accessories = ref([])

const addEquipment = async ({ equipmentData, accessories }) => {
  try {
    const response = await parkListStore.addParkEquipment(parkId, equipmentData)
    if (response.status === 201) {
      newEquipmentId.value = response.data.data.id // Ensure this ID is correctly retrieved
      newEquipmentQrcId.value = response.data.data.qrc_id // Ensure this QRC ID is correctly retrieved

      await addNewAccessories(newEquipmentId.value, accessories)
       
      isRedirectionToAttachEquipmentDialogVisible.value = true
      
    } else {
      throw new Error(`Failed to create equipment: ${response.statusText}`)
    }
  } catch (error) { 
    console.log(error.message)
  }
}

// 👉 fetch Equipment

const fetchEquipment = async () => {
  try {
    const response = await interventionListStore.fetchEquipment(newEquipmentId.value)

    equipmentFetched.value = response.data.data
    console.log('Fetched Equipment:', equipmentFetched.value)
  } catch (error) {
    console.error('Error fetching equipment:', error)
  }
}


// 👉 Attach Equipment
const attachEquipment = async equipmentData => {
  try {
    const response = await interventionListStore.attachInterventionEquipment(Number(route.params.id), equipmentData)
    if (response.status === 200) {
      emit('submit')
    } else {
      throw new Error(`Failed to create park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const addNewAccessories = async (equipmentId, accessories) => {
  try {
    const formattedAccessories = accessories.map(id => ({ equipment_accessory_id: id })) // Format correctly
    const response = await parkListStore.addNewAccessories(equipmentId, formattedAccessories)
    if (response.status === 200) {
      console.log('Accessories Created')
    } else {
      throw new Error(`Failed to create accessories: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const fetchAreas = () => {
  parkListStore.fetchParkAreas(parkId)
    .then(response => {
      areas.value = response.data.data.map(area => ({ ...area }))
      console.log(areas.value)
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Add Area
const addArea = async areaData => {
  try {
    const response = await parkListStore.addParkArea(parkId, areaData)
    if (response.status === 201) {
      fetchAreas()
    } else {
      throw new Error(`Failed to create park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Fetch Areas
onMounted(() => {
  fetchAreas()
  if (newEquipmentId.value) {
    fetchEquipment()
  }

})
</script>

<template>
  <AddNewAreaDialog
    v-model:isDialogVisible="isAddNewAreaDialogVisible"    
    :area-classification-options="areaClassificationOptions"
    :area-accessibility-options="areaAccessibilityOptions"
    @submit="addArea"
  />
  <AddNewEquipmentDialog
    v-model:is-dialog-visible="isAddNewEquipmentDialogVisible"
    :areas="areas"
    @submit="addEquipment"
  />
  <AttachNewEquipmentDialog
    v-model:is-dialog-visible="isAttachEquipmentDialogVisible"
    :intervention-data="interventionData"
    :equipment-fetched="equipmentFetched"
    @submit="attachEquipment"
  />
  <StatisticsDetails
    v-model:is-dialog-visible="isStatisticsDetailsDialogVisible"
    :intervention-data="interventionData"
  />
  <VDialog
    v-model="isRedirectionToAttachEquipmentDialogVisible"
    persistent
    class="v-dialog-sm"
  >
    <DialogCloseBtn @click="isRedirectionToAttachEquipmentDialogVisible = !isRedirectionToAttachEquipmentDialogVisible" />

    <VCard title="Confirm Attach Equipment">
      <VCardText>
        Are you sure you want to attach this equipment {{ newEquipmentQrcId }} with this intervention {{ interventionId }} ?
      </VCardText>

      <VCardText class="d-flex justify-end gap-3 flex-wrap">
        <VBtn
          color="secondary"
          variant="tonal"
          @click="isRedirectionToAttachEquipmentDialogVisible = false"
        >
          Cancel
        </VBtn>
        <VBtn
          color="success"
          @click="fetchEquipment(), isRedirectionToAttachEquipmentDialogVisible = false, isAttachEquipmentDialogVisible = true"
        >
          Attach
          <VIcon
            end
            icon="tabler-plus"
          />
        </VBtn>
      </VCardText>
    </VCard>
  </VDialog> 
  <VCard>
    <VRow no-gutters>
      <VCol cols="6">
        <VCardText>
          <h6 class="text-lg text-no-wrap font-weight-medium">
            Add New Equipment! 🎉
          </h6>
          <p class="mb-2">
            by entering equipment data.
          </p>
          <VBtn
            :disabled="isReadOnly"
            @click="isAddNewEquipmentDialogVisible = !isAddNewEquipmentDialogVisible"
          >
            Add Equipment
          </VBtn>
        </VCardText>
      </VCol>
      <VCol cols="6">
        <VCardText>
          <VBtn
            block
            :disabled="isReadOnly"
            @click="isAddNewAreaDialogVisible = !isAddNewAreaDialogVisible"
          >
            Add New Area 
          </VBtn>
        </VCardText>
        <VCardText>
          <VBtn
            block 
            :disabled="isReadOnly"
            @click="isStatisticsDetailsDialogVisible = !isStatisticsDetailsDialogVisible"
          >
            Park Inventory 
          </VBtn>
        </VCardText>
      </VCol>
    </VRow>
  </VCard>
</template>
