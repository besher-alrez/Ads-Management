import Lang from '@/i18n/lang'
import auth from '@/middlewares/auth'
import acl from '@/middlewares/acl'

export default {
    path: 'tags',
    component: {
        render(c) {
            return c('router-view')
        },
    },
    meta: {
        label: Lang.get('modules/tags.labels.titles.main'),
    },
    children: [
        {
            path: '/',
            name: 'tags',
            component: () =>
                import(
                    /* webpackChunkName: "Printer" */ '@/views/tags/TagList'
                ),
            meta: {
                label: Lang.get('modules/tags.labels.titles.index'),
                params: {
                    acl: {
                        permission: 'view tags',
                    },
                },
                middleware: [auth, acl],
            },
        },
        {
            path: 'create',
            name: 'tags_create',
            component: () =>
                import(
                    /* webpackChunkName: "Printer" */ '@/views/tags/TagForm'
                ),
            meta: {
                label: Lang.get('modules/tags.labels.titles.create'),
                params: {
                    acl: {
                        permission: 'create tags',
                    },
                },
                middleware: [auth, acl],
            },
        },
        {
            path: ':id/edit',
            name: 'tags_edit',
            component: () =>
                import(
                    /* webpackChunkName: "Printer" */ '@/views/tags/TagForm'
                ),
            props: true,
            meta: {
                label: Lang.get('modules/tags.labels.titles.edit'),
                params: {
                    acl: {
                        permission: 'edit tags',
                    },
                },
                middleware: [auth, acl],
            },
        },
    ],
}
