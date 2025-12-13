import js from '@eslint/js'
import vue from 'eslint-plugin-vue'
import prettierConfig from 'eslint-config-prettier'
import globals from 'globals'

export default [
    // Base ESLint recommended rules
    js.configs.recommended,

    // Vue recommended rules (uses flat config)
    ...vue.configs['flat/recommended'],

    // Prettier configuration to disable conflicting rules
    {
        rules: {
            ...prettierConfig.rules,
            'unicode-bom': 'off'
        }
    },

    // Vue specific rule overrides
    {
        files: ['**/*.vue'],
        rules: {
            '@stylistic/js/indent': 'off',
            '@stylistic/js/quotes': 'off',

            // Disable specific Vue rules
            'vue/no-v-html': 'off',
            'vue/comment-directive': 'off',
            'vue/no-v-text-v-html-on-component': 'off'
        }
    },

    // Global variables
    {
        languageOptions: {
            globals: {
                ...globals.browser,
                route: 'readonly',
                grecaptcha: 'readonly'
            }
        }
    },

    // Ignore patterns
    {
        ignores: ['node_modules/*', 'vendor/*', 'public/*']
    }
]
