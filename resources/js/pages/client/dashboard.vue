<script setup>
import Footer from '@/layouts/components/Footer.vue'
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'
import { useUserClientDashboardStore } from '@/stores/useUserClientDashboardStore'
import { useUserStore } from '@/stores/user'
import UserProfileHeader from '@/views/client/UserProfileHeader.vue'
import Inventory from '@/views/client/inventory/index.vue'
import MissionFolder from '@/views/client/mission/index.vue'
import UserProfiles from '@/views/client/profile/index.vue'
import Search from '@/views/client/search/index.vue'
import { useClientListStore } from '@/views/contact/client/useClientListStore'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import { useRoute } from 'vue-router'

const userStore = useUserStore()
const clientData = ref([])
const clientListStore = useClientListStore()
const clientDashboardStore = useUserClientDashboardStore()
const parks = ref([])
const parksData = ref([])
const equipments = ref([])

// Watch for changes in userStore.client_id and fetch client data accordingly
const fetchClientData = async clientId => {
  if (clientId) {
    try {
      const response = await clientListStore.fetchClient(clientId)

      clientData.value = response.data.data
      fetchClientParks(clientId)
      fetchEquipments()
    } catch (error) {
      console.error('Error fetching client data:', error)
    }
  }
}

const fetchClientParks = async clientId => {
  if (!clientId) return
  try {
    const response = await clientDashboardStore.fetchClientParks(clientId)

    parks.value = response.data.meta.total
    parksData.value = response.data.data
    console.log(parks.value)
    console.log('parksData', parksData.value)
  } catch (error) {
    console.error(error)
  }
}

const fetchEquipments = async () => {
  try {
    const response = await clientDashboardStore.fetchEquipments({
      client: userStore.client_name,
    })

    equipments.value = response.data.meta.total
    console.log(equipments.value)
  } catch (error) {
    console.error(error)
  }
}

// Watch for changes in userStore.client_id and fetch client data accordingly
watch(() => userStore.client_id, fetchClientData)

// Fetch user data when the component is mounted
onMounted(async () => {
  await userStore.fetchUserData()
  fetchClientData(userStore.client_id)
})

const route = useRoute()
const activeTab = ref()

// tabs
const tabs = [
  {
    title: 'Profile',
    icon: 'tabler-user-check',
    tab: 'profile',
  },
  {
    title: 'Inventory',
    icon: 'tabler-building-warehouse',
    tab: 'inventory',
  },
  {
    title: 'Reporting and Analytics',
    icon: 'tabler-link',
    tab: 'mission',
  },
  {
    title: 'Equipment Search',
    icon: 'tabler-building-warehouse',
    tab: 'search',
  },
  {
    title: 'Maintenance and Inspection Schedule',
    icon: 'tabler-layout-grid',
    tab: 'projects',
  },
]

const missionHeaders = [
  {
    title: 'Mission Date',
    key: 'mission_date',
  },
  {
    title: 'Mission ID',
    key: 'mission_id',
  },
  {
    title: 'Client',
    key: 'mission_client',
  },
  {
    title: 'Type',
    key: 'mission_type',
  },
  {
    title: 'Status',
    key: 'mission_status',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const { appRouteTransition, isLessThanOverlayNavBreakpoint } = useThemeConfig()
const { width: windowWidth } = useWindowSize()
</script>

<template>
  <div class="mb-5 pa-md-4 mx-lg-auto">
    <VRow>
      <VCol cols="12">
        <!-- 👉 navbar -->
        <VCard>
          <VCardText class="d-flex h-100 align-center">
            <NavbarThemeSwitcher />

            <VSpacer />

            <UserProfile />
          </VCardText>
        </VCard>
      </VCol>
      <VSpacer />
      <VCol cols="12">
        <UserProfileHeader
          :client-data="clientData"
          class="mb-5"
        />

        <VTabs
          v-model="activeTab"
          class="v-tabs-pill"
        >
          <VTab
            v-for="item in tabs"
            :key="item.icon"
            :value="item.tab"
          >
            <VIcon
              size="20"
              start
              :icon="item.icon"
            />
            {{ item.title }}
          </VTab>
        </VTabs>

        <VWindow
          v-model="activeTab"
          class="mt-5 disable-tab-transition"
          :touch="false"
        >
          <!-- Profile -->
          <VWindowItem value="profile">
            <UserProfiles
              :client-data="clientData"
              :parks="parks"
              :equipments="equipments"
            />
          </VWindowItem>

          <!-- Inventory -->
          <VWindowItem value="inventory">
            <Inventory
              :client-data="clientData"
              :parks="parks"
              :parks-data="parksData"
              :equipments="equipments"
            />
          </VWindowItem>

          <!-- MissionFolder -->
          <VWindowItem value="mission">
            <MissionFolder
              :client-data="clientData"
              :parks="parks"
              :parks-data="parksData"
              :equipments="equipments"
              :mission-headers="missionHeaders"
            />
          </VWindowItem>

          <!-- Equipment Search -->
          <VWindowItem value="search">
            <Search
              :client-data="clientData"
              :parks="parks"
              :equipments="equipments"
            />
          </VWindowItem>
        </VWindow>
      </VCol>
    
      <VSpacer />
      <VCol cols="12">
        <Footer />
      </VCol>
    </VRow>
  </div>
</template>

<route lang="yaml">
meta:
  layout: blank
</route>

