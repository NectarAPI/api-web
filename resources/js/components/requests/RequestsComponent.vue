<template>
    <div class="row">
        <div class="col-lg-8 col-md-12 equel-grid">
            <api-requests-component></api-requests-component>
        </div>
        <div class="col-lg-4 col-md-6 equel-grid">
            <summary-component></summary-component>
        </div>
        <div class="col-md-8 equel-grid">
            <requests-table-component
                @displayRequestDetails="displayRequestDetails($event)"
            >
            </requests-table-component>
        </div>
        <div class="col-md-4 equel-grid">
            <request-details-component
                v-if="currRequest"
                :request="currRequest">
            </request-details-component>
        </div>
    </div>
</template>
<script>
export default {
    name: 'RequestsComponent',
    data() {
        return {
            errors: [],
            currRequest: null
        }
    },
    methods: {
        displayRequestDetails: function(selectedRequest) {
            this.currRequest = selectedRequest
        },

    },
    
}
</script>
