<template>
    <div v-cloak v-if="count">
        <report @deleted="remove(index)" v-for="(report, index) in reports"  :report="report" :key="report.id"></report>

        <div class="text-center mt-3" v-if="nextUrl">

            <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more reports</button>
        </div>
    </div>
    <div v-cloak v-else-if="noReports">
        <div class="alert alert-warning">
            <strong>Sorry</strong> There are no questions available.
        </div>
    </div>


</template>

<script>
import Report from './Report.vue';

export default {
    props: ['report'],

    data () {
        return {
            reports: [],
            count: 0,
            nextUrl: null,
            noReports: false,
        }
    },

    created () {
        this.fetch(`/reports/fetch`);
    },

    methods: {

        remove (index) {
            this.reports.splice(index, 1);
            this.count--;
        },
        fetch (endpoint) {
            axios.get(endpoint)
                .then(({data}) => {

                    this.reports.push(...data.data);
                    this.nextUrl = data.next_page_url;
                    this.count = this.reports.length;

                    if (this.count == 0){
                        this.noReports = true;
                    }

                    console.log(data)

                })
        }
    },

    computed: {
        title () {
            return this.count + " " + (this.count > 1 ? 'Reports' : 'Report');
        }
    },

    components: { Report }
}
</script>
