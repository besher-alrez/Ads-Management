import Lang from '@/i18n/lang'
import auth from '@/middlewares/auth'
import acl from '@/middlewares/acl'

export default {
    path: 'categories',
    component: {
        render(c) {
            return c('router-view')
        },
    },
    meta: {
        label: Lang.get('modules/categories.labels.titles.main'),
    },
    children: [
        {
            path: '/',
            name: 'categories',
            component: () =>
                import(
                    /* webpackChunkName: "Printer" */ '@/views/categories/CategoryList'
                ),
            meta: {
                label: Lang.get('modules/categories.labels.titles.index'),
                params: {
                    acl: {
                        permission: 'view categories',
                    },
                },
                middleware: [auth, acl],
            },
        },
        {
            path: 'create',
            name: 'categories_create',
            component: () =>
                import(
                    /* webpackChunkName: "Printer" */ '@/views/categories/CategoryForm'
                ),
            meta: {
                label: Lang.get('modules/categories.labels.titles.create'),
                params: {
                    acl: {
                        permission: 'create categories',
                    },
                },
                middleware: [auth, acl],
            },
        },
        {
            path: ':id/edit',
            name: 'categories_edit',
            component: () =>
                import(
                    /* webpackChunkName: "Printer" */ '@/views/categories/CategoryForm'
                ),
            props: true,
            meta: {
                label: Lang.get('modules/categories.labels.titles.edit'),
                params: {
                    acl: {
                        permission: 'edit categories',
                    },
                },
                middleware: [auth, acl],
            },
        },
    ],
}
