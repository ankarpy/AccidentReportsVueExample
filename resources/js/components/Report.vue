<template>
    <div class="row justify-content-center report">
        <div class="col-md-12">
            <div class="card">
                <form class="card-body" v-if="editing" @submit.prevent="update">
                    <div class="card-title">
                        <div class="form-group">
                            <span>Report Title</span>
                            <input type="text" class="form-field" placeholder="Summarize the report" v-model="title">
                        </div>

                    </div>

                    <hr>

                    <div class="media">
                        <div class="media-body">
                            <div class="form-group">
                                <textarea rows="10" v-model="body" class="form-field" required placeholder="Describe the incident"></textarea>
                            </div>
                            <div class="form-group">
                                <span>Vehicle Id</span>
                                <input class="form-field" v-model="vehicleId" type="text" placeholder="The vehicle which was involved in the accident">
                            </div>
                            <div class="form-group">
                                <span>Injured count</span>
                                <input class="form-field" v-model="injuredCount" type="text" placeholder="The number of passengers involved in the accident">
                            </div>
                            <div class="form-group">
                                <span>Date of Accident</span>
                                <b-form-datepicker id="example-datepicker" v-model="happenedAt" class="mb-2 form-field"
                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                locale="en"></b-form-datepicker>
                            </div>
                            <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                            <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
                        </div>
                    </div>
                </form>
                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ title }}</h1>

                        </div>
                    </div>

                    <hr>

                    <div class="media">

                        <div class="media-body">
                            <div v-html="bodyHtml"></div>


                            <div class="accident-info">
                                <div><div v-html="vehicleIdHtml"></div></div>
                                <div><div v-html="injuredCountHtml"></div></div>
                                <div><div v-html="happenedAtHtml"></div></div>
                            </div>
                            <hr/>

                            <div class="row">
                                <div class="col-4 actions">
                                    <div>
                                        <a v-if="authorize('modify', report)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                                        <button v-if="authorize('deleteReport', report)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4 text-right">
                                    <user-info :model="report" label="Created"></user-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserInfo from './UserInfo.vue';

export default {
    props: ['report'],

    components: {  UserInfo },

    data () {
        return {
            title: this.report.title,
            body: this.report.body,
            bodyHtml: this.report.body_html,
            vehicleId: this.report.vehicle_id,
            injuredCount: this.report.injured_count,
            happenedAt: this.report.happened_at,

            vehicleIdHtml: 'Vehicle - <b>' + this.report.vehicle_id + '</b>',
            injuredCountHtml: 'Injured - <b>' + this.report.injured_count + '</b>',
            happenedAtHtml: 'Date - <b>' + this.report.happened_at + '</b>',

            editing: false,
            id: this.report.id,
            beforeEditCache: {},
        }
    },

    computed: {
        isInvalid () {
            return this.body.length < 1 || this.title.length < 1;
        },

        endpoint () {
            return `/reports/${this.id}`;
        }
    },

    methods: {
        edit () {
            this.beforeEditCache = {
                body: this.body,
                title: this.title,
                vehicleId: this.vehicleId,
                injuredCount: this.injuredCount,
                happenedAt: this.happenedAt,
            };
            this.editing = true;
        },

        cancel () {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
            this.vehicleId = this.beforeEditCache.vehicleId;
            this.injuredCount = this.beforeEditCache.injuredCount;
            this.happenedAt = this.beforeEditCache.happenedAt;

            this.editing = false;
        },

        update () {
            axios.put(this.endpoint, {
                body: this.body,
                title: this.title,
                vehicle_id: this.vehicleId,
                injured_count: this.injuredCount,
                happened_at: this.happenedAt,
            })
                .catch(({response}) => {
                    this.$toast.error(response.data.message, "Error", { timeout: 3000 });
                })
                .then(({data}) => {
                    this.bodyHtml = data.body_html;
                    this.$toast.success(data.message, "Success", { timeout: 3000 });
                    this.editing = false;
                })
        },

        destroy () {
            this.$toast.question('Are you sure about that?', "Confirm", {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'report',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {

                        axios.delete(this.endpoint)
                            .then(({data}) => {
                                this.$toast.success(data.message, "Success", { timeout: 2000 });

                                $(this.$el).fadeOut(500, () => {
                                    this.$emit('deleted');
                                })

                            });


                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });
        }
    }
}
</script>
