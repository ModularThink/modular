<p align="center" style="margin: 24px;">
    <a href="https://ismodular.com" target="_blank">
    <img src="art/modular-github.png" alt="Modular Logo" style="width: 100%; max-width: 800px;"></a>
</p>

<center>

[![Vue v3.x](https://img.shields.io/badge/Vue.js-v3.x-2f4053?style=for-the-badge&logo=vue.js&logoColor=39af78)](https://vuejs.org/)
[![Inertia.js v2.x](https://img.shields.io/badge/Inertia.js-v2.x-6765ea?style=for-the-badge&logo=inertia&logoColor=ffffff)](https://inertiajs.com/)
[![Laravel v12.x](https://img.shields.io/badge/Laravel-v12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS v4.x](https://img.shields.io/badge/Tailwind%20CSS-v4.x-31b5f7?style=for-the-badge&logo=tailwind-css&logoColor=ffffff)](https://tailwindcss.com/)
[![Tests passing](https://img.shields.io/badge/Tests-passing-green?style=for-the-badge&logo=github)](https://github.com/daniel-cintra/modular/actions)

</center>

## Why Modular?

Starting a new web application usually means tackling a bunch of common yet crucial tasks, including:

- **Scalable Architecture:** Structuring your application in a way that scales seamlessly with growth.
- **Robust Access Control:** Crafting a granular ACL (Access Control List) to manage users and roles proficiently.
- **Intuitive Admin Panel:** Either customizing a ready-made or developing a bespoke Admin Panel to streamline your application's construction.
- **Responsive Design:** Ensuring your Admin Panel is mobile-friendly and responsive across devices.
- **Unified UI Toolkit:** Adopting or developing a UI Toolkit to fast-track frontend development while maintaining a coherent design across pages.
- **Effortless Frontend-Backend Integration:** Bridging your frontend and backend intuitively, ensuring a maintainable and straightforward connection.
- **Optimized Build Management:** Harnessing the right toolset and stack to manage your frontend application's build steps efficiently.
- **Reusable Components:** Abstracting common functionalities and components for reuse (embrace DRY - Don't Repeat Yourself), such as data search, pagination, flash messages, and more.
- **Thorough Testing Frameworks:** Implementing testing frameworks to validate your application's functionality.
- **Comprehensive Activity Log:** Keeping a detailed log to audit user operations.
- **Clear Architectural Vision:** Maintaining a lucid mental model of the project's architectural decisions, promoting consistency and a solid understanding of how all elements interlink.

The intricacies of these tasks are far from trivial, often demanding a substantial amount of time and attention. As you delve deeper, you may encounter additional minor behaviors and tweaks that, while seemingly marginal, are crucial and time-consuming.

Furthermore, more complex scenarios such as multi-faceted dashboards tailored to user profiles or intricate business rules may arise, adding layers of complexity to your project.

Modular aims to alleviate these hurdles by providing a well-structured, comprehensive solution, allowing you to focus on what truly matters - bringing your unique application to life.

## Why VILT Stack (Vue, Inertia, Laravel, Tailwind)?

The VILT Stack is a powerful combination of frameworks and tools that provide a robust foundation for building web applications. These technologies **work very well together** to deliver a seamless developer experience, enabling you to concentrate on your application's core functionalities. Moreover, after developing projects of varying sizes and complexities with different stacks, I discovered that the VILT Stack is incredibly flexible. It accommodates simple CRUD applications just as well as it does more complex UIs, with enhanced interactivity and client-side heavy business logic (interactive calendars, dynamic form fields, complex graphics, etc.). Consequently, it scales adeptly in both scenarios, proving to be a reliable choice for both small, straightforward apps and large, complex ones.

## About Modular

Modular stands on the shoulders of giants, integrating powerful frameworks and tools to offer a streamlined development experience. Here’s what lies under the hood:

- [Vue 3](https://vuejs.org/) (Drives custom frontend components)
- [Inertia.js](https://inertiajs.com/) (Bridges the gap between frontend and backend)
- [Laravel 12](https://laravel.com/) (Empowers the backend)
- [Tailwind CSS 4](https://tailwindcss.com/) (Styles with ease)
- [Vite](https://vitejs.dev/) (Accelerates frontend tooling)

When you bring Modular into your Laravel application, here’s a taste of what you'll unlock:

- A **Themed Admin Panel** seamlessly integrated with Tailwind CSS, ready to assist you in crafting your application.
- A finely-tuned **ACL (Access Control List) System** to effortlessly manage users and roles.
- A suite of auto-loaded **Custom Vue 3 Components**, penned in **JavaScript**, and tailored with Tailwind CSS; ready for use.
- Vite for a **lightning-fast frontend development** journey.
- Inertia.js to ensure a smooth frontend and backend connection, **simplifying routing and component data hydration**, among other benefits.
- A **custom-built CLI** to swiftly generate new modules; propelling your **development speed**.
- A comprehensive **translation system** ready to help your application speak the world's languages (if needed).
- **Build steps** for your frontend application are set, pre-configured, and ready to roll from the get-go, with the right tooling and stack to keep the momentum high.
- A **developer experience** designed to leave a grin on your face at the end of each coding day ;)

## Custom Vue 3 Components

In previous iterations of Modular, I leveraged robust UI Toolkits like Vuetify and Prime Vue. While these are excellent options, a desire for more control over the components led to a change, guided by the following criteria:

- Adoption of Vue 3 as the primary JavaScript framework.
- Employment of Tailwind CSS for styling purposes.
- Seamless integration of Custom Vue 3 Components with the Tailwind Theme System.
- Easy customization of components by merely editing them. To facilitate this, components reside not in node_modules, but in "./resources/js/Components". Need some tweaking? Open the component, modify the Tailwind CSS classes, and save it. Done.
- No use of Sass, Less, Stylus, etc. Tailwind CSS exclusively.
- No TypeScript. Pure JavaScript only.
- Light and exceedingly straightforward Common Components. If necessary, extend or create new components per project to imbue additional functionality.

At present, Modular furnishes the following Custom Vue 3 Components:

```bash
./resources/js/Components
.
├── Auth
│   ├── AppAuthLogo.vue
│   └── AppAuthShell.vue
├── DataTable
│   ├── AppDataSearch.vue
│   ├── AppDataTable.vue
│   ├── AppDataTableData.vue
│   ├── AppDataTableHead.vue
│   ├── AppDataTableRow.vue
│   └── AppPaginator.vue
├── Form
│   ├── AppCheckbox.vue
│   ├── AppCombobox.vue
│   ├── AppFormErrors.vue
│   ├── AppInputDate.vue
│   ├── AppInputFile.vue
│   ├── AppInputPassword.vue
│   ├── AppInputText.vue
│   ├── AppLabel.vue
│   ├── AppRadioButton.vue
│   ├── AppTextArea.vue
│   ├── AppTipTapEditor.vue
│   └── TipTap
│       ├── TipTapButton.vue
│       ├── TipTapDivider.vue
│       └── extension-file-upload.js
├── Menu
│   ├── AppBreadCrumb.vue
│   ├── AppBreadCrumbItem.vue
│   ├── AppMenu.vue
│   ├── AppMenuItem.vue
│   └── AppMenuSection.vue
├── Message
│   ├── AppAlert.vue
│   ├── AppFlashMessage.vue
│   ├── AppToast.vue
│   └── AppTooltip.vue
├── Misc
│   ├── AppButton.vue
│   ├── AppCard.vue
│   ├── AppImageNotAvailable.vue
│   ├── AppLink.vue
│   ├── AppSectionHeader.vue
│   └── AppTopBar.vue
└── Overlay
    ├── AppConfirmDialog.vue
    ├── AppModal.vue
    └── AppSideBar.vue
```

Each of these components **is crafted to integrate seamlessly with Modular**, ensuring the most straightforward developer experience possible.

## Documentation

You can find the Modular documentation at [https://docs.ismodular.com](https://docs.ismodular.com).

## Demo App

You can find the Modular Demo App at [https://demo.ismodular.com](https://demo.ismodular.com).

And the repository for the demo app at [https://github.com/daniel-cintra/modular-demo](https://github.com/daniel-cintra/modular-demo).

## Site

You can find the Modular Site at [https://ismodular.com](https://ismodular.com).

## Roadmap

You can find the Modular Roadmap at [https://docs.ismodular.com/roadmap.html](https://docs.ismodular.com/roadmap.html).

## Contributing

Please read and understand the [Contribution Guide](/CONTRIBUTING.md) before creating an issue or pull request.

## License

The Modular Project is open-source software licensed under the [MIT license](LICENSE.md).
