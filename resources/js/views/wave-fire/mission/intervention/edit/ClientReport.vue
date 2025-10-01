<script setup>
import ClientReportTasksCard from './ClientReportTasksCard.vue'
import ExitSlipCard from './ExitSlipCard.vue'


const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  interventionData: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

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

// 👉 Exit Slip Headers
const exitSlipHeaders = [
  {
    title: 'EQUIPMENT',
    key: 'equipment',
  },
  {
    title: 'STATUS',
    key: 'equipment_status',
  },
]

const panel = ref(0)
const localInterventionData = ref((props.interventionData))
const refVForm = ref()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateInterventionData = async () => {
  emit('submit', localInterventionData.value)
}

const onSubmit = () => {
  updateInterventionData() // Emit the updated data
}

watch(() => props.currentStep)

// Function to parse additional maintenance data
const parsedTeamMembers = teamMembers => {
  try {
    return JSON.parse(teamMembers)
  } catch (error) {
    return []
  }
}

const qualityServiceItems  = [
  'Excellent',
  'Good',
  'Satisfactory',
  'Poor',
  'Very Poor',
]

const arriveTimeItems  = [
  'Yes',
  'No',
]

const professionalismItems  = [
  'Very Satisfied',
  'Satisfied',
  'Neutral',
  'Dissatisfied',
  'Very Dissatisfied',
]

const specificNeedsItems  = [
  'Extremely Well',
  'Very Well',
  'Adequately',
  'Poorly',
  'Very Poorly',
]

const recommendOurServicesItems  = [
  'Highly Likely',
  'Likely',
  'Neutral',
  'Unlikely',
  'Highly Unlikely',
]
</script>

<template>
  <VRow class="match-height">
    <VCol cols="12">
      <!-- 👉 Client Information -->
      <VCard title="Client Report">
        <VCardText>
          <VRow>
            <VCol
              md="6" 
              cols="12"
            >
              <VCard class="mb-0">
                <VCardText>
                  <p class="text-xs">
                    Service Provider
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-user"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span>SECURITE SERVICES PLUS</span>
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
                        <span>Gabes Road Km 3.5 Sfax</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-3">
                    CONTACTS
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-phone"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span>+216 74 453 027</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-mail"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span>contact@ssplus.tn</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-world-www"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span>www.ssplus.tn</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>
                </VCardText>
              </VCard>
            </VCol>
            <VCol
              md="6" 
              cols="12"
            >
              <VCard class="mb-0">
                <VCardText>
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
                        <span>{{ localInterventionData.mission_client_id }}</span>
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
                        <span>{{ localInterventionData.client_name }}</span>
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
                        <span>{{ localInterventionData.address }} - {{ localInterventionData.postcode }}</span>
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
                        <span>{{ localInterventionData.city }} - {{ localInterventionData.country }}</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-3">
                    CONTACTS
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem v-if="localInterventionData.main_phone_number">
                      <template #prepend>
                        <VIcon
                          icon="tabler-phone"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Phone:</span>
                        <span>{{ localInterventionData.main_phone_number }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem v-if="localInterventionData.email">
                      <template #prepend>
                        <VIcon
                          icon="tabler-mail"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Email:</span>
                        <span>{{ localInterventionData.email }}</span>
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
                        <span>{{ localInterventionData.intervention_id }}</span>
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
                        <span>{{ localInterventionData.intervention_date }}</span>
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
                        <span>{{ localInterventionData.mission_frequency }}</span>
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
                        <span>{{ localInterventionData.team_leader }}</span>
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
                          v-for="teamMembers in parsedTeamMembers(localInterventionData.team_members)"
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
                        <span>{{ localInterventionData.park_id }}</span>
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
                        <span>{{ localInterventionData.park_title }}</span>
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
                        <span>{{ localInterventionData.park_address }} - {{ localInterventionData.park_postcode }}</span>
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
                        <span> {{ localInterventionData.park_city }} - {{ localInterventionData.park_country }}</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>
                </VCardText>
              </VCard>
            </VCol>

            <VCol cols="12">
              <VCard>
                <VRow no-gutters>
                  <VExpansionPanels
                    v-model="panel"
                    multiple
                    class="no-icon-rotate"
                  >
                    <VExpansionPanel>
                      <VForm
                        ref="refVForm"
                        lazy-validation
                        class="mt-1"
                        @submit.prevent="onSubmit"
                      >
                        <VExpansionPanelTitle
                          class="text-uppercase"
                          disable-icon-rotate
                        >
                          Client Satisfaction Survey
                          <template #actions>
                            <VIcon
                              size="35"
                              icon="tabler-circle-dashed-percentage"
                              color="primary"
                            />
                          </template>
                        </VExpansionPanelTitle>
                        <VExpansionPanelText>
                          <VRow class="match-height">
                            <VCol cols="12">
                              <p class="text-h5 mb-0">
                                Thank you for choosing our services. Please take a moment to complete this brief survey to help us improve.
                              </p>
                            </VCol>
                            <VCol
                              md="6"
                              cols="12"
                            >
                              <VCard>
                                <VCol cols="12">
                                  <h5 class="text-h5 mb-0">
                                    Overall Quality of Service
                                  </h5>
                                  <h6 class="text-h6 mb-0">
                                    How would you rate the overall quality of our service?
                                  </h6>
                                </VCol>
                                <VCol cols="12">
                                  <AppSelect
                                    v-model="localInterventionData.client_feedback_quality_service"
                                    :items="qualityServiceItems"
                                    placeholder="Select Item"
                                  />
                                </VCol>
                              </VCard>
                            </VCol>
                            <VCol
                              md="6"
                              cols="12"
                            >
                              <VCard>
                                <VCol cols="12">
                                  <h5 class="text-h5 mb-0">
                                    Punctuality of Team
                                  </h5>
                                  <h6 class="text-h6 mb-0">
                                    Did our team arrive on time?
                                  </h6>
                                </VCol>
                                <VCol cols="12">
                                  <AppSelect
                                    v-model="localInterventionData.client_feedback_arrive_time"
                                    :items="arriveTimeItems"
                                    placeholder="Select Item"
                                  />
                                </VCol>
                              </VCard>
                            </VCol>
                            <VCol
                              md="6"
                              cols="12"
                            >
                              <VCard>
                                <VCol cols="12">
                                  <h5 class="text-h5 mb-0">
                                    Professionalism of Our Team
                                  </h5>
                                  <h6 class="text-h6 mb-0">
                                    How satisfied are you with the professionalism of our team?
                                  </h6>
                                </VCol>
                                <VCol cols="12">
                                  <AppSelect
                                    v-model="localInterventionData.client_feedback_professionalism"
                                    :items="professionalismItems"
                                    placeholder="Select Item"
                                  />
                                </VCol>
                              </VCard>
                            </VCol>
                            <VCol
                              md="6"
                              cols="12"
                            >
                              <VCard>
                                <VCol cols="12">
                                  <h5 class="text-h5 mb-0">
                                    Addressing Specific Needs and Concerns
                                  </h5>
                                  <h6 class="text-h6 mb-0">
                                    How well did our team address your specific needs or concerns?
                                  </h6>
                                </VCol>
                                <VCol cols="12">
                                  <AppSelect
                                    v-model="localInterventionData.client_feedback_specific_needs"
                                    :items="specificNeedsItems"
                                    placeholder="Select Item"
                                  />
                                </VCol>
                              </VCard>
                            </VCol>
                            <VCol
                              md="6"
                              cols="12"
                            >
                              <VCard>
                                <VCol cols="12">
                                  <h5 class="text-h5 mb-0">
                                    Likelihood of Recommending Our Services
                                  </h5>
                                  <h6 class="text-h6 mb-0">
                                    How likely are you to recommend our services to others?
                                  </h6>
                                </VCol>
                                <VCol cols="12">
                                  <AppSelect
                                    v-model="localInterventionData.client_feedback_recommend_our_services"
                                    :items="recommendOurServicesItems"
                                    placeholder="Select Item"
                                  />
                                </VCol>
                              </VCard>
                            </VCol>
                            <VCol
                              md="6"
                              cols="12"
                            >
                              <VCard>
                                <VCol cols="12">
                                  <h5 class="text-h5 mb-0">
                                    Additional comments or feedback
                                  </h5>
                                </VCol>
                                <VCol cols="12">
                                  <VTextarea
                                    v-model="localInterventionData.client_feedback"
                                    label="Feedback"
                                    rows="3"
                                    variant="outlined"
                                  />
                                </VCol>
                              </VCard>
                            </VCol>
                            <VCol cols="12">
                              <p class="text-h5 mb-0">
                                Thank you for your feedback! We appreciate your business and are committed to continually improving our services.
                              </p>
                            </VCol>
                            <VCol cols="12">
                              <VBtn 
                                block 
                                type="submit"
                              >
                                Submit
                                <VIcon
                                  icon="tabler-checklist"
                                  end
                                  class="flip-in-rtl"
                                />
                              </VBtn>
                            </VCol>
                          </VRow>  
                        </VExpansionPanelText>
                      </VForm>
                    </VExpansionPanel>
                  </VExpansionPanels>
                </VRow>
              </VCard>
            </VCol>
            
            <VCol cols="12">
              <VRow>
                <VCol cols="12">
                  <ClientReportTasksCard :equipment-headers="equipmentHeaders" />
                </VCol>

                <VCol cols="12">
                  <ExitSlipCard :equipment-headers="exitSlipHeaders" />
                </VCol>
                
                <VCol cols="12">
                  <VCard title="Intervention Notes">
                    <VCardText>
                      <VForm
                        ref="refVForm"
                        lazy-validation
                        class="mt-1"
                        @submit.prevent="onSubmit"
                      >
                        <VRow>
                          <VCol
                            md="10"
                            cols="9"
                          >
                            <VTextarea
                              v-model="localInterventionData.intervention_notes"
                              label="Intervention Notes"
                              rows="3"
                              variant="outlined"
                            />
                          </VCol>
                          <VCol
                            md="2"
                            cols="3"
                          >
                            <VBtn type="submit">
                              Accept
                              <VIcon
                                end
                                icon="tabler-checkbox"
                              />
                            </VBtn>
                          </VCol>
                        </VRow>
                      </VForm>
                    </VCardText>
                  </VCard>
                </VCol>
              </VRow> 
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
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

      <VBtn disabled>
        Next
        <VIcon
          icon="tabler-arrow-right"
          end
          class="flip-in-rtl"
        />
      </VBtn>
    </div>
  </VCol>
</template>

<style lang="scss" scoped>
.congo-john-img {
  position: absolute;
  inset-block-end: 0;
  inset-inline-end: 1.25rem;
}
</style>
