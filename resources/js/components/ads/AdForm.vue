<template>
    <div class="animated fadeIn">
        <form @submit.prevent="onSubmit">
            <b-row class="justify-content-center">
                <b-col xl="6">
                    <b-card>
                        <template slot="header">
                            <span class="h3">{{
                                isNew
                                    ? $t('modules/ads.labels.titles.create')
                                    : $t('modules/ads.labels.titles.edit')
                            }}</span>
                        </template>
                        <b-row class="justify-content-center">
                            <b-col xl="12">
                                <b-form-group
                                    label="title"
                                    label-for="name"
                                    :horizontal="true"
                                    :label-cols="3"
                                    :invalid-feedback="feedback('title')"
                                >
                                    <b-form-input
                                        id="name"
                                        name="name"
                                        placeholder="title"
                                        v-model="model.title"
                                        :state="state('title')"
                                    ></b-form-input>
                                </b-form-group>
                                <b-form-group
                                    label="advertiser"
                                    label-for="name"
                                    :horizontal="true"
                                    :label-cols="3"
                                    :invalid-feedback="feedback('title')"
                                >
                                    <b-form-input
                                        id="advertiser"
                                        name="advertiser"
                                        placeholder="advertiser"
                                        v-model="model.advertiser"
                                        :state="state('advertiser')"
                                    ></b-form-input>
                                </b-form-group>
                                <b-form-group
                                    label="type"
                                    label-for="type"
                                    :label-cols="3"
                                    :invalid-feedback="feedback('type')"
                                    :state="state('type')"
                                >
                                    <multiselect
                                        id="type"
                                        name="type"
                                        track-by="id"
                                        :searchable="true"
                                        v-model="model.type"
                                        :options="types"
                                        :close-on-select="true"
                                        :show-labels="false"
                                        placeholder="Type"
                                    ></multiselect>
                                </b-form-group>
                                <b-form-group
                                    label="Category"
                                    label-for="category"
                                    :label-cols="3"
                                    :invalid-feedback="feedback('category')"
                                    :state="state('category')"
                                >
                                    <multiselect
                                        id="category"
                                        name="category"
                                        track-by="id"
                                        :searchable="true"
                                        label="name"
                                        v-model="model.category"
                                        :options="categories"
                                        :close-on-select="true"
                                        :show-labels="false"
                                        placeholder="Category"
                                    ></multiselect>
                                </b-form-group>
                                <b-form-group
                                    label="Tags"
                                    label-for="tag"
                                    :horizontal="true"
                                    :label-cols="3"
                                    :invalid-feedback="feedback('tags')"
                                    :state="state('tags')"
                                >
                                    <multiselect
                                        v-model="model.tags"
                                        :options="tags"
                                        id="tags"
                                        name="tags"
                                        track-by="id"
                                        label="name"
                                        :multiple="true"
                                        :taggable="true"
                                        @tag="addTag"
                                        :searchable="true"
                                        :close-on-select="false"
                                        :show-labels="false"
                                        placeholder="Tags"
                                    ></multiselect>
                                </b-form-group>
                                <b-form-group
                                    label="description"
                                    label-for="description"
                                    :label-cols="6"
                                    :invalid-feedback="feedback('description')"
                                    class="col-sm-12 col-md-12"
                                >
                                    <b-form-textarea
                                        id="description"
                                        name="description"
                                        :rows="3"
                                        :placeholder="
                                            $t(
                                                'validation.attributes.description'
                                            )
                                        "
                                        v-model="model.description"
                                        :state="state('description')"
                                    ></b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row slot="footer">
                            <b-col>
                                <b-btn to="/ads" variant="danger" size="sm">
                                    {{ $t('buttons.back') }}
                                </b-btn>
                            </b-col>
                            <b-col>
                                <b-btn
                                    type="submit"
                                    variant="success"
                                    size="sm"
                                    class="float-right"
                                    :disabled="pending"
                                    v-if="
                                        (isNew && $acl.can('create ads')) ||
                                        $acl.can('edit ads')
                                    "
                                >
                                    {{
                                        isNew
                                            ? $t('buttons.create')
                                            : $t('buttons.edit')
                                    }}
                                </b-btn>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
            </b-row>
        </form>
    </div>
</template>

<script>
import form from '@/mixins/form'
import axios from 'axios'
import Multiselect from 'vue-multiselect'

export default {
    name: 'AdForm',
    components: { Multiselect },
    mixins: [form],
    data() {
        return {
            modelName: 'ad',
            resourceRoute: 'ads',
            listPath: '/ads',
            translatables: [],
            categories: [],
            tags: [],
            types: ['Free', 'Paid'],
            model: {
                title: null,
                type: null,
                description: null,
                category: null,
                tags: [],
                advertiser: null,
            },
        }
    },
    async created() {
        let { data } = await axios.get(this.$app.route(`categories.search`), {
            params: {
                page: 1,
                perPage: 100,
                column: 'name',
            },
        })
        this.categories = data.data

        this.categories = data.data.map((item) => {
            return { id: item.id, name: item.name }
        })
        let params = {
            page: 1,
            perPage: 1000,
            column: 'name',
        }
        ;({ data } = await axios.get(this.$app.route(`tags.search`), {
            params: params,
        }))
        this.tags = data.data.map((item) => {
            return { id: item.id, name: item.name }
        })
    },

    methods: {
        addTag(newTag) {
            const tag = {
                name: newTag,
                id: 'new_' + Math.floor(Math.random() * 10000000),
            }
            this.tags.push(part)
            this.model.tags.push(part)
        },
    },
}
</script>
