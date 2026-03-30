<template>
    <Head title="Dashboard"></Head>
    <div
        class="border-neutral-4 bg-neutral-2 mt-6 flex flex-col justify-between rounded-md border px-4 py-2 shadow-2xs md:flex-row"
    >
        <div>
            <i class="ri-megaphone-line"></i>
            Welcome
            <span class="font-bold">{{ page.props.auth.user.name }}</span> !
        </div>
    </div>

    <div class="my-6 grid grid-cols-1 gap-6 md:grid-cols-3">
        <!-- User Count Card -->
        <DashboardCard
            v-if="can('Acl')"
            link="user.index"
            label="Users"
            :count="props.count.users"
            icon="ri-user-line"
            color="info"
        ></DashboardCard>

        <!-- Role Count Card -->
        <DashboardCard
            v-if="can('Acl')"
            link="aclRole.index"
            label="Roles"
            :count="props.count.roles"
            icon="ri-account-box-line"
            color="warning"
        ></DashboardCard>

        <!-- Permission Count Card -->
        <DashboardCard
            v-if="can('Acl')"
            link="aclPermission.index"
            label="Permissions"
            :count="props.count.permissions"
            icon="ri-shield-keyhole-line"
            color="success"
        ></DashboardCard>
    </div>
</template>
<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import useAuthCan from '@/Composables/useAuthCan'
import DashboardCard from '@/Pages/Dashboard/Components/DashboardCard.vue'

const page = usePage()
const { can } = useAuthCan()

const props = defineProps({
    count: {
        type: Object
    }
})
</script>
