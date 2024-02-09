<template>
    <div class="col-lg-8 col-md-12 equel-grid">
        <div class="grid widget-revenue-card">
            <div class="grid-body d-flex flex-column h-100">
                <div class="split-header">
                    <p class="card-title">
                        <i class="mdi mdi-blur link-icon"></i> Credits Utilization
                    </p>
                    <div class="content-wrapper v-centered">
                        <span
                            class="btn action-btn btn-refresh btn-xs component-flat">
                            <i class="mdi mdi-autorenew text-muted mdi-2x"
                                :class="{ spin: showSpinner }"></i>
                        </span>
                    </div>
                </div>
                <div class="mt-auto">
                     <div id="chart">
                        <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from 'vue3-apexcharts';

export default {
    name: 'CreditsDistributionComponent' ,
    components: { 
        apexchart: VueApexCharts,
    },
    data() {
        return {
            errors: [],
            showSpinner: false,
            series: [{
                    name: 'Credits',
                    data: [0]
                }, {
                    name: 'Consumption',
                    data: [0]
            }],
            chartOptions: {
                chart: {
                    toolbar: {
                        show: false
                    },
                    height: 350,
                    type: 'bar'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    type: 'datetime',
                    categories: ["01/01/72 00:00"]
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
            },
        }

    },
    methods: {
        populateChartData: function(responseData) {
            let creditsData = []
            let creditsConsumptionData = []

            let credits = responseData['credits']
            let creditsConsumption = responseData['consumption']

            let len, i, index = 0
            let creditsConsumptionFound = false

            credits.forEach(val => {
                creditsData.push(val['units'])

                creditsConsumption.forEach(cval => {
                    if (cval['year'] == val['year'] &&
                        cval['month'] == val['month']) {
                            creditsConsumptionData.push(cval['units'])
                            creditsConsumptionFound = true
                        }
                })

                if (!creditsConsumptionFound) {
                    creditsConsumptionData.push(0)
                }

                index++
            })

            for (len = creditsConsumption.length, i = index; i < len; ++i) {
                creditsConsumptionData.push(creditsConsumption[i]['units'])
            }

            this.series = [{
                                name: 'Credits',
                                data: creditsData
                            }, {
                                name: 'Consumption',
                                data: creditsConsumptionData
                            }]

        },
        populateXAxis: function(responseData) {
            let credits = responseData['credits']
            let creditsConsumption = responseData['consumption']

            let categories = []

            credits.forEach(val => {
                categories.push(val['year'] + '-' + (val['month']))

            })

            creditsConsumption.forEach(val => {
                let cval = val['year'] + '-' + (val['month'])
                if (!categories.includes(cval)) {
                    categories.push(cval)
                }
            })
            this.chartOptions = {
                 xaxis: {
                    type: 'datetime',
                    categories: categories
                },
            }
            
        }
    },
    async mounted() {
        let self = this
        self.showSpinner = true

        return axios 
                .get('/timelineCreditsCreditsConsumption')
                .then(response => {
                    if (response.data.status.code == 200) {
                        let responseData = response.data.data
                        self.populateChartData(responseData)
                        self.populateXAxis(responseData)
   
                    } else {
                        self.errors.push(response.data.status.message)
                        
                    }
                }).finally(() => {
                    self.showSpinner = false
                })
    }
}
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