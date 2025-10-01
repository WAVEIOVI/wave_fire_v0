
<script setup>
const props = defineProps({
  sectionData: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <VContainer class="mission-report-section">
    <VRow>
      <VCol cols="12">
        <h2 class="text-h4 mb-6">
          {{ sectionData.title }}
        </h2>
      </VCol>
    </VRow>

    <!-- @ANCHOR: Introduction -->
    <VRow v-if="sectionData.introduction">
      <VCol cols="12">
        <p class="text-body-1">
          {{ sectionData.introduction }}
        </p>
      </VCol>
    </VRow>

    <!-- @ANCHOR: Key Findings -->
    <VRow v-if="sectionData.keyFindings && sectionData.keyFindings.length">
      <VCol cols="12">
        <h3 class="text-h5 mb-3">
          Key Findings
        </h3>
        <VList>
          <VListItem
            v-for="(finding, index) in sectionData.keyFindings"
            :key="index"
          >
            <template #prepend>
              <VIcon color="primary">
                mdi-check-circle
              </VIcon>
            </template>
            <VListItemTitle>{{ finding }}</VListItemTitle>
          </VListItem>
        </VList>
      </VCol>
    </VRow>

    <!-- @ANCHOR: Data Presentation -->
    <VRow v-if="sectionData.dataTable || sectionData.chartData">
      <VCol
        cols="12"
        :md="sectionData.dataTable && sectionData.chartData ? 6 : 12"
      >
        <h3 class="text-h5 mb-3">
          Data Summary
        </h3>
        <VDataTable
          v-if="sectionData.dataTable"
          :headers="sectionData.dataTable.headers"
          :items="sectionData.dataTable.items"
          :items-per-page="5"
          class="elevation-1"
        />
      </VCol>
      <VCol
        v-if="sectionData.chartData"
        cols="12"
        :md="sectionData.dataTable ? 6 : 12"
      >
        <h3 class="text-h5 mb-3">
          Data Visualization
        </h3>
        <VChart
          class="chart"
          :option="chartOption"
          autoresize
        />
      </VCol>
    </VRow>

    <!-- @ANCHOR: Key Metrics -->
    <VRow v-if="sectionData.keyMetrics && sectionData.keyMetrics.length">
      <VCol cols="12">
        <h3 class="text-h5 mb-3">
          Key Metrics
        </h3>
      </VCol>
      <VCol
        v-for="(metric, index) in sectionData.keyMetrics"
        :key="index"
        cols="12"
        sm="6"
        md="3"
      >
        <VCard
          class="mx-auto"
          max-width="300"
        >
          <VCardText>
            <div class="text-h4 text--primary">
              {{ metric.value }}
            </div>
            <p class="text-subtitle-1">
              {{ metric.label }}
            </p>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>

    <!-- @ANCHOR: Detailed Analysis -->
    <VRow v-if="sectionData.detailedAnalysis && sectionData.detailedAnalysis.length">
      <VCol cols="12">
        <h3 class="text-h5 mb-3">
          Detailed Analysis
        </h3>
        <div
          v-for="(analysis, index) in sectionData.detailedAnalysis"
          :key="index"
        >
          <h4
            v-if="analysis.title"
            class="text-h6 mt-4 mb-2"
          >
            {{ analysis.title }}
          </h4>
          <p class="text-body-1 mb-4">
            {{ analysis.content }}
          </p>
        </div>
      </VCol>
    </VRow>

    <!-- @ANCHOR: Recommendations -->
    <VRow v-if="sectionData.recommendations && sectionData.recommendations.length">
      <VCol cols="12">
        <h3 class="text-h5 mb-3">
          Recommendations
        </h3>
        <VTimeline
          align-top
          dense
        >
          <VTimelineItem
            v-for="(recommendation, index) in sectionData.recommendations"
            :key="index"
            color="primary"
            small
          >
            <VCard>
              <VCardTitle class="text-h6">
                {{ recommendation.title }}
              </VCardTitle>
              <VCardText>{{ recommendation.description }}</VCardText>
              <VCardActions v-if="recommendation.priority">
                <VChip
                  :color="getPriorityColor(recommendation.priority)"
                  text-color="white"
                >
                  {{ recommendation.priority }} Priority
                </VChip>
              </VCardActions>
            </VCard>
          </VTimelineItem>
        </VTimeline>
      </VCol>
    </VRow>

    <!-- @ANCHOR: Conclusion -->
    <VRow v-if="sectionData.conclusion">
      <VCol cols="12">
        <h3 class="text-h5 mb-3">
          Conclusion
        </h3>
        <p class="text-body-1">
          {{ sectionData.conclusion }}
        </p>
      </VCol>
    </VRow>
  </VContainer>
</template>

<style scoped>
.mission-report-section {
  margin-block-end: 4rem;
}

.chart {
  block-size: 400px;
}
</style>
