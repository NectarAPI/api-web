<template>
    <div class="col-lg-8 col-md-12 equel-grid">
        <div class="grid widget-revenue-card">
            <api-requests-component
                @getChartData="getChartData($event)"
            ></api-requests-component>
            <div class="chart-summary-info">
                <h3 class="font-weight-medium">
                    {{ tokensPerMonth.toFixed(2) }} tokens/month
                </h3>
                <p class="text-gray">Average token rate</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ApiRequestsSummaryComponent",
    data() {
        return {
            tokensPerMonth: 0,
            averageTokenValuePerMonth: 0,
            currency: ""
        };
    },
    methods: {
        getChartData: function(chartData) {
            if (chartData) {
                let tokens = 0;
                chartData.forEach(element => {
                    tokens += element["tokens"];
                });

                if (chartData.length > 0) {
                    this.tokensPerMonth = tokens / chartData.length;
                }
            }
        }
    }
};
</script>
<style scoped>
.chart-summary-info {
    padding: 0 0 1em 1em;
}
</style>
