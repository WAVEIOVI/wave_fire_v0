
<script setup>
import FireExtinguisherCo2 from '@images/equipment/FireExtinguisherCo2.png'
import FireExtinguisherFoam from '@images/equipment/FireExtinguisherFoam.png'
import FireExtinguisherPowder from '@images/equipment/FireExtinguisherPowder.png'
import FireExtinguisherPowder50 from '@images/equipment/FireExtinguisherPowder50.png'
import FireHose from '@images/equipment/FireHose.png'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  equipmentData: {
    type: Object,
    default: () => ({}),
  },
})

const emit = defineEmits(['update:isDialogVisible', 'submit'])

const currentStep = ref(0)
const localEquipmentData = ref(props.equipmentData)

watch(() => props.equipmentData, newVal => {
  localEquipmentData.value = newVal
}, { immediate: true })

watch(() => props.isDialogVisible, newVal => {
  if (!newVal) currentStep.value = 0
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
}

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
}

const formattedMaintenance = computed(() => {
  if (!localEquipmentData.value?.pivot?.maintenance) return []
  try {
    return JSON.parse(localEquipmentData.value.pivot.maintenance)
  } catch (error) {
    return []
  }
})

const formattedAdditionalMaintenance = computed(() => {
  if (!localEquipmentData.value?.pivot?.additional_maintenance) return []
  try {
    return JSON.parse(localEquipmentData.value.pivot.additional_maintenance)
  } catch (error) {
    return []
  }
})

const formattedSupply = computed(() => {
  if (!localEquipmentData.value?.pivot?.supply) return []
  try {
    return JSON.parse(localEquipmentData.value.pivot.supply)
  } catch (error) {
    return []
  }
})

const formattedAccessory = computed(() => {
  if (!localEquipmentData.value?.pivot?.accessory) return []
  try {
    return JSON.parse(localEquipmentData.value.pivot.accessory)
  } catch (error) {
    return []
  }
})

const getEquipmentImage = (model, category, weight) => {
  if (model === 'powder abc') return FireExtinguisherPowder
  if (model === 'co2') return FireExtinguisherCo2
  if (model === 'water-based' || model === 'foam') return FireExtinguisherFoam
  if (category === 'fire hose') return FireHose
  if (weight === '50') return FireExtinguisherPowder50
  
  return ''
}
</script>

<template>
  <VDialog
    :model-value="isDialogVisible"
    max-width="900"
    persistent
    @update:model-value="dialogVisibleUpdate"
  >
    <DialogCloseBtn
      size="small"
      @click="resetForm"
    />
    <VCard class="create-app-dialog">
      <VCardText class="pa-5 pa-sm-10">
        <h5 class="text-h5 text-center mb-0">
          View Equipment
        </h5>
        <p class="text-sm text-center mb-0">
          View data for this equipment.
        </p>

        <VRow v-if="localEquipmentData">
          <VCol cols="12">
            <h6 class="text-h6 my-4">
              Equipment Details
            </h6>
            <VRow>
              <VCol cols="12">
                <VCard>
                  <VCardItem>
                    <VCardTitle class="d-flex flex-column align-center justify-center">
                      <VAvatar
                        :size="200"
                        :image="getEquipmentImage(localEquipmentData.equipment_model, localEquipmentData.equipment_category, localEquipmentData.equipment_weight_value)"
                      />
                      <p class="mt-4 mb-0">
                        {{ `${localEquipmentData.equipment_category} ${localEquipmentData.equipment_model} ${localEquipmentData.equipment_weight_value} ${localEquipmentData.equipment_weight_unit} ${localEquipmentData.equipment_pressure}` }}
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

            <!-- Inspection & Recharge -->
            <VRow v-if="localEquipmentData.pivot">
              <VCol cols="12">
                <h6 class="text-h6 mb-0">
                  Inspection & Recharge
                </h6>
              </VCol>
              <VCol
                v-if="localEquipmentData.pivot.inspection"
                cols="12"
              >
                <VTextField
                  v-model="localEquipmentData.pivot.inspection"
                  label="Inspection"
                  readonly
                />
              </VCol>
              <VCol
                v-if="localEquipmentData.pivot.raw_recharge"
                cols="12"
              >
                <VTextField
                  v-model="localEquipmentData.pivot.raw_recharge"
                  label="Raw Recharge"
                  readonly
                />
              </VCol>
              <VCol
                v-if="localEquipmentData.pivot.nitrogen_recharge"
                cols="12"
              >
                <VTextField
                  v-model="localEquipmentData.pivot.nitrogen_recharge"
                  label="Nitrogen Recharge"
                  readonly
                />
              </VCol>
            </VRow>

            <!-- Maintenance -->
            <VRow v-if="localEquipmentData.pivot">
              <VCol cols="12">
                <h6 class="text-h6 mb-0">
                  Maintenance
                </h6>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="formattedMaintenance"
                  label="Maintenances"
                  readonly
                />
              </VCol>
              <VCol cols="12">
                <h6 class="text-h6 mb-0">
                  Additional Maintenance
                </h6>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="formattedAdditionalMaintenance"
                  readonly
                />
              </VCol>
            </VRow>

            <!-- Supply -->
            <VRow v-if="localEquipmentData.pivot">
              <VCol cols="12">
                <h6 class="text-h6 mb-0">
                  Supply
                </h6>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="formattedSupply"
                  readonly
                />
              </VCol>
            </VRow>

            <!-- Accessory -->
            
            <VRow v-if="localEquipmentData.pivot">
              <VCol cols="12">
                <h6 class="text-h6 mb-0">
                  Accessory
                </h6>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="formattedAccessory"
                  readonly
                />
              </VCol>
            </VRow>

            <!-- Protection -->
            <VRow v-if="props.equipmentData.equipment_protection_id">
              <VCol cols="12">
                <h6 class="text-h6 mb-0">
                  Protection
                </h6>
              </VCol>
              <VCol cols="4">
                <VTextField
                  v-model="localEquipmentData.pivot.equipment_protection_id"
                  readonly
                />
              </VCol>
              <VCol cols="6">
                <VTextField
                  v-model="localEquipmentData.pivot.equipment_protection_name"
                  readonly
                />
              </VCol>
            </VRow>

            <!-- Equipment Status -->
            <VRow v-if="props.equipmentData.equipment_status">
              <VCol cols="12">
                <h6 class="text-h6 mb-0">
                  Equipment Status
                </h6>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="localEquipmentData.pivot.equipment_status"
                  label="Equipment Status"
                  readonly
                />
              </VCol>
            </VRow>

            <div class="d-flex justify-space-between mt-8">
              <VBtn
                color="success"
                type="submit"
                @click="onFormSubmit"
              >
                Done
                <VIcon
                  icon="tabler-check"
                  end
                  class="flip-in-rtl"
                />
              </VBtn>
            </div>
          </VCol>
        </VRow>
        <VRow v-else>
          <VCol cols="12">
            <p class="text-center">
              No equipment data available.
            </p>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>

<style scoped>
.stepper-content .card-list {
  --v-card-list-gap: 24px;
}
</style>
