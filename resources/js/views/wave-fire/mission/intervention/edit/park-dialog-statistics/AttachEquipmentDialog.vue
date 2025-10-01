<script setup>
import { useEquipmentParamsStore } from '@/views/config/inventory/useEquipmentParamsStore'
import FireExtinguisherCo2 from '@images/equipment/FireExtinguisherCo2.png'
import FireExtinguisherFoam from '@images/equipment/FireExtinguisherFoam.png'
import FireExtinguisherPowder from '@images/equipment/FireExtinguisherPowder.png'
import FireExtinguisherPowder50 from '@images/equipment/FireExtinguisherPowder50.png'
import FireHose from '@images/equipment/FireHose.png'
import { StreamBarcodeReader } from "vue-barcode-reader"
import { useInterventionListStore } from '../../useInterventionListStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  interventionData: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const currentStep = ref(0)

const createApp = [
  {
    icon: 'tabler-search',
    title: 'Search Mode',
  },
  {
    icon: 'tabler-fire-extinguisher',
    title: 'Equipment',
  },
  {
    icon: 'tabler-adjustments-check',
    title: 'Inspection',
  },
  {
    icon: 'tabler-tool',
    title: 'Maintenance',
  },
  {
    icon: 'tabler-shopping-cart-check',
    title: 'Supply',
  },
  
  {
    icon: 'tabler-shopping-cart-plus',
    title: 'Accessories',
  },
  {
    icon: 'tabler-check',
    title: 'Status',
  },
]

const searchMethods = [
  {
    title: 'QR Code Search',
    value: 'qr_code_search',
    icon: {
      icon: 'tabler-scan',
      size: '28',
    },
  },
  {
    title: 'Simple Search',
    value: 'simple_search',
    icon: {
      icon: 'tabler-eye-search',
      size: '28',
    },
  },
]

const ifInspection = computed({
  get() {
    return !!fetchedModelData.value.inspection
  },
  set(value) {
    fetchedModelData.value.inspection = value ? 1 : 0
  },
})

const ifRawRecharge = computed({
  get() {
    return !!fetchedModelData.value.raw_recharge
  },
  set(value) {
    fetchedModelData.value.raw_recharge = value ? 1 : 0
  },
})

const ifNitrogenRecharge = computed({
  get() {
    return !!fetchedModelData.value.nitrogen_recharge
  },
  set(value) {
    fetchedModelData.value.nitrogen_recharge = value ? 1 : 0
  },
})

const inspection = ref([])
const rawRecharge = ref([])
const nitrogenRecharge = ref([])
const maintenance = ref([])
const additionalMaintenance = ref([])
const supply = ref([])
const accessory = ref([])
const protection = ref([])
const equipmentProtectionId = ref()
const equipmentProtectionName = ref()
const equipmentStatus = ref([])
const interventionListStore = useInterventionListStore()
const equipmentParamsStore = useEquipmentParamsStore()
const localInterventionData = ref((props.interventionData))
const parkId = localInterventionData.value.park
const searchQuery = ref('')
const equipments = ref([])
const searchMode = ref('')
const equipmentFetched = ref('')
const fetchedModelData = ref([])

const equipmentData = ref({
  resources: {},
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  searchQuery.value = null
  equipmentFetched.value = {
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

  // standardSign.value = []
  // pictogram.value = []
  // numbering.value = []
  // equipmentFixation.value = []

  // Reset the form fields used in onFormSubmit
  inspection.value = []
  rawRecharge.value = []
  nitrogenRecharge.value = []
  maintenance.value = null
  additionalMaintenance.value = null
  supply.value = null
  accessory.value = null
  protection.value = null
  equipmentStatus.value = null
}

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

watch(props, () => {
  if (!props.isDialogVisible)
    currentStep.value = 0
})

const onFormSubmit = () => {
  const formattedData = {
    resources: {
      [searchQuery.value]: {
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

const inspectionOptions = [
  {
    title: 'Inspection',
    value: 'inspected',
    icon: {
      icon: 'tabler-zoom-check',
      size: '28',
    },
  },
]

const rawRechargeOptions = [
  {
    title: 'Raw Refill',
    value: 'raw charged',
    icon: {
      icon: 'tabler-battery-3',
      size: '28',
    },
  },
]

const nitrogenRechargeOptions = [
  {
    title: 'Nitrogen Refill',
    value: 'nitrogen charged',
    icon: {
      icon: 'tabler-filter-down',
      size: '28',
    },
  },
]

const status = [
  {
    title: 'In Service',
    value: 'in service',
    icon: {
      icon: 'tabler-check',
      size: '28',
    },
  },
  {
    title: 'Limited Use',
    value: 'limited use',
    icon: {
      icon: 'tabler-eye-check',
      size: '28',
    },
  },
  {
    title: 'Out Of Order',
    value: 'out of order',
    icon: {
      icon: 'tabler-hotel-service',
      size: '28',
    },
  },
  {
    title: 'Workshop',
    value: 'workshop',
    icon: {
      icon: 'tabler-building-factory-2',
      size: '28',
    },
  },
]

onMounted(() => {
  //  Fetching equipments
  interventionListStore.fetchParkEquipments({
    id: parkId,
    search: searchQuery.value,
  }).then(response => {
    equipments.value = response.data.data.map(equipment => ({ ...equipment }))
    console.log(equipments.value)
  }).catch(error => {
    console.error(error)
  })
})

const fetchEquipment = () => {
  if (!searchQuery.value) return
  interventionListStore.fetchEquipment(searchQuery.value)
    .then(response => {
      equipmentFetched.value = response.data.data
      console.log(equipmentFetched.value)
      fetchModel()
    }).catch(error => {
      console.error(error)
    })
}

const fetchModel = id => {
  equipmentParamsStore.fetchModel(equipmentFetched.value.model_id)
    .then(response => {
      fetchedModelData.value = response.data.data
      console.log(fetchedModelData.value)
      fetchModelMaintenancesOptions()
      fetchModelAdditionalMaintenanceOptions()
      fetchModelSuppliesOptions()
      fetchModelAccessoriesOptions()
      fetchModelProtectionsOptions()
    }).catch(error => {
      console.error(error)
    })
}

const modelMaintenancesOptions = ref([])
const modelAdditionalMaintenanceOptions = ref([])
const modelSuppliesOptions = ref([])
const modelAccessoriesOptions = ref([])
const modelProtectionsOptions = ref([])

const fetchModelMaintenancesOptions = () => {
  if (!equipmentFetched.value.model_id) return
  equipmentParamsStore
    .fetchModelMaintenances(equipmentFetched.value.model_id)
    .then(response => {
      modelMaintenancesOptions.value = response.data.data.map(maintenance => ({
        title: maintenance.name,
        value: maintenance.name,
        subtitle: maintenance.maintenance_id,
        desc: maintenance.description,
      }))
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchModelAdditionalMaintenanceOptions = () => {
  if (!equipmentFetched.value.model_id) return
  equipmentParamsStore
    .fetchModelAdditionalMaintenances(equipmentFetched.value.model_id)
    .then(response => {
      modelAdditionalMaintenanceOptions.value = response.data.data.map(addMaintenance => ({
        title: addMaintenance.name,
        value: addMaintenance.name,
        subtitle: addMaintenance.additional_maintenance_id,
        desc: addMaintenance.description,
      })) 
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchModelSuppliesOptions = () => {
  if (!equipmentFetched.value.model_id) return
  equipmentParamsStore
    .fetchModelSupplies(equipmentFetched.value.model_id)
    .then(response => {
      modelSuppliesOptions.value = response.data.data.map(supply => ({
        title: supply.name,
        icon: { icon: 'tabler-tools', size: '28' },
        value: supply.name,
        desc: supply.description,
      })) 
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchModelAccessoriesOptions = () => {
  if (!equipmentFetched.value.model_id) return
  equipmentParamsStore
    .fetchModelAccessories(equipmentFetched.value.model_id)
    .then(response => {
      modelAccessoriesOptions.value = response.data.data.map(accessory => ({
        value: accessory.name,
        title: accessory.name,
        icon: { icon: 'tabler-box', size: '28' },
        desc: accessory.description,
      })) 
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchModelProtectionsOptions = () => {
  if (!equipmentFetched.value.model_id) return
  equipmentParamsStore
    .fetchModelProtections(equipmentFetched.value.model_id)
    .then(response => {
      modelProtectionsOptions.value = response.data.data.map(protection => ({
        value: protection.id,
        title: protection.name,
        icon: { icon: 'tabler-shield', size: '28' },
        desc: protection.description || '',
      })) 
    })
    .catch(error => { 
      console.error(error)
    })
}

const protectionData = ref({
  protection_id: '',
  name: '',
})

// 👉 fetch Protection
const fetchProtectionData = () => {
  if (!protection.value) return
  equipmentParamsStore.fetchProtection(protection.value)
    .then(response => {
      protectionData.value = response.data.data
      equipmentProtectionId.value = protectionData.value.protection_id
      equipmentProtectionName.value = protectionData.value.name
    }).catch(error => {
      console.error(error)
    })
}

watch(
  () => searchQuery.value,
  fetchEquipment,
)

const onDecode = text => {
  console.log(`Decoded text from QR code: ${text}`)
  searchQuery.value = text // Set the decoded text to the variable
}

const onLoaded = () => {
  console.log("Ready to start scanning barcodes")

  // Perform any initialization tasks
}
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
                <!-- 👉 Search Mode -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Select Search Mode
                  </h6>
                  <VCol cols="12">
                    <CustomRadiosWithIcon
                      v-model:selected-radio="searchMode"
                      :radio-content="searchMethods"
                      :grid-column="{ sm: '6', cols: '12' }"
                    />
                  </VCol>
                  <VCol
                    v-if="searchMode === 'qr_code_search'"
                    cols="12"
                  >
                    <StreamBarcodeReader
                      @decode="onDecode"
                      @loaded="onLoaded"
                    />
                    <div v-if="searchQuery">
                      <AppAutocomplete
                        v-model="searchQuery"
                        :items="equipments"
                        clearable
                        :item-title="item => item.qrc_id"
                        item-value="id"
                        clear-icon="tabler-x"
                        s@input="fetchEquipment"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.equipment_category + ' - ' + item.raw.equipment_model + ' - ' + item.raw.equipment_weight_value + item.raw.equipment_weight_unit + ' - ' + item.raw.equipment_pressure"
                          />
                        </template>
                      </AppAutocomplete>
                    </div>
                  </VCol>
                  <VCol
                    v-if="searchMode === 'simple_search'"
                    cols="12"
                  >
                    <h6 class="text-h6 my-4">
                      Select Equipment
                    </h6>
                    <AppAutocomplete
                      v-model="searchQuery"
                      :items="equipments"
                      clearable
                      :item-title="item => item.qrc_id"
                      item-value="id"
                      clear-icon="tabler-x"
                      @input="fetchEquipment"
                    >
                      <template #item="{ props: itemProps, item }">  
                        <VListItem
                          v-bind="itemProps"
                          :subtitle="item.raw.equipment_category + ' - ' + item.raw.equipment_model + ' - ' + item.raw.equipment_weight_value + item.raw.equipment_weight_unit"
                        />
                      </template>
                    </AppAutocomplete>
                  </VCol>
                </VWindowItem>
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
                              v-if="equipmentFetched.equipment_model === 'powder abc'"
                              size="200"
                              :image="FireExtinguisherPowder"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_model === 'co2'"
                              size="200"
                              :image="FireExtinguisherCo2"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_model === 'water-based' || equipmentFetched.equipment_model === 'foam'"
                              size="200"
                              :image="FireExtinguisherFoam"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_category === 'fire hose'"
                              size="200"
                              :image="FireHose"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_weight_value === '50'"
                              size="200"
                              :image="FireExtinguisherPowder50"
                            />
                            
                            <p class="mt-4 mb-0">
                              {{ equipmentFetched.equipment_category }} {{ equipmentFetched.equipment_model }} {{ equipmentFetched.equipment_weight_value }} {{ equipmentFetched.equipment_weight_unit }} {{ equipmentFetched.equipment_pressure }}
                            </p>
                            <span class="text-body-1">{{ equipmentFetched.equipment_status }}</span>

                            <div class="d-flex align-center flex-wrap gap-2 mt-2">
                              <VChip
                                label
                                size="small"
                              >
                                {{ equipmentFetched.qrc_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ equipmentFetched.internal_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ equipmentFetched.serial_number }}
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
