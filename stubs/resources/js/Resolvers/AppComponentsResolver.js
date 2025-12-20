const componentGroups = {
    Auth: ['AppAuthLogo', 'AppAuthShell'],
    DataTable: [
        'AppDataSearch',
        'AppDataTable',
        'AppDataTableData',
        'AppDataTableHead',
        'AppDataTableRow',
        'AppPaginator'
    ],
    Form: [
        'AppCheckbox',
        'AppCombobox',
        'AppDataSearch',
        'AppFormErrors',
        'AppInputDate',
        'AppInputFile',
        'AppInputPassword',
        'AppInputText',
        'AppLabel',
        'AppMultiCombobox',
        'AppRadioButton',
        'AppTextArea',
        'AppTipTapEditor'
    ],
    Menu: [
        'AppBreadCrumb',
        'AppBreadCrumbItem',
        'AppMenu',
        'AppMenuItem',
        'AppMenuSection'
    ],
    Message: ['AppAlert', 'AppFlashMessage', 'AppToast', 'AppTooltip'],
    Misc: ['AppButton', 'AppCard', 'AppLink', 'AppSectionHeader', 'AppTopBar'],
    Overlay: ['AppConfirmDialog', 'AppModal', 'AppSideBar']
}

export default (componentName) => {
    if (componentName.startsWith('App')) {
        for (const [group, components] of Object.entries(componentGroups)) {
            if (components.includes(componentName)) {
                return {
                    from: `@/Components/${group}/${componentName}.vue`
                }
            }
        }
    }
}
