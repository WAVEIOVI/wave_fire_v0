<script setup>
import girlUsingMobile from '@images/pages/girl-using-mobile.png'
import ComplianceDialog from './ComplianceDialog.vue'
import HazardDialog from './HazardDialog.vue'
import RecommendationDialog from './RecommendationDialog.vue'
import ServiceDialog from './ServiceDialog.vue'
import StandardReferencedDialog from './StandardReferencedDialog.vue'
import SuggestionDialog from './SuggestionDialog.vue'

const isAddStandardReferencedDialogVisible = ref(false)
const isAddRecommendationDialogVisible = ref(false)
const isAddComplianceDialogVisible = ref(false)
const isAddServiceDialogVisible = ref(false)
const isAddHazardDialogVisible = ref(false)
const isAddSuggestionDialogVisible = ref(false)

// 👉 Headers
const standardHeaders = [
  {
    title: 'standard id',
    key: 'standard_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'version',
    key: 'version',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const serviceHeaders = [
  {
    title: 'service id',
    key: 'service_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const recommendationHeaders = [
  {
    title: 'recommendation name',
    key: 'name',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const suggestionHeaders = [
  {
    title: 'suggestion name',
    key: 'name',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const hazardHeaders = [
  {
    title: 'hazard name',
    key: 'name',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const complianceHeaders = [
  {
    title: 'compliance',
    key: 'compliance_desc',
  },
  {
    title: 'standard',
    key: 'applicable_standard',
  },
  {
    title: 'status',
    key: 'compliance_status',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const status = [
  {
    title: 'Compliant',
    value: 'compliant',
  },
  {
    title: 'Non-Compliant',
    value: 'non-compliant',
  },
]
</script>

<template>
  <StandardReferencedDialog
    v-model:isDialogVisible="isAddStandardReferencedDialogVisible"
    :standard-headers="standardHeaders"
  />
  <RecommendationDialog
    v-model:isDialogVisible="isAddRecommendationDialogVisible"
    :recommendation-headers="recommendationHeaders"
  />
  <SuggestionDialog
    v-model:isDialogVisible="isAddSuggestionDialogVisible"
    :suggestion-headers="suggestionHeaders"
  />
  <ComplianceDialog
    v-model:isDialogVisible="isAddComplianceDialogVisible"
    :compliance-headers="complianceHeaders"
    :status="status"
  />
  <ServiceDialog
    v-model:isDialogVisible="isAddServiceDialogVisible"
    :service-headers="serviceHeaders"
  />
  <HazardDialog
    v-model:isDialogVisible="isAddHazardDialogVisible"
    :hazard-headers="hazardHeaders"
  />
  
  <VRow class="match-height">
    <!-- 👉 Add New Standard -->
    <VCol
      cols="12"
      sm="6"
    >
      <VCard
        class="h-100"
        :ripple="false"
        @click="isAddStandardReferencedDialogVisible = !isAddStandardReferencedDialogVisible"
      >
        <VRow
          no-gutters
          class="h-100"
        >
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img
              width="85"
              :src="girlUsingMobile"
            >
          </VCol>

          <VCol cols="7">
            <VCardText
              class="d-flex flex-column align-end justify-end gap-2 h-100"
              style="text-align: end;"
            >
              <VBtn>Add New Standard</VBtn>
              <span>Add standard, if it doesn't exist.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <!-- 👉 Add New Recommendation -->
    <VCol
      cols="12"
      sm="6"
    >
      <VCard
        class="h-100"
        :ripple="false"
        @click="isAddRecommendationDialogVisible = !isAddRecommendationDialogVisible"
      >
        <VRow
          no-gutters
          class="h-100"
        >
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img
              width="85"
              :src="girlUsingMobile"
            >
          </VCol>

          <VCol cols="7">
            <VCardText
              class="d-flex flex-column align-end justify-end gap-2 h-100"
              style="text-align: end;"
            >
              <VBtn>Add New Recommendation</VBtn>
              <span>Add Recommendation, if it doesn't exist.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <!-- 👉 Add New Suggestion -->
    <VCol
      cols="12"
      sm="6"
    >
      <VCard
        class="h-100"
        :ripple="false"
        @click="isAddSuggestionDialogVisible = !isAddSuggestionDialogVisible"
      >
        <VRow
          no-gutters
          class="h-100"
        >
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img
              width="85"
              :src="girlUsingMobile"
            >
          </VCol>
          <VCol cols="7">
            <VCardText
              class="d-flex flex-column align-end justify-end gap-2 h-100"
              style="text-align: end;"
            >
              <VBtn>Add New Suggestion</VBtn>
              <span>Add Suggestion, if it doesn't exist.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <VCol
      cols="12"
      sm="6"
    >
      <VCard
        class="h-100"
        :ripple="false"
        @click="isAddComplianceDialogVisible = !isAddComplianceDialogVisible"
      >
        <VRow
          no-gutters
          class="h-100"
        >
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img
              width="85"
              :src="girlUsingMobile"
            >
          </VCol>

          <VCol cols="7">
            <VCardText
              class="d-flex flex-column align-end justify-end gap-2 h-100"
              style="text-align: end;"
            >
              <VBtn>Add New Compliance</VBtn>
              <span>Add Compliance, if it doesn't exist.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <VCol
      cols="12"
      sm="6"
    >
      <VCard
        class="h-100"
        :ripple="false"
        @click="isAddServiceDialogVisible = !isAddServiceDialogVisible"
      >
        <VRow
          no-gutters
          class="h-100"
        >
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img
              width="85"
              :src="girlUsingMobile"
            >
          </VCol>

          <VCol cols="7">
            <VCardText
              class="d-flex flex-column align-end justify-end gap-2 h-100"
              style="text-align: end;"
            >
              <VBtn>Add New Mission Service</VBtn>
              <span>Add Mission Service, if it doesn't exist.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <!-- 👉 Add New Hazard -->
    <VCol
      cols="12"
      sm="6"
    >
      <VCard
        class="h-100"
        :ripple="false"
        @click="isAddHazardDialogVisible = !isAddHazardDialogVisible"
      >
        <VRow
          no-gutters
          class="h-100"
        >
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img
              width="85"
              :src="girlUsingMobile"
            >
          </VCol>

          <VCol cols="7">
            <VCardText
              class="d-flex flex-column align-end justify-end gap-2 h-100"
              style="text-align: end;"
            >
              <VBtn>Add New Hazard</VBtn>
              <span>Add Hazard, if it doesn't exist.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
  </VRow>
</template>
