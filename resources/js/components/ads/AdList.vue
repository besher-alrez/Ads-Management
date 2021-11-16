<template>
    <div class="animated fadeIn">
        <b-card>
            <template slot="header" class="card-header">
                <span class="h3">
                    {{ $t('modules/ads.labels.titles.index') }}
                </span>
                <div class="card-header-actions" v-if="$acl.can('create ads')">
                    <b-btn
                        :to="{ name: 'ads_create' }"
                        size="sm"
                        variant="primary"
                        v-b-tooltip.hover
                        :title="$t('modules/ads.buttons.create')"
                    >
                        <font-awesome-icon
                            icon="plus-circle"
                        ></font-awesome-icon>
                    </b-btn>
                </div>
            </template>
            <b-datatable
                ref="datasource"
                @context-changed="onContextChanged"
                search-route="ads.search"
                delete-route="ads.destroy"
                :length-change="true"
                :paging="true"
                :infos="false"
                :export-data="false"
            >
                <b-table
                    ref="datatable"
                    striped
                    bordered
                    show-empty
                    stacked="md"
                    no-local-sorting
                    :empty-text="$t('labels.datatables.no_results')"
                    :empty-filtered-text="
                        $t('labels.datatables.no_matched_results')
                    "
                    :fields="fields"
                    :items="dataLoadProvider"
                    sort-by="id"
                    :sort-desc="false"
                    :busy.sync="isBusy"
                >
                    <template #cell(id)="row">
                        <router-link
                            v-if="row.item.can_edit"
                            :to="{
                                name: 'ads_edit',
                                params: { id: row.item.id },
                            }"
                            v-text="row.value"
                        ></router-link>
                        <span v-else v-text="row.value"></span>
                    </template>
                    <template #cell(actions)="row">
                        <b-btn-group>
                            <b-btn
                                v-if="row.item.can_edit"
                                size="sm"
                                variant="primary"
                                :to="{
                                    name: 'ads_edit',
                                    params: { id: row.item.id },
                                }"
                                v-b-tooltip.hover
                                :title="$t('buttons.edit')"
                            >
                                <font-awesome-icon
                                    icon="edit"
                                ></font-awesome-icon>
                            </b-btn>
                            <b-btn
                                v-if="row.item.can_delete"
                                size="sm"
                                variant="danger"
                                v-b-tooltip.hover
                                :title="$t('buttons.delete')"
                                @click.stop="onDelete(row.item.id)"
                            >
                                <font-awesome-icon
                                    icon="trash-alt"
                                ></font-awesome-icon>
                            </b-btn>
                        </b-btn-group>
                    </template>
                </b-table>
            </b-datatable>
        </b-card>
    </div>
</template>

<script>
import list from '@/mixins/list'

export default {
    name: 'AdList',
    mixins: [list],
    data() {
        return {
            isBusy: false,
            item_type: 'ad',
        }
    },
    computed: {
        fields() {
            let fields = [
                {
                    key: 'id',
                    label: this.$t('validation.attributes.id'),
                    class: 'text-center',
                    sortable: true,
                },
                {
                    key: 'title',
                    label: this.$t('validation.attributes.title'),
                    class: 'text-center',
                    sortable: true,
                },
            ]
            if (this.$acl.can('edit ads') || this.$acl.can('delete ads')) {
                fields.push({
                    key: 'actions',
                    label: this.$t('labels.actions'),
                    class: 'nowrap text-center',
                })
            }
            return fields
        },
    },
}
</script>
