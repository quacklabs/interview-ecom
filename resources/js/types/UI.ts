import type { RouteRecordRaw } from "vue-router"

interface MenuGroup {
    label: string
    items: Array<MenuItem>
    separator?: string | undefined
}
interface MenuItem {
    label: string
    icon: string
    to?: {name: string}
    url?: string | undefined,
    preventExact?: boolean
    class?: string
    badge?: string | undefined
    visible?: boolean | true
    items?: Array<MenuItem>
    disabled?: boolean | false
    target?: string
}

interface Testimonial {
    name: string
    testimony: string
    location: string
    image: string
}

export type { MenuGroup, MenuItem, Testimonial }