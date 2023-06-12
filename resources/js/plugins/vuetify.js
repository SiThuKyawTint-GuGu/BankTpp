// Vuetify
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify  } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { md3 } from 'vuetify/blueprints'
import { aliases, mdi } from 'vuetify/iconsets/mdi'


// Components
import { VBtn } from 'vuetify/components'

export default createVuetify({
        components,
        directives,
        icons: {
            defaultSet: 'mdi',
            aliases,
            sets: {
                mdi,
            }
        },
        aliases: {
            VBtnAlt: VBtn,
            VHomeBtn: VBtn,
        },
        defaults: {
            global: {
                rounded: 'sm',
            },
            VAppBar: {
                flat: true,
            },
            VHomeBtn: {
                color: 'primary',
                height: 44,
                minWidth: 190,
            },
            VBtnAlt: {
                color: 'primary',
                height: 48,
                minWidth: 190,
                variant: 'outlined',
            },
            VSheet: {
                color: 'background',
            },
        },
        // https://next.vuetifyjs.com/features/theme/
        theme: {
            defaultTheme: 'day',
            themes: {
                darkTheme: {
                    dark: true,
                    colors: {
                        primary: '#CBAA5C',
                        secondary: '#083759',
                        background: '#212121',
                    },
                },
                day: {
                    dark: false,
                    colors: {
                        background: '#FFFFFF',
                        surface: '#FFFFFF',
                        primary: '#CBAA5C',
                        'primary-darken-1': '#3700B3',
                        secondary: '#083759',
                        'secondary-darken-1': '#018786',
                        error: '#B00020',
                        info: '#2196F3',
                        success: '#4CAF50',
                        warning: '#FB8C00',
                    }
                }
            },
        },
    }
    // https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides

)