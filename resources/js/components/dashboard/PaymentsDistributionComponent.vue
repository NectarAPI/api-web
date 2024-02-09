<template>
    <div class="col-lg-4 col-md-6 equel-grid">
        <div class="grid">
            <div class="grid-body">
                <div class="split-header">
                    <p class="card-title">
                        <i class="mdi mdi-sort-variant"></i> Payments Results
                        Distribution
                    </p>
                    <div class="content-wrapper v-centered">
                        <span
                            class="btn action-btn btn-refresh btn-xs component-flat"
                        >
                            <i
                                class="mdi mdi-autorenew text-muted mdi-2x"
                                :class="{ spin: showSpinner }"
                            ></i>
                        </span>
                    </div>
                </div>
                <div id="chart">
                    <apexchart
                        type="bar"
                        height="350"
                        :options="chartOptions"
                        :series="series"
                    ></apexchart>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from "vue3-apexcharts";

export default {
    name: "PaymentsDistributionComponent",
    components: {
        apexchart: VueApexCharts
    },
    data() {
        return {
            errors: [],
            showSpinner: false,
            series: [
                {
                    name: "Payments",
                    data: [0]
                }
            ],
            chartOptions: {
                chart: {
                    toolbar: {
                        show: false
                    },
                    type: "bar",
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ["-"]
                }
            }
        };
    },
    methods: {
        populateChartData: function(responseData) {
            let resp = [];
            responseData.forEach(val => {
                if (val["value"] == null) {
                    resp.push(0);
                } else {
                    resp.push(val["value"]);
                }
            });
            return resp;
        },
        populateLabels: function(responseData) {
            let resp = [];
            responseData.forEach(val => {
                if (val["result"] == null) {
                    resp.push("Unknown");
                } else {
                    resp.push(val["result"]);
                }
            });
            return resp;
        }
    },
    async mounted() {
        let self = this;
        self.showSpinner = true;

        return axios
            .get("/paymentResultsDistribution")
            .then(response => {
                if (response.data.status.code == 200) {
                    let responseData = response.data.data;
                    this.series = [
                        {
                            data: self.populateChartData(responseData)
                        }
                    ];
                    this.chartOptions = {
                        xaxis: {
                            categories: self.populateLabels(responseData)
                        }
                    };
                } else {
                    self.errors.push(response.data.status.message);
                }
            })
            .finally(() => {
                self.showSpinner = false;
            });
    }
};
</script>
<style scoped>
@keyframes spin-animation {
    to {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
.spin:before {
    display: block;
    transform-origin: center center;
    -webkit-backface-visibility: hidden;
    -webkit-animation: spin-animation 2s linear infinite;
    animation: spin-animation 2s linear infinite;
}
</style>
