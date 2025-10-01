<script setup>
import { useGenerateImageVariant } from '@core/composable/useGenerateImageVariant'
import miscMaskDark from '@images/pages/misc-mask-dark.png'
import miscMaskLight from '@images/pages/misc-mask-light.png'
import miscUnderMaintenance from '@images/pages/misc-under-maintenance.png'
import AttestationViewDialog from './AttestationViewDialog.vue'
import ComplianceCompliantDialog from './ComplianceCompliantDialog.vue'
import ComplianceNonCompliantDialog from './ComplianceNonCompliantDialog.vue'
import InterventionMetaTasksCard from './InterventionMetaTasksCard.vue'
import InterventionReportTasksCard from './InterventionReportTasksCard.vue'
import InterventionTableTasksCard from './InterventionTableTasksCard.vue'
import OutOfServiceDialog from './OutOfServiceDialog.vue'
import RecommendationDialog from './RecommendationDialog.vue'
import ReportViewDialog from './ReportViewDialog.vue'
import RiskAssessmentDialog from './RiskAssessmentDialog.vue'
import StandardReferencedDialog from './StandardReferencedDialog.vue'
import SuggestionDialog from './SuggestionDialog.vue'

import WorkshopMetaTasksCard from './WorkshopMetaTasksCard.vue'
import WorkshopReportTasksCard from './WorkshopReportTasksCard.vue'
import WorkshopTableTasksCard from './WorkshopTableTasksCard.vue'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  missionData: {
    type: Object,
    required: true,
  },
  technicians: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const authThemeMask = useGenerateImageVariant(miscMaskLight, miscMaskDark)

// 👉 Equipment Headers
const equipmentHeaders = [
  {
    title: 'EQUIPMENT',
    key: 'equipment',
  },
  {
    title: 'Accessory',
    key: 'accessory',
  },
  {
    title: 'Maintenance',
    key: 'maintenance',
  },
  {
    title: 'Supply',
    key: 'supply',
  },
  {
    title: 'STATUS',
    key: 'equipment_status',
  },
] 

const localMissionData = ref((props.missionData))

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateMissionData = async () => {
  emit('submit', localMissionData.value)
}

// Function to parse additional maintenance data
const parsedTeamMembers = teamMembers => {
  try {
    return JSON.parse(teamMembers)
  } catch (error) {
    return []
  }
}

watch(() => props.currentStep, updateMissionData)

const isAddStandardReferencedDialogVisible = ref(false)
const isAddRecommendationDialogVisible = ref(false)
const isAddSuggestionDialogVisible = ref(false)
const isAddComplianceCompliantDialogVisible = ref(false)
const isAddComplianceNonCompliantDialogVisible = ref(false)
const isAddRiskAssessmentDialogVisible = ref(false)
const isAddReportViewDialogVisible = ref(false)
const isAddOutOfServiceDialogVisible = ref(false)
const isAddAttestationViewDialogVisible = ref(false)


// 👉 Headers
const headers = [
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

const standardViewHeaders = [
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
]

const recommendationsHeaders = [
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const recommendationsViewHeaders = [
  {
    title: 'recommendation',
    key: 'name',
  },
]

const suggestionsHeaders = [
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const suggestionsViewHeaders = [
  {
    title: 'suggestion',
    key: 'name',
  },
]


const compliancesHeaders = [
  {
    title: 'compliance',
    key: 'compliance_desc',
  },
  {
    title: 'action',
    key: 'pivot.action',
  },
  {
    title: 'standard',
    key: 'applicable_standard',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const compliancesViewHeaders = [
  {
    title: 'compliance',
    key: 'compliance_desc',
  },
  {
    title: 'action',
    key: 'pivot.action',
  },
  {
    title: 'standard',
    key: 'applicable_standard',
  },
]

const hazardsHeaders = [
  {
    title: 'Hazard',
    key: 'hazard',
  },
  {
    title: 'Description',
    key: 'description',
  },
  {
    title: 'Likelihood',
    key: 'likelihood',
  },
  {
    title: 'Severity',
    key: 'severity',
  },
  {
    title: 'Risk Level',
    key: 'risk_level',
  },
  {
    title: 'Mitigation Strategy',
    key: 'mitigation_strategy',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const hazardsViewHeaders = [
  {
    title: 'Hazard',
    key: 'hazard',
  },
  {
    title: 'Description',
    key: 'description',
  },
  {
    title: 'Risk Level',
    key: 'risk_level',
  },
  {
    title: 'Mitigation Strategy',
    key: 'mitigation_strategy',
  },
]

const riskLevelViewHeaders = [
  {
    title: 'Hazard',
    key: 'hazard',
  },
  {
    title: 'Likelihood',
    key: 'likelihood',
  },
  {
    title: 'Severity',
    key: 'severity',
  },
  {
    title: 'Risk Level',
    key: 'risk_level',
  },
]

const serviceViewHeaders = [
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
]

const areaViewHeaders = [
  {
    title: 'area',
    key: 'area_description',
  },
  {
    title: 'accessibility',
    key: 'area_accessibility',
  },
  {
    title: 'classification',
    key: 'area_classification',
  },
]

const outsHeaders = [
  {
    title: 'equipment',
    key: 'equipment',
  },
  {
    title: 'the reason',
    key: 'the_reason',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const outsViewHeaders = [
  {
    title: 'equipment',
    key: 'equipment',
  },
  {
    title: 'the reason',
    key: 'the_reason',
  },
]
</script>

<template>
  <StandardReferencedDialog
    v-model:isDialogVisible="isAddStandardReferencedDialogVisible"
    :headers="headers"
    :mission-data="missionData"
  />
  <RecommendationDialog
    v-model:isDialogVisible="isAddRecommendationDialogVisible"
    :recommendations-headers="recommendationsHeaders"
    :mission-data="missionData"
  />
  <SuggestionDialog
    v-model:isDialogVisible="isAddSuggestionDialogVisible"
    :suggestions-headers="suggestionsHeaders"
    :mission-data="missionData"
  />
  <ComplianceCompliantDialog
    v-model:isDialogVisible="isAddComplianceCompliantDialogVisible"
    :compliances-headers="compliancesHeaders"
    :mission-data="missionData"
  />
  <ComplianceNonCompliantDialog
    v-model:isDialogVisible="isAddComplianceNonCompliantDialogVisible"
    :compliances-headers="compliancesHeaders"
    :mission-data="missionData"
  />
  <RiskAssessmentDialog
    v-model:isDialogVisible="isAddRiskAssessmentDialogVisible"
    :hazards-headers="hazardsHeaders"
    :mission-data="missionData"
  />
  <OutOfServiceDialog
    v-model:isDialogVisible="isAddOutOfServiceDialogVisible"
    :outs-headers="outsHeaders"
    :mission-data="missionData"
  />
  <ReportViewDialog
    v-model:isDialogVisible="isAddReportViewDialogVisible"
    :recommendations-view-headers="recommendationsViewHeaders"
    :suggestions-view-headers="suggestionsViewHeaders"
    :service-view-headers="serviceViewHeaders"
    :area-view-headers="areaViewHeaders"
    :outs-view-headers="outsViewHeaders"
    :standard-view-headers="standardViewHeaders"
    :hazards-view-headers="hazardsViewHeaders"
    :risk-level-view-headers="riskLevelViewHeaders"
    :compliances-view-headers="compliancesViewHeaders"
    :mission-data="missionData"
  />
  <AttestationViewDialog
    v-model:isDialogVisible="isAddAttestationViewDialogVisible"
    :recommendations-view-headers="recommendationsViewHeaders"
    :suggestions-view-headers="suggestionsViewHeaders"
    :service-view-headers="serviceViewHeaders"
    :area-view-headers="areaViewHeaders"
    :outs-view-headers="outsViewHeaders"
    :standard-view-headers="standardViewHeaders"
    :hazards-view-headers="hazardsViewHeaders"
    :risk-level-view-headers="riskLevelViewHeaders"
    :compliances-view-headers="compliancesViewHeaders"
    :mission-data="missionData"
  />
  <VCard v-if="localMissionData.mission_status === 'pending'">
    <VRow>
      <VCol cols="12">
        <div class="text-center mb-12">
          <!-- 👉 Title and subtitle -->
          <h4 class="text-h4 font-weight-medium mb-3">
            The Mission Is Pending! 🚧
          </h4>
          <p>This Mission Is Waiting To Be Worked On By Technicians.</p>
        </div>

        <!-- 👉 Image -->
        <div class="misc-avatar w-100 text-center">
          <VImg
            :src="miscUnderMaintenance"
            class="mx-auto"
            :max-width="450"
          />
        </div>

        <VImg
          :src="authThemeMask"
          class="misc-footer-img d-none d-md-block"
        />
      </VCol>
    </VRow>
  </VCard>
  <VRow>
    <!-- 👉 Monitoring -->
    <VCard 
      v-if="localMissionData.mission_status !== 'pending'"
      title="Monitoring"
    >
      <VCardText class="pt-2">
        <VRow class="match-height">
          <VCol
            md="8"
            cols="12"
          >
            <VCard class="mb-0">
              <VCardText>
                <VRow class="match-height">
                  <VCol cols="6">
                    <p class="text-xs">
                      Client Details
                    </p>
                    <VList class="card-list text-medium-emphasis">
                      <VListItem>
                        <template #prepend>
                          <VIcon
                            icon="tabler-scan"
                            size="20"
                            class="me-2"
                          />
                        </template>
                        <VListItemTitle>
                          <span class="font-weight-medium me-1" />
                          <span>{{ localMissionData.mission_client_id }}</span>
                        </VListItemTitle>
                      </VListItem>
                      <VListItem>
                        <template #prepend>
                          <VIcon
                            icon="tabler-user"
                            size="20"
                            class="me-2"
                          />
                        </template>
                        <VListItemTitle>
                          <span class="font-weight-medium me-1" />
                          <span>{{ localMissionData.client_name }}</span>
                        </VListItemTitle>
                      </VListItem>
                      <VListItem>
                        <template #prepend>
                          <VIcon
                            icon="tabler-map-pin"
                            size="20"
                            class="me-2"
                          />
                        </template>
                        <VListItemTitle>
                          <span class="font-weight-medium me-1" />
                          <span>{{ localMissionData.address }} - {{ localMissionData.postcode }}</span>
                        </VListItemTitle>
                      </VListItem>
                      <VListItem>
                        <template #prepend>
                          <VIcon
                            icon="tabler-flag"
                            size="20"
                            class="me-2"
                          />
                        </template>
                        <VListItemTitle>
                          <span class="font-weight-medium me-1" />
                          <span>{{ localMissionData.city }} - {{ localMissionData.country }}</span>
                        </VListItemTitle>
                      </VListItem>
                    </VList>
                  </VCol>
                  <VCol cols="6">
                    <p class="text-xs mt-3">
                      CONTACTS
                    </p>

                    <VList class="card-list text-medium-emphasis">
                      <VListItem v-if="localMissionData.main_phone_number">
                        <template #prepend>
                          <VIcon
                            icon="tabler-phone"
                            size="20"
                            class="me-2"
                          />
                        </template>
                        <VListItemTitle>
                          <span class="font-weight-medium me-1">Phone:</span>
                          <span>{{ localMissionData.main_phone_number }}</span>
                        </VListItemTitle>
                      </VListItem>
                      <VListItem v-if="localMissionData.email">
                        <template #prepend>
                          <VIcon
                            icon="tabler-mail"
                            size="20"
                            class="me-2"
                          />
                        </template>
                        <VListItemTitle>
                          <span class="font-weight-medium me-1">Email:</span>
                          <span>{{ localMissionData.email }}</span>
                        </VListItemTitle>
                      </VListItem>
                    </VList>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>
          <!-- 👉 Right Column: Mission Action -->
          <VCol
            cols="12"
            md="4"
          >
            <VCard class="mb-8">
              <VCardText>
                <!-- 👉 Report Trigger button -->
                <VBtn
                  block
                  prepend-icon="tabler-file"
                  class="mb-2"
                  @click="isAddReportViewDialogVisible = !isAddReportViewDialogVisible"
                >
                  Report View
                </VBtn>
                <!-- 👉 Attestation Trigger button -->
                <VBtn
                  block
                  prepend-icon="tabler-file"
                  class="mb-2"
                  @click="isAddAttestationViewDialogVisible = !isAddAttestationViewDialogVisible"
                >
                  Attestation View
                </VBtn>
                <!-- 👉 Risk Assessment Trigger button -->
                <VBtn
                  block
                  color="warning"
                  prepend-icon="tabler-alert-triangle"
                  class="mb-2"
                  @click="isAddRiskAssessmentDialogVisible = !isAddRiskAssessmentDialogVisible"
                >
                  Risk Assessment
                </VBtn>
              
                <!-- 👉 Recommendation Trigger button -->
                <VBtn
                  color="info"
                  block
                  prepend-icon="tabler-message-plus"
                  class="mb-2"
                  @click="isAddRecommendationDialogVisible = !isAddRecommendationDialogVisible"
                >
                  Recommendations
                </VBtn>
                <!-- 👉 Suggestion Trigger button -->
                <VBtn
                  color="info"
                  block
                  prepend-icon="tabler-message-plus"
                  class="mb-2"
                  @click="isAddSuggestionDialogVisible = !isAddSuggestionDialogVisible"
                >
                  Suggestions
                </VBtn>
                <div class="d-flex gap-2">
                  <div class="w-50">
                    <!-- 👉 Compliant list button -->
                    <VBtn
                      block
                      color="success"
                      class="mb-2"
                      @click="isAddComplianceCompliantDialogVisible = !isAddComplianceCompliantDialogVisible"
                    >
                      Compliant list
                    </VBtn>
                  </div>
                  <div class="w-50">
                    <!-- 👉 Non-Compliant list button -->
                    <VBtn
                      block
                      color="error"
                      class="mb-2"
                      @click="isAddComplianceNonCompliantDialogVisible = !isAddComplianceNonCompliantDialogVisible"
                    >
                      Non-Compliant list
                    </VBtn>
                  </div>
                </div>
                <!-- 👉 Add Standards Referenced trigger button -->
                <VBtn
                  block
                  color="secondary"
                  variant="tonal"
                  prepend-icon="tabler-books"
                  @click="isAddStandardReferencedDialogVisible = !isAddStandardReferencedDialogVisible"
                >
                  Standards Referenced
                </VBtn>
                <!-- 👉 Add Out Of Service trigger button -->
                <div class="mt-2">
                  <VBtn
                    block
                    color="error"
                    prepend-icon="tabler-trash"
                    @click="isAddOutOfServiceDialogVisible = !isAddOutOfServiceDialogVisible"
                  >
                    Out Of Service
                  </VBtn> 
                </div>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            md="4" 
            cols="6"
          >
            <VCard class="mb-0">
              <VCardText>
                <p class="text-xs mt-3">
                  Mission
                </p>

                <VList class="card-list text-medium-emphasis">
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-scan"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1">Mission ID:</span>
                      <span>{{ localMissionData.mission_id }}</span>
                    </VListItemTitle>
                  </VListItem>
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-calendar-check"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1">Mission Date:</span>
                      <span>{{ localMissionData.mission_date }}</span>
                    </VListItemTitle>
                  </VListItem>
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-hourglass-empty"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1">Mission Frequency:</span>
                      <span>{{ localMissionData.mission_frequency }}</span>
                    </VListItemTitle>
                  </VListItem>
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-report-analytics"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle v-if="localMissionData.mission_status === 'in_progress'">
                      <span class="font-weight-medium me-1">Mission Status:</span>
                      <VProgressLinear
                        indeterminate
                        color="warning"
                      />
                    </VListItemTitle>
                    <VListItemTitle v-if="localMissionData.mission_status === 'completed'">
                      <span class="font-weight-medium me-1">Mission Completed</span>
                    </VListItemTitle>
                    <VListItemTitle v-if="localMissionData.mission_status === 'closure'">
                      <span class="font-weight-medium me-1">Mission Closured</span>
                    </VListItemTitle>
                  </VListItem>
                </VList>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            md="4" 
            cols="12"
          >
            <VCard class="mb-0">
              <VCardText>
                <p class="text-xs mt-3">
                  TEAMS
                </p>

                <VList class="card-list text-medium-emphasis">
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-user-check"
                        size="20"
                        color="success"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1">Team Leader:</span>
                      <span>{{ localMissionData.team_leader }}</span>
                    </VListItemTitle>
                  </VListItem>
                  <VListItem>
                    <VListItemTitle>
                      <VIcon
                        icon="tabler-users"
                        size="20"
                        color="success"
                        class="me-2"
                      />
                      <span class="font-weight-medium me-1">Team Members:</span>
                    </VListItemTitle>
                    <VChipGroup>
                      <VChip
                        v-for="teamMembers in parsedTeamMembers(localMissionData.team_members)"
                        :key="teamMembers"
                        variant="text"
                        label
                        x-small
                        class="mb-0 text-uppercase"
                      >
                        {{ teamMembers }}
                      </VChip>
                    </VChipGroup>
                  </VListItem>
                </VList>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            md="4" 
            cols="12"
          >
            <VCard class="mb-0">
              <VCardText>
                <p class="text-xs mt-3">
                  Park Details
                </p>

                <VList class="card-list text-medium-emphasis">
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-scan"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1" />
                      <span>{{ localMissionData.park_id }}</span>
                    </VListItemTitle>
                  </VListItem>
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-flame"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1" />
                      <span>{{ localMissionData.park_title }}</span>
                    </VListItemTitle>
                  </VListItem>
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-map-pin"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1" />
                      <span>{{ localMissionData.park_address }} - {{ localMissionData.park_postcode }}</span>
                    </VListItemTitle>
                  </VListItem>
                  <VListItem>
                    <template #prepend>
                      <VIcon
                        icon="tabler-flag"
                        size="20"
                        class="me-2"
                      />
                    </template>
                    <VListItemTitle>
                      <span class="font-weight-medium me-1" />
                      <span> {{ localMissionData.park_city }} - {{ localMissionData.park_country }}</span>
                    </VListItemTitle>
                  </VListItem>
                </VList>
              </VCardText>
            </VCard>
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'intervention'"
            cols="12"
          >
            <InterventionMetaTasksCard :mission-data="missionData" />
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'workshop'"
            cols="12"
          >
            <WorkshopMetaTasksCard :mission-data="missionData" />
          </VCol>

          <VCol cols="12">
            <VRow>             
              <VCol cols="12">
                <VRow>
                  <VCol
                    v-if="localMissionData.mission_type === 'intervention'"
                    cols="12"
                  >
                    <InterventionTableTasksCard :mission-data="missionData" />
                  </VCol>
                  <VCol
                    v-if="localMissionData.mission_type === 'workshop'"
                    cols="12"
                  >
                    <WorkshopTableTasksCard :mission-data="missionData" />
                  </VCol>
                </VRow>
              </VCol>
            </VRow> 
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'intervention'"
            cols="12"
          >
            <InterventionReportTasksCard
              :mission-data="missionData"
              :equipment-headers="equipmentHeaders"
            />
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'workshop'"
            cols="12"
          >
            <WorkshopReportTasksCard
              :mission-data="missionData"
              :equipment-headers="equipmentHeaders"
            />
          </VCol>
        </VRow>
        <VRow>                              
          <VCol cols="12">
            <VTextarea
              v-model="localMissionData.feedback"
              label="Feedback"
              rows="3"
              variant="outlined"
              disabled
            />
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
    <VCol cols="12">
      <div class="d-flex flex-wrap gap-4 justify-sm-space-between justify-center mt-8">
        <VBtn
          color="secondary"
          variant="tonal"
          @click="Previous"
        >
          <VIcon
            icon="tabler-arrow-left"
            start
            class="flip-in-rtl"
          />
          Previous
        </VBtn>

        <VBtn
          type="submit"
          @click="refVForm?.validate()"
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
</template>

<style lang="scss">
@use "@core-scss/template/pages/misc.scss";
</style>
