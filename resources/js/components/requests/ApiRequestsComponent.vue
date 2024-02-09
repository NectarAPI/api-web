<template>
    <div class="grid widget-revenue-card">
        <div class="grid-body d-flex flex-column h-100">
            <div class="split-header">
                <p class="card-title">
                    <i class="mdi mdi-calendar link-icon"></i> API Requests
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
                <div class="message">
                    <p class="col-12 pb-2" v-if="errors.length">
                        <ul class="list-group">
                            <li v-for="error in errors" 
                                v-bind:key="error" 
                                class="list-group-item list-group-item-danger">{{ error }}
                            </li>
                        </ul>
                    </p>
                </div>
                <div class="overlay" v-if="errors.length"></div>
                <div id="chart">
                    <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from 'vue3-apexcharts';

export default {
    name: 'ApiRequestsComponent',
    components: { 
        apexchart: VueApexCharts,
    },
    data() {
        return {
            errors: [],
            showSpinner: false,
            series: [
                {
                    name: "Generated Tokens",
                    data: [0]
                }
            ],
            chartOptions: {
                chart: {
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#6255ff'],
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                markers: {
                    size: 1
                },
                xaxis: {
                    categories: ['-'],
                    title: {
                        text: 'Month'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Tokens'
                    },
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: -25,
                    offsetX: -5
                }
            }
        }
    },
    methods: {
        getChartData: function (chartData) {
            this.$emit('getChartData', chartData)
        },
        populateChartData: function(responseData) {
            let resp = []
            responseData.forEach(val => {
                resp.push(val['tokens'])
            })
            return resp
        },
        populateXAxis: function(responseData) {
            let resp = [], months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            responseData.forEach(val => {
                resp.push(months[val['month'] - 1] + ' ' + val['year'])
            })
            return resp
        }
    },
    async mounted() {
        let self = this
        self.showSpinner = true

        return axios 
                .get('/timelineRequests?months=6')
                .then(response => {
                    if (response.data.status.code == 200) {
                        let responseData = response.data.data
                        self.getChartData(responseData)
                        this.series = [{
                                        data: self.populateChartData(responseData)
                                    }]
                        this.chartOptions = {
                            xaxis : {
                                categories: self.populateXAxis(responseData)
                            }
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
.mt-auto {
    position: relative;
    height: 100%;
}
.overlay {
    position: absolute;
    top: 0;
    height: 100%;
    width: 100%;
    opacity: 50%;
    border-radius: 0.4em;
    z-index: 2;
    background: repeating-linear-gradient(
            45deg,
            #606dbc,
            #606dbc 10px,
            #465298 10px,
            #465298 20px
        );
}
.message {
    top: 45%;
    position: relative;
    z-index: 3;
    color: #000;
    text-align: center;
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
