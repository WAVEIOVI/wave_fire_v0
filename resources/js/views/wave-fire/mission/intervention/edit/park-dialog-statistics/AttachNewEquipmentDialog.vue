<script setup>
import { useEquipmentParamsStore } from '@/views/config/inventory/useEquipmentParamsStore'
import FireExtinguisherCo2 from '@images/equipment/FireExtinguisherCo2.png'
import FireExtinguisherFoam from '@images/equipment/FireExtinguisherFoam.png'
import FireExtinguisherPowder from '@images/equipment/FireExtinguisherPowder.png'
import FireExtinguisherPowder50 from '@images/equipment/FireExtinguisherPowder50.png'
import FireHose from '@images/equipment/FireHose.png'

// Props and Emits
const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  interventionData: {
    type: Array,
    required: true,
  },
  equipmentFetched: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits(['update:isDialogVisible', 'submit'])

// Stores
const equipmentParamsStore = useEquipmentParamsStore()

// Reactive References
const currentStep = ref(0)
const refVForm = ref()
const inspection = ref([])
const rawRecharge = ref([])
const nitrogenRecharge = ref([])
const maintenance = ref([])
const additionalMaintenance = ref([])
const supply = ref([])
const accessory = ref([])
const equipmentStatus = ref('')
const protection = ref('')
const equipmentProtectionId = ref()
const equipmentProtectionName = ref()
const localInterventionData = ref(props.interventionData)
const localEquipmentFetched = ref(props.equipmentFetched)
const fetchedModelData = ref([])
const modelMaintenancesOptions = ref([])
const modelAdditionalMaintenanceOptions = ref([])
const modelSuppliesOptions = ref([])
const modelAccessoriesOptions = ref([])
const modelProtectionsOptions = ref([])
const protectionData = ref({ protection_id: '', name: '' })

const errors = ref({
  qrc: '',
  category: '',
  model: '',
  area: '',
  status: '',
  weight: '',
  pressure: '',
})

// Computed Properties
const ifInspection = computed({
  get: () => !!fetchedModelData.value.inspection,
  set: value => { fetchedModelData.value.inspection = value ? 1 : 0 },
})

const ifRawRecharge = computed({
  get: () => !!fetchedModelData.value.raw_recharge,
  set: value => { fetchedModelData.value.raw_recharge = value ? 1 : 0 },
})

const ifNitrogenRecharge = computed({
  get: () => !!fetchedModelData.value.nitrogen_recharge,
  set: value => { fetchedModelData.value.nitrogen_recharge = value ? 1 : 0 },
})

// Watchers
watch(props, () => {
  if (!props.isDialogVisible) currentStep.value = 0
})

watch(() => props.equipmentFetched, newVal => {
  localEquipmentFetched.value = newVal
}, { immediate: true })

watchEffect(() => {
  localInterventionData.value = props.interventionData
  localEquipmentFetched.value = props.equipmentFetched
  if (localEquipmentFetched.value.model_id) {
    fetchModel(localEquipmentFetched.value.model_id)
  }
})

// Methods
const resetForm = () => {
  emit('update:isDialogVisible', false)
  inspection.value = []
  rawRecharge.value = []
  nitrogenRecharge.value = []
  maintenance.value = []
  additionalMaintenance.value = []
  supply.value = []
  accessory.value = []
  modelMaintenancesOptions.value = [] // Clearing modelOptions
  modelAdditionalMaintenanceOptions.value = [] // Clearing modelAdditionalMaintenanceOptions
  modelSuppliesOptions.value = [] // Clearing modelSuppliesOptions
  modelAccessoriesOptions.value = [] // Clearing modelAccessoriesOptions
  modelProtectionsOptions.value = [] // Clearing modelProtectionsOptions
  protection.value = null
  equipmentStatus.value = null
  localEquipmentFetched.value = {
    area_id: '',
    equipment_category: '',
    equipment_model: '',
    equipment_weight_unit: '',
    equipment_weight_value: '',
    equipment_pressure: '',
    internal_id: '',
    serial_number: '',
    equipment_status: '',
  }
}

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

const onFormSubmit = () => {
  const formattedData = {
    resources: {
      [localEquipmentFetched.value.id]: {
        inspection: inspection.value.length > 0 ? inspection.value[0] : null,
        raw_recharge: rawRecharge.value.length > 0 ? rawRecharge.value[0] : null,
        nitrogen_recharge: nitrogenRecharge.value.length > 0 ? nitrogenRecharge.value[0] : null,
        maintenance: maintenance.value,
        additional_maintenance: additionalMaintenance.value,
        supply: supply.value,
        accessory: accessory.value,
        equipment_protection_id: equipmentProtectionId.value,
        equipment_protection_name: equipmentProtectionName.value,
        equipment_status: equipmentStatus.value,
      },
    },
  }

  emit('submit', formattedData)
  resetForm()
}

// Fetching data
const fetchModel = async id => {
  try {
    const response = await equipmentParamsStore.fetchModel(id)

    fetchedModelData.value = response.data.data
    fetchModelOptionsData()
  } catch (error) {
    console.error(error)
  }
}

const fetchModelOptionsData = async () => {
  if (!fetchedModelData.value.model_id) return

  try {
    const [maintenances, additionalMaintenances, supplies, accessories, protections] = await Promise.all([
      equipmentParamsStore.fetchModelMaintenances(fetchedModelData.value.id),
      equipmentParamsStore.fetchModelAdditionalMaintenances(fetchedModelData.value.id),
      equipmentParamsStore.fetchModelSupplies(fetchedModelData.value.id),
      equipmentParamsStore.fetchModelAccessories(fetchedModelData.value.id),
      equipmentParamsStore.fetchModelProtections(fetchedModelData.value.id),
    ])

    modelMaintenancesOptions.value = maintenances.data.data.map(maintenance => ({
      title: maintenance.name,
      value: maintenance.name,
      subtitle: maintenance.maintenance_id,
      desc: maintenance.description,
    }))

    modelAdditionalMaintenanceOptions.value = additionalMaintenances.data.data.map(addMaintenance => ({
      title: addMaintenance.name,
      value: addMaintenance.name,
      subtitle: addMaintenance.additional_maintenance_id,
      desc: addMaintenance.description,
    }))

    modelSuppliesOptions.value = supplies.data.data.map(supply => ({
      title: supply.name,
      icon: { icon: 'tabler-tools', size: '28' },
      value: supply.name,
      desc: supply.description,
    }))

    modelAccessoriesOptions.value = accessories.data.data.map(accessory => ({
      value: accessory.name,
      title: accessory.name,
      icon: { icon: 'tabler-box', size: '28' },
      desc: accessory.description,
    }))

    modelProtectionsOptions.value = protections.data.data.map(protection => ({
      value: protection.id,
      title: protection.name,
      icon: { icon: 'tabler-shield', size: '28' },
      desc: protection.description || '',
    }))
  } catch (error) {
    console.error(error)
  }
}

// Fetch Protection Data
const fetchProtectionData = async () => {
  if (!protection.value) return

  try {
    const response = await equipmentParamsStore.fetchProtection(protection.value)

    protectionData.value = response.data.data
    equipmentProtectionId.value = protectionData.value.protection_id
    equipmentProtectionName.value = protectionData.value.name
  } catch (error) {
    console.error(error)
  }
}


// Constants
const createApp = [
  { icon: 'tabler-fire-extinguisher', title: 'Equipment' },
  { icon: 'tabler-adjustments-check', title: 'Inspection' },
  { icon: 'tabler-tool', title: 'Maintenance' },
  { icon: 'tabler-shopping-cart-check', title: 'Supply' },
  { icon: 'tabler-shopping-cart-plus', title: 'Accessories' },
  { icon: 'tabler-check', title: 'Status' },
]

const inspectionOptions = [
  {
    title: 'Inspection',
    value: 'inspected',
    icon: { icon: 'tabler-zoom-check', size: '28' },
  },
]

const rawRechargeOptions = [
  {
    title: 'Raw Refill',
    value: 'raw charged',
    icon: { icon: 'tabler-battery-3', size: '28' },
  },
]

const nitrogenRechargeOptions = [
  {
    title: 'Nitrogen Refill',
    value: 'nitrogen charged',
    icon: { icon: 'tabler-filter-down', size: '28' },
  },
]

const status = [
  { title: 'In Service', value: 'in service', icon: { icon: 'tabler-check', size: '28' } },
  { title: 'Limited Use', value: 'limited use', icon: { icon: 'tabler-eye-check', size: '28' } },
  { title: 'Out Of Order', value: 'out of order', icon: { icon: 'tabler-hotel-service', size: '28' } },
  { title: 'Workshop', value: 'workshop', icon: { icon: 'tabler-building-factory-2', size: '28' } },
]
</script>

<template>
  <VDialog
    :model-value="props.isDialogVisible"
    max-width="900"
    @update:model-value="dialogVisibleUpdate"
  >
    <!-- 👉 dialog close btn -->
    <DialogCloseBtn
      size="small"
      @click="emit('update:isDialogVisible', false)"
    />
    <VCard class="create-app-dialog">
      <VCardText class="pa-5 pa-sm-10">
        <h5 class="text-h5 text-center mb-2">
          Attach A Equipment
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to attach a equipment.
        </p>

        <VRow>
          <VCol
            cols="12"
            sm="5"
            md="4"
            lg="3"
          >
            <AppStepper
              v-model:current-step="currentStep"
              direction="vertical"
              :items="createApp"
              icon-size="24"
              class="stepper-icon-step-bg"
            />
          </VCol>

          <VCol
            cols="12"
            sm="7"
            md="8"
            lg="9"
          >
            <VForm
              class="mt-4"
              @submit.prevent="onFormSubmit"
            >
              <VWindow
                v-model="currentStep"
                class="disable-tab-transition stepper-content"
              >
                <!-- 👉 Equipment -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Equipment's Details
                  </h6>
                  <VRow>
                    <VCol cols="12">
                      <VCard>
                        <VCardItem>
                          <VCardTitle class="d-flex flex-column align-center justify-center">
                            <VAvatar
                              v-if="localEquipmentFetched.equipment_model === 'powder abc'"
                              size="200"
                              :image="FireExtinguisherPowder"
                            />
                            <VAvatar
                              v-if="localEquipmentFetched.equipment_model === 'co2'"
                              size="200"
                              :image="FireExtinguisherCo2"
                            />
                            <VAvatar
                              v-if="localEquipmentFetched.equipment_model === 'water-based' || localEquipmentFetched.equipment_model === 'foam'"
                              size="200"
                              :image="FireExtinguisherFoam"
                            />
                            <VAvatar
                              v-if="localEquipmentFetched.equipment_category === 'fire hose'"
                              size="200"
                              :image="FireHose"
                            />
                            <VAvatar
                              v-if="localEquipmentFetched.equipment_weight_value === '50'"
                              size="200"
                              :image="FireExtinguisherPowder50"
                            />
                            
                            <p class="mt-4 mb-0">
                              {{ localEquipmentFetched.equipment_category }} {{ localEquipmentFetched.equipment_model }} {{ localEquipmentFetched.equipment_weight_value }} {{ localEquipmentFetched.equipment_weight_unit }} {{ localEquipmentFetched.equipment_pressure }}
                            </p>
                            <span class="text-body-1">{{ localEquipmentFetched.equipment_status }}</span>

                            <div class="d-flex align-center flex-wrap gap-2 mt-2">
                              <VChip
                                label
                                size="small"
                              >
                                {{ localEquipmentFetched.qrc_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ localEquipmentFetched.internal_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ localEquipmentFetched.serial_number }}
                              </VChip>
                            </div>
                          </VCardTitle>
                        </VCardItem>
                      </VCard>
                    </VCol>
                  </VRow>
                </VWindowItem>

                <!-- 👉 Inspection & Recharge -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Inspection & Recharge
                      </h6>
                    </VCol>
                    <VCol
                      v-if="ifInspection"
                      md="4"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="inspection"
                        :checkbox-content="inspectionOptions"
                      />
                    </VCol>
                    <VCol
                      v-if="ifRawRecharge"
                      md="4"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="rawRecharge"
                        :checkbox-content="rawRechargeOptions"
                      />
                    </VCol>
                    <VCol
                      v-if="ifNitrogenRecharge"
                      md="4"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="nitrogenRecharge"
                        :checkbox-content="nitrogenRechargeOptions"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>

                <!-- 👉 Maintenance -->
                <VWindowItem>
                  <VRow>
                    <VCol
                      v-if="modelMaintenancesOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-4">
                        Maintenance
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomCheckboxes
                        v-model:selected-checkbox="maintenance"
                        :checkbox-content="modelMaintenancesOptions"
                        :grid-column="{ cols: '12' }"
                      />
                    </VCol>
                    <VCol 
                      v-if="modelAdditionalMaintenanceOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-4">
                        Additional Maintenance
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomCheckboxes
                        v-model:selected-checkbox="additionalMaintenance"
                        :checkbox-content="modelAdditionalMaintenanceOptions"
                        :grid-column="{ cols: '12' }"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <!-- 👉 Supply  -->
                <VWindowItem>
                  <VRow>
                    <VCol
                      v-if="modelSuppliesOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-4">
                        Select Supply
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="supply"
                        :checkbox-content="modelSuppliesOptions"
                        :grid-column="{ sm: '6', cols: '12' }"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VRow>
                    <VCol
                      v-if="modelAccessoriesOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-4">
                        Select Accessories 
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="accessory"
                        :checkbox-content="modelAccessoriesOptions"
                        :grid-column="{ sm: '3', cols: '12' }"
                      />
                    </VCol>
                    <VCol
                      v-if="modelProtectionsOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-4">
                        Select Protection
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomRadiosWithIcon
                        v-model:selected-radio="protection"
                        :radio-content="modelProtectionsOptions"
                        :grid-column="{ sm: '4', cols: '12' }"
                        @input="fetchProtectionData"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <h6 class="text-h6 mb-4">
                    Select Equipment's Status
                  </h6>
                  <CustomRadiosWithIcon
                    v-model:selected-radio="equipmentStatus"
                    :radio-content="status"
                    :grid-column="{ sm: '3', cols: '12' }"
                  />
                </VWindowItem>
              </VWindow>
            </VForm>

            <div class="d-flex justify-space-between mt-8">
              <VBtn
                variant="tonal"
                color="secondary"
                :disabled="currentStep === 0"
                @click="currentStep--"
              >
                <VIcon
                  icon="tabler-arrow-left"
                  start
                  class="flip-in-rtl"
                />
                Previous
              </VBtn>

              <VBtn
                v-if="createApp.length - 1 === currentStep"
                color="success"
                type="submit"
                @click="onFormSubmit"
              >
                submit
                <VIcon
                  icon="tabler-check"
                  end
                  class="flip-in-rtl"
                />
              </VBtn>

              <VBtn
                v-else
                @click="currentStep++"
              >
                Next

                <VIcon
                  icon="tabler-arrow-right"
                  end
                  class="flip-in-rtl"
                />
              </VBtn>
            </div>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>

<style lang="scss">
.stepper-content .card-list {
  --v-card-list-gap: 24px;
}
</style>
