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
  equipmentData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['update:isDialogVisible', 'submit'])

// Stores
const equipmentParamsStore = useEquipmentParamsStore()

// Reactive References
const currentStep = ref(0)
const refVForm = ref()
const protection = ref('')
const localInterventionData = ref(props.interventionData)
const localEquipmentData = ref(props.equipmentData)
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

watch(() => props.equipmentData, newVal => {
  localEquipmentData.value = newVal
}, { immediate: true })

watch(
  () => protection.value,
  newValue => {
    if (newValue) {
      fetchProtectionData()
    }
  },
)

watchEffect(() => {
  localInterventionData.value = props.interventionData
  localEquipmentData.value = props.equipmentData
  if (localEquipmentData.value.model_id) {
    fetchModel(localEquipmentData.value.model_id)
  }
})

// Methods
const resetForm = () => {
  protection.value = null
  emit('update:isDialogVisible', false)
}

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', localEquipmentData.value)
  protection.value = null
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
    localEquipmentData.value.pivot.equipment_protection_id = protectionData.value.protection_id
    localEquipmentData.value.pivot.equipment_protection_name = protectionData.value.name
  } catch (error) {
    console.error(error)
  }
}

// Getter function for formattedMaintenance
const formattedMaintenance = computed({
  get() {
    try {
      return JSON.parse(localEquipmentData.value.pivot.maintenance)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedMaintenance
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localEquipmentData.value.pivot.maintenance = JSON.stringify(value)
  },
})

// Getter function for formattedAdditionalMaintenance
const formattedAdditionalMaintenance = computed({
  get() {
    try {
      return JSON.parse(localEquipmentData.value.pivot.additional_maintenance)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedAdditionalMaintenance
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localEquipmentData.value.pivot.additional_maintenance = JSON.stringify(value)
  },
})

// Getter function for formattedSupply
const formattedSupply = computed({
  get() {
    try {
      return JSON.parse(localEquipmentData.value.pivot.supply)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedSupply
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localEquipmentData.value.pivot.supply = JSON.stringify(value)
  },
})

// Getter function for formattedSupply
const formattedAccessory = computed({
  get() {
    try {
      return JSON.parse(localEquipmentData.value.pivot.accessory)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedSupply
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localEquipmentData.value.pivot.accessory = JSON.stringify(value)
  },
})

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
    title: 'Inspected',
    value: 'inspected',
  },
  {
    title: 'Not Inspected',
    value: null,
  },
]

const rawRechargeOptions = [
  {
    title: 'Raw Charged',
    value: 'raw charged',
  },
  {
    title: 'Not Charged',
    value: null,
  },
]

const nitrogenRechargeOptions = [
  {
    title: 'Nitrogen Charged',
    value: 'nitrogen charged',
  },
  {
    title: 'Not Charged',
    value: null,
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
    persistent  
    @update:model-value="dialogVisibleUpdate"
  >
    <!-- 👉 dialog close btn -->
    <DialogCloseBtn
      size="small"
      @click="resetForm"
    />
    <VCard class="create-app-dialog">
      <VCardText class="pa-5 pa-sm-10">
        <h5 class="text-h5 text-center mb-2">
          Edit A Equipment
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to edit a equipment.
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
                              v-if="localEquipmentData.equipment_model === 'powder abc'"
                              size="200"
                              :image="FireExtinguisherPowder"
                            />
                            <VAvatar
                              v-if="localEquipmentData.equipment_model === 'co2'"
                              size="200"
                              :image="FireExtinguisherCo2"
                            />
                            <VAvatar
                              v-if="localEquipmentData.equipment_model === 'water-based' || localEquipmentData.equipment_model === 'foam'"
                              size="200"
                              :image="FireExtinguisherFoam"
                            />
                            <VAvatar
                              v-if="localEquipmentData.equipment_category === 'fire hose'"
                              size="200"
                              :image="FireHose"
                            />
                            <VAvatar
                              v-if="localEquipmentData.equipment_weight_value === '50'"
                              size="200"
                              :image="FireExtinguisherPowder50"
                            />
                            
                            <p class="mt-4 mb-0">
                              {{ localEquipmentData.equipment_category }} {{ localEquipmentData.equipment_model }} {{ localEquipmentData.equipment_weight_value }} {{ localEquipmentData.equipment_weight_unit }} {{ localEquipmentData.equipment_pressure }}
                            </p>
                            <span class="text-body-1">{{ localEquipmentData.equipment_status }}</span>

                            <div class="d-flex align-center flex-wrap gap-2 mt-2">
                              <VChip
                                label
                                size="small"
                              >
                                {{ localEquipmentData.qrc_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ localEquipmentData.internal_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ localEquipmentData.serial_number }}
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
                      cols="12"
                    > 
                      <VSelect
                        v-model="localEquipmentData.pivot.inspection"
                        placeholder="Edit Inspection Status"
                        label="Inspection"
                        :items="inspectionOptions"
                        clearable
                        clear-icon="tabler-x"
                      />  
                    </VCol>
                    <VCol
                      v-if="ifRawRecharge"
                      cols="12"
                    >
                      <VSelect
                        v-model="localEquipmentData.pivot.raw_recharge"
                        label="Raw Recharge"
                        placeholder="Edit Raw Recharge Status"
                        :items="rawRechargeOptions"
                        clearable
                        clear-icon="tabler-x"
                      />
                    </VCol>
                    <VCol
                      v-if="ifNitrogenRecharge"
                      cols="12"
                    >
                      <VSelect
                        v-model="localEquipmentData.pivot.nitrogen_recharge"
                        label="Nitrogen Recharge"
                        placeholder="Edit Nitrogen Recharge Status"
                        :items="nitrogenRechargeOptions"
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
                      <h6 class="text-h6 mb-0">
                        Maintenances
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <AppSelect
                        v-model="formattedMaintenance"
                        label="Edit Basic Maintenance"
                        item-title="title"
                        :items="modelMaintenancesOptions"
                        multiple
                        clearable
                        clear-icon="tabler-x"
                      >
                        <template #selection="{ item }">
                          <VChip>
                            <span>{{ item.title }}</span>
                          </VChip>
                        </template>
                      </AppSelect>
                    </VCol>
                    <VCol 
                      v-if="modelAdditionalMaintenanceOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-0">
                        Additional Maintenance
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <AppSelect
                        v-model="formattedAdditionalMaintenance"
                        label="Edit Additional Maintenance"
                        item-title="title"
                        :items="modelAdditionalMaintenanceOptions"
                        multiple
                        clearable
                        clear-icon="tabler-x"
                      >
                        <template #selection="{ item }">
                          <VChip>
                            <span>{{ item.title }}</span>
                          </VChip>
                        </template>
                      </AppSelect>
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
                      <h6 class="text-h6 mb-0">
                        Supply
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <AppSelect
                        v-model="formattedSupply"
                        label="Edit Supplies"
                        item-title="title"
                        :items="modelSuppliesOptions"
                        multiple
                        clearable
                        clear-icon="tabler-x"
                      >
                        <template #selection="{ item }">
                          <VChip>
                            <span>{{ item.title }}</span>
                          </VChip>
                        </template>
                      </AppSelect>
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
                        Accessories 
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <AppSelect
                        v-model="formattedAccessory"
                        label="Edit Accessory"
                        item-title="title"
                        :items="modelAccessoriesOptions"
                        multiple
                        clearable
                        clear-icon="tabler-x"
                      >
                        <template #selection="{ item }">
                          <VChip>
                            <span>{{ item.title }}</span>
                          </VChip>
                        </template>
                      </AppSelect>
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
                        :grid-column="{ sm: '3', cols: '4' }"
                        @input="fetchProtectionData"
                      />
                    </VCol>
                    <VDivider />
                    <VCol cols="4">
                      <VTextField 
                        v-model="localEquipmentData.pivot.equipment_protection_id"
                        label="Protection ID"
                        readonly
                      />
                    </VCol> 
                    <VCol cols="6">
                      <VTextField 
                        v-model="localEquipmentData.pivot.equipment_protection_name"
                        label="Equipment Protection"
                        readonly
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <h6 class="text-h6 mb-4">
                    Select Equipment's Status
                  </h6>
                  <CustomRadiosWithIcon
                    v-model:selected-radio="localEquipmentData.pivot.equipment_status"
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
