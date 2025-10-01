<script setup>
import congoImg from '@images/illustrations/laptop-girl.png'
import { useInterventionListStore } from '../../useInterventionListStore'
import AttachEquipmentDialog from './AttachEquipmentDialog.vue'

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

const isAttachEquipmentDialogVisible = ref(false)
</script>

<template>
  <AttachEquipmentDialog
    v-model:is-dialog-visible="isAttachEquipmentDialogVisible"
    :intervention-data="interventionData"
    @submit="attachEquipment"
  />
  <VCard>
    <VRow no-gutters>
      <VCol cols="8">
        <VCardText>
          <h6 class="text-lg text-no-wrap font-weight-medium">
            Search for equipment! 🎉
          </h6>
          <p class="mb-2">
            by entering keywords or scan a QR code.
          </p>
          <VBtn
            :disabled="isReadOnly"
            @click="isAttachEquipmentDialogVisible = !isAttachEquipmentDialogVisible"
          >
            Attach Equipment 
          </VBtn>
        </VCardText>
      </VCol>

      <VCol cols="4">
        <VCardText class="pb-0 px-0 position-relative h-100">
          <VImg
            :src="congoImg"
            height="150"
            class="congo-john-img w-100"
          />
        </VCardText>
      </VCol>
    </VRow>
  </VCard>
</template>

<style lang="scss" scoped>
.congo-john-img {
  position: absolute;
  inset-block-end: 0;
  inset-inline-end: 1.25rem;
}
</style>
