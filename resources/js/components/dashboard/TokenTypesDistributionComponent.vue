<template>
    <div class="col-lg-4 col-md-6 equel-grid">
        <div class="grid">
            <div class="grid-body d-flex flex-column h-100">
                <div class="wrapper">
                    <div class="d-flex justify-content-between">
                        <div class="split-header">
                            <p class="card-title">
                                <i
                                    class="mdi mdi-format-list-bulleted-type link-icon"
                                ></i>
                                Token Types Distribution
                            </p>
                        </div>
                        <div class="content-wrapper v-centered">
                            <span
                                class="btn action-btn btn-refresh btn-xs component-flat">
                                <i class="mdi mdi-autorenew text-muted mdi-2x"
                                    :class="{ spin: showSpinner }"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="chart-center">
                    <div class="overlay" v-if="errors.length"></div>
                    <div id="chart">
                        <apexchart type="donut" height="350" :options="chartOptions" :series="series"></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts';

export default {
    name: 'TokenTypesDistributionComponent',
    components: { 
        apexchart: VueApexCharts,
    },
    data() {
        return {
            errors: [],
            showSpinner: false,
            series: [1],
            chartOptions: {
                chart: {
                    type: 'donut',
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                labels: ['-'],
                responsive: [{
                    options: {
                            chart: {
                            width: 350
                        },
                       
                    }
                }]
            },
        }
    },
    methods: {
        populateChartData: function(responseData) {
            let resp = []
            responseData.forEach(val => {
                resp.push(val['count'])
            })
            return resp
        },
        populateLabels: function(responseData) {
            let resp = []
            responseData.forEach(val => {
                resp.push(val['type'])
            })
            return resp
        }
    },
    async mounted() {
        let self = this
        self.showSpinner = true

        return axios 
                .get('/tokensTypesDetails')
                .then(response => {
                    if (response.data.status.code == 200) {
                        let responseData = response.data.data
                        this.series = self.populateChartData(responseData)
                        this.chartOptions = {
                            labels : self.populateLabels(responseData)
                        } 
   
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
.chart-center {
    margin: auto
}
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