<template>
    <div class="row">
        <div class="col-md-8 equel-grid">
            <div class="grid">
                <div class="grid-body py-3">
                    <div class="row">
                        <div class="col-10">
                            <p class="card-title ml-n1">Transactions</p>
                        </div>
                        <!-- <div class="col-2">
                            <div class="btn btn-success has-icon">
                                <i class="mdi mdi-plus"></i>Buy
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-12">
                    <credits-table-component
                        @displayCreditsDetails="displayCreditsDetails($event)"
                        @displayConsumptionDetails="displayConsumptionDetails($event)"
                        :currCredits="currCredits">
                    </credits-table-component>
                </div>
            </div>
        </div>
        <div class="col-md-4 equel-grid">
            <credits-details-component
                v-if="currCredits"
                :credits="currCredits">
            </credits-details-component>
            <credits-details-component
                v-if="currConsumption"
                :consumption="currConsumption">
            </credits-details-component>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CreditsComponent',
    data() {
        return {
            currCredits: null,
            currConsumption: null
        }
    },
    methods: {
        displayCreditsDetails: function(credits) {
            this.currConsumption = null
            this.currCredits = credits
        },
        displayConsumptionDetails: function(consumption) {
            this.currCredits = null
            this.currConsumption = consumption
        }
    }
}
</script>
