<template>
    <div class="grid">
        <div class="item-wrapper">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Value</th>
                            <th>Units</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="credit in credits" v-bind:key="credit.ref"
                            @click="displayCreditsDetails(credit)"
                            class="data-row">
                            <td>{{ credit.purchase_date }}</td>
                            <td>{{ credit.value }}</td>
                            <td>{{ credit.units }}</td>
                            <td>
                                <label class="badge badge-danger">Credit</label>
                            </td>
                        </tr>
                        <tr v-for="consumption in creditsConsumption" v-bind:key="consumption.ref"
                            @click="displayConsumptionDetails(consumption)"
                            class="data-row">
                            <td>{{ consumption.consumption_date }}</td>
                            <td></td>
                            <td>{{ consumption.units }}</td>
                            <td>
                                <label class="badge badge-warning">Consumption</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CreditsTableComponent',
    props: [
        'credits',
        'creditsConsumption'
    ],
    methods: {
        displayCreditsDetails: function(credits) {
            this.$emit('displayCreditsDetails', credits)
        },
        displayConsumptionDetails: function(consumption) {
            this.$emit('displayConsumptionDetails', consumption)
        }

    }
}
</script>
<style scoped>
tr.data-row {
    cursor: pointer;
}
.table-responsive {
    max-height: 50em;
    overflow-y: scroll;
}
</style>