# Contributing

This guide is **highly inspired** by the Contributing Guides of [Spatie's Open Source Projects](https://spatie.be/open-source/packages#packages).

Please read and understand the contribution guide before creating an issue or pull request.

## The Vision of the Project

The Modular Core project aims to provide a quick and easy-to-use foundation for building modular applications. The goal is to keep the Core as simple as possible, allowing it to quickly adapt when new versions of Laravel, Vue, Inertia.js, and Tailwind are released. In essence, any new features introduced in the Core should benefit the vast majority of the projects that utilize it. Following the project's philosophy, other features and functionalities can always be added through independent and dedicated modules. We have the Project's [GitHub Discussions](https://github.com/daniel-cintra/modular/discussions) environment available, and we encourage you to use it to discuss new features, improvements, and other topics related to the project before creating an issue or pull request.

## Etiquette

This project is open source, and as such, the maintainers give their free time to build and maintain the source code
held within. They make the code freely available in the hope that it will be of use to other developers. It would be
extremely unfair for them to suffer abuse or anger for their hard work.

Please be considerate towards maintainers when raising issues or presenting pull requests. Let's show the
world that developers are civilized and selfless people.

It's the duty of the maintainer to ensure that all submissions to the project are of sufficient
quality to benefit the project. Many developers have different skillsets, strengths, and weaknesses. Respect the maintainer's decision, and do not be upset or abusive if your submission is not used.

## Viability

When requesting or submitting new features, first consider whether it might be useful to others. Open
source projects are used by many developers, who **may have entirely different needs** to your own. Think about
whether or not your feature is likely to be used by other users of the project.

## Procedure

Before filing an issue:

- Attempt to replicate the problem, to ensure that it wasn't a coincidental incident.
- Check to make sure your feature suggestion isn't already present within the project.
- Check the pull requests tab to ensure that the bug doesn't have a fix in progress.
- Check the pull requests tab to ensure that the feature isn't already in progress.

Before submitting a pull request:

- Check the codebase to ensure that your feature doesn't already exist.
- Check the pull requests to ensure that another person hasn't already submitted the feature or fix.

## Requirements

If the project maintainer has any additional requirements, you will find them listed here.

- **Coding Standard** - To format the PHP code run `./vendor/bin/pint`. To lint the JavaScript code and Vue SFC, run `npm run lint`, and to format `npm run format`.

- **Add tests!** - Please **allways** provide tests .

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.

Happy coding, and thanks for being part of our community! 🎉
