<template>
    <div class="animated fadeIn">
        <form @submit.prevent="onSubmit">
            <b-row class="justify-content-center">
                <b-col xl="6">
                    <b-card>
                        <template slot="header">
                            <span class="h3">{{
                                isNew
                                    ? $t(
                                          'modules/categories.labels.titles.create'
                                      )
                                    : $t(
                                          'modules/categories.labels.titles.edit'
                                      )
                            }}</span>
                        </template>
                        <b-row class="justify-content-center">
                            <b-col xl="12">
                                <b-form-group
                                    :label="$t('validation.attributes.name')"
                                    label-for="name"
                                    :horizontal="true"
                                    :label-cols="3"
                                    :invalid-feedback="feedback('name')"
                                >
                                    <b-form-input
                                        id="name"
                                        name="name"
                                        :placeholder="
                                            $t('validation.attributes.name')
                                        "
                                        v-model="model.name"
                                        :state="state('name')"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row slot="footer">
                            <b-col>
                                <b-btn
                                    to="/categories"
                                    variant="danger"
                                    size="sm"
                                >
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
                                        (isNew &&
                                            $acl.can('create printers')) ||
                                        $acl.can('edit printers')
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

export default {
    name: 'CategoryForm',
    components: {},
    mixins: [form],
    data() {
        return {
            modelName: 'category',
            resourceRoute: 'categories',
            listPath: '/categories',
            translatables: [],
            model: {
                name: null,
            },
        }
    },
}
</script>
