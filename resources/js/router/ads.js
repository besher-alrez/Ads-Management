import Lang from '@/i18n/lang'
import auth from '@/middlewares/auth'
import acl from '@/middlewares/acl'

export default {
    path: 'ads',
    component: {
        render(c) {
            return c('router-view')
        },
    },
    meta: {
        label: Lang.get('modules/ads.labels.titles.main'),
    },
    children: [
        {
            path: '/',
            name: 'ads',
            component: () =>
                import(/* webpackChunkName: "Printer" */ '@/views/ads/AdList'),
            meta: {
                label: Lang.get('modules/ads.labels.titles.index'),
                params: {
                    acl: {
                        permission: 'view ads',
                    },
                },
                middleware: [auth, acl],
            },
        },
        {
            path: 'create',
            name: 'ads_create',
            component: () =>
                import(/* webpackChunkName: "Printer" */ '@/views/ads/AdForm'),
            meta: {
                label: Lang.get('modules/ads.labels.titles.create'),
                params: {
                    acl: {
                        permission: 'create ads',
                    },
                },
                middleware: [auth, acl],
            },
        },
        {
            path: ':id/edit',
            name: 'ads_edit',
            component: () =>
                import(/* webpackChunkName: "Printer" */ '@/views/ads/AdForm'),
            props: true,
            meta: {
                label: Lang.get('modules/ads.labels.titles.edit'),
                params: {
                    acl: {
                        permission: 'edit ads',
                    },
                },
                middleware: [auth, acl],
            },
        },
    ],
}
