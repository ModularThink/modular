<template>
    <AppSectionHeader :title="__('Roles')" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                v-if="can('Acl: Role - Create')"
                class="btn btn-primary"
                @click="router.visit(route('aclRole.create'))"
            >
                {{ __('Create Role') }}
            </AppButton>
        </template>
    </AppSectionHeader>

    <AppDataSearch
        v-if="roles.data.length || route().params.searchTerm"
        :url="route('aclRole.index')"
        fields-to-search="name"
    ></AppDataSearch>

    <AppDataTable v-if="roles.data.length" :headers="headers">
        <template #TableBody>
            <tbody>
                <AppDataTableRow v-for="item in roles.data" :key="item.id">
                    <AppDataTableData>
                        {{ item.id }}
                    </AppDataTableData>

                    <AppDataTableData>
                        {{ item.name }}
                    </AppDataTableData>

                    <AppDataTableData>
                        <!-- role permissions -->
                        <AppTooltip
                            v-if="can('Acl: Role: Permission - Edit')"
                            :text="__('Role Permissions')"
                            class="mr-2"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    router.visit(
                                        route('aclRolePermission.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-shield-keyhole-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- edit role -->
                        <AppTooltip
                            v-if="can('Acl: Role - Edit')"
                            :text="__('Edit Role')"
                            class="mr-2"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    router.visit(
                                        route('aclRole.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-edit-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- delete role -->
                        <AppTooltip
                            v-if="can('Acl: Role - Delete')"
                            :text="__('Delete Role')"
                        >
                            <AppButton
                                class="btn btn-icon btn-destructive"
                                @click="
                                    confirmDelete(
                                        route('aclRole.destroy', item.id)
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
        :links="roles.links"
        :from="roles.from || 0"
        :to="roles.to || 0"
        :total="roles.total || 0"
        class="mt-4 justify-center"
    ></AppPaginator>

    <AppAlert v-if="!roles.data.length" class="mt-4">
        {{ __('No roles found') }}
    </AppAlert>

    <AppConfirmDialog ref="confirmDialogRef"></AppConfirmDialog>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import useAuthCan from '@/Composables/useAuthCan'

const { can } = useAuthCan()

defineProps({
    roles: {
        type: Object,
        default: () => {}
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Roles', last: true }
]

const headers = ['ID', 'Name', 'Actions']

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}
</script>
