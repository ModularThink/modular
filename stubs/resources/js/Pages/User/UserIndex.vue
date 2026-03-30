<template>
    <AppSectionHeader :title="__('Users')" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                v-if="can('Acl: User - Create')"
                class="btn btn-primary"
                @click="router.visit(route('user.create'))"
            >
                {{ __('Create User') }}
            </AppButton>
        </template>
    </AppSectionHeader>

    <AppDataSearch
        v-if="users.data.length || route().params.searchTerm"
        :url="route('user.index')"
        fields-to-search="name"
    ></AppDataSearch>

    <AppDataTable v-if="users.data.length" :headers="headers">
        <template #TableBody>
            <tbody>
                <AppDataTableRow v-for="item in users.data" :key="item.id">
                    <AppDataTableData>
                        {{ item.id }}
                    </AppDataTableData>

                    <AppDataTableData>
                        {{ item.name }}
                    </AppDataTableData>

                    <AppDataTableData>
                        {{ item.email }}
                    </AppDataTableData>

                    <AppDataTableData>
                        <!-- edit user roles -->
                        <AppTooltip
                            v-if="can('Acl: User: Role - Edit')"
                            :text="__('User Roles')"
                            class="mr-2"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    router.visit(
                                        route('aclUserRole.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-account-box-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- edit user permissions -->
                        <AppTooltip
                            v-if="can('Acl: User: Permission - Edit')"
                            :text="__('User Permissions')"
                            class="mr-2"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    router.visit(
                                        route('aclUserPermission.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-shield-keyhole-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- edit user -->
                        <AppTooltip
                            v-if="can('Acl: User - Edit')"
                            :text="__('Edit User')"
                            class="mr-2"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    router.visit(route('user.edit', item.id))
                                "
                            >
                                <i class="ri-edit-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- delete user -->
                        <AppTooltip
                            v-if="can('Acl: User - Delete')"
                            :text="__('Delete User')"
                        >
                            <AppButton
                                class="btn btn-icon btn-destructive"
                                @click="
                                    confirmDelete(
                                        route('user.destroy', item.id)
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
        :links="users.links"
        :from="users.from || 0"
        :to="users.to || 0"
        :total="users.total || 0"
        class="mt-4 justify-center"
    ></AppPaginator>

    <AppAlert v-if="!users.data.length" class="mt-4">
        {{ __('No users found') }}
    </AppAlert>

    <AppConfirmDialog ref="confirmDialogRef"></AppConfirmDialog>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import useAuthCan from '@/Composables/useAuthCan'

const { can } = useAuthCan()

defineProps({
    users: {
        type: Object,
        default: () => {}
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Users', last: true }
]

const headers = ['ID', 'Name', 'Email', 'Actions']

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}
</script>
