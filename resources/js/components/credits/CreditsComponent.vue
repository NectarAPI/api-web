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
                        :credits="credits"
                        :creditsConsumption="creditsConsumption">
                    </credits-table-component>
                </div>
            </div>
        </div>
        <div class="col-md-4 equel-grid">
            <credits-details-component
                :credits="currCredits"
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
            credits: [],
            creditsConsumption: [],
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
        },
        fetchCredits: function() {
            let self = this;

            axios
                .get("/getCredits")
                .then(function(response, status, request) {
                    if (response.data.status.code == 200) {
                        let results = response.data.data.credits
                        self.credits = results.purchase
                        self.creditsConsumption = results.consumption
                        
                        if (self.credits.length > 0) {
                            self.currCredits = self.credits[0];
                        }
                    } else {
                        self.errors.push(response.data.status.message)
                    }
                    
                })
                .finally(() => {
                    self.showSpinner = false;
                });
        }
    },
    async mounted() {
        let self = this;
        self.showSpinner = true;
        self.fetchCredits();
    }
}
</script>
