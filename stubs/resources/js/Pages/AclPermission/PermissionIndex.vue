<template>
    <AppSectionHeader :title="__('Permissions')" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                v-if="can('Acl: Permission - Create')"
                class="btn btn-primary"
                @click="router.visit(route('aclPermission.create'))"
            >
                {{ __('Create Permission') }}
            </AppButton>
        </template>
    </AppSectionHeader>

    <AppDataSearch
        v-if="permissions.data.length || route().params.searchTerm"
        :url="route('aclPermission.index')"
        fields-to-search="name"
    ></AppDataSearch>

    <AppDataTable v-if="permissions.data.length" :headers="headers">
        <template #TableBody>
            <tbody>
                <AppDataTableRow
                    v-for="item in permissions.data"
                    :key="item.id"
                >
                    <AppDataTableData>
                        {{ item.id }}
                    </AppDataTableData>

                    <AppDataTableData>
                        {{ item.name }}
                    </AppDataTableData>

                    <AppDataTableData>
                        <!-- edit permission -->
                        <AppTooltip
                            v-if="can('Acl: Permission - Edit')"
                            :text="__('Edit Permission')"
                            class="mr-2"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    router.visit(
                                        route('aclPermission.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-edit-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- delete permission -->
                        <AppTooltip
                            v-if="can('Acl: Permission - Delete')"
                            :text="__('Delete Permission')"
                        >
                            <AppButton
                                class="btn btn-icon btn-destructive"
                                @click="
                                    confirmDelete(
                                        route('aclPermission.destroy', item.id)
                                    )
                                "
                            >
                                <i class="ri-delete-bin-line"></i>
                            </AppButton>
                        </AppTooltip>
                    </AppDataTableData>
                </AppDataTableRow>
            </tbody>
        </template>
    </AppDataTable>

    <AppPaginator
        :links="permissions.links"
        :from="permissions.from || 0"
        :to="permissions.to || 0"
        :total="permissions.total || 0"
        class="mt-4 justify-center"
    ></AppPaginator>

    <AppAlert v-if="!permissions.data.length" class="mt-4">
        {{ __('No permissions found.') }}
    </AppAlert>

    <AppConfirmDialog ref="confirmDialogRef"></AppConfirmDialog>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import useAuthCan from '@/Composables/useAuthCan'

const { can } = useAuthCan()

defineProps({
    permissions: {
        type: Object,
        default: () => {}
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Permissions', last: true }
]

const headers = ['ID', 'Name', 'Actions']

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}
</script>
