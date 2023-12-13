<template>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
            <div class="grid">
                <div class="grid-body text-gray">
                    <p class="text-black col-sm-12 col-6">Token Types</p>
                     <div class="spinner content-wrapper v-centered">
                        <span
                            class="btn action-btn btn-refresh btn-xs component-flat">
                            <i class="mdi mdi-autorenew text-muted mdi-2x"
                                :class="{ spin: showTypesOfTokensSpinner }"></i>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="metrics-elem">
                            {{ typesOfTokens }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
            <div class="grid">
                <div class="grid-body text-gray">
                    <p class="text-black col-sm-12 col-6">Generated Tokens</p>
                    <div class="spinner content-wrapper v-centered">
                        <span
                            class="btn action-btn btn-refresh btn-xs component-flat">
                            <i class="mdi mdi-autorenew text-muted mdi-2x"
                                :class="{ spin: showNoOfGeneratedTokensSpinner }"></i>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="metrics-elem">
                            {{ noOfGeneratedTokens }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
            <div class="grid">
                <div class="grid-body text-gray">
                    <p class="text-black col-md-12 col-6">Unique Meters</p>
                    <div class="spinner content-wrapper v-centered">
                        <span
                            class="btn action-btn btn-refresh btn-xs component-flat">
                            <i class="mdi mdi-autorenew text-muted mdi-2x"
                                :class="{ spin: showoOfUniqueMetersSpinner }"></i>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="metrics-elem">
                        {{ noOfUniqueMeters }} </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
            <div class="grid">
                <div class="grid-body text-gray">
                    <p class="text-black col-md-12 col-6">Loaded Value</p>
                    <div class="spinner content-wrapper v-centered">
                        <span
                            class="btn action-btn btn-refresh btn-xs component-flat">
                            <i class="mdi mdi-autorenew text-muted mdi-2x"
                                :class="{ spin: showTokensPaymentsValueSpinner }"></i>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="metrics-elem">
                            {{ tokensPaymentsValue }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'MetricsComponent',
    data() {
        return {
            showTypesOfTokensSpinner: false,
            showNoOfGeneratedTokensSpinner: false,
            showoOfUniqueMetersSpinner: false,
            showTokensPaymentsValueSpinner: false,
            typesOfTokens: 0,
            noOfGeneratedTokens: 0,
            noOfUniqueMeters: 0,
            tokensPaymentsValue: 0
        }
    },
    methods: {
        getTypesOfTokens: function() {
            this.showTypesOfTokensSpinner = true
            this.makeRequest('/typesOfTokens').then(data => {
                this.typesOfTokens = data
                this.showTypesOfTokensSpinner = false
            })
        },
        getNoOfGeneratedTokens: function() {
            this.showNoOfGeneratedTokensSpinner = true
            this.makeRequest('/noOfGeneratedTokens').then(data => {
                this.noOfGeneratedTokens = data
                this.showNoOfGeneratedTokensSpinner = false
            })
        },
        getNoOfUniqueMeters: function() {
            this.showoOfUniqueMetersSpinner = true
            this.makeRequest('/noOfUniqueMeters').then(data => {
                this.noOfUniqueMeters = data
                this.showoOfUniqueMetersSpinner = false
            })
        },
        getTokensPaymentsValue: function() {
            this.showTokensPaymentsValueSpinner = true
            this.makeRequest('/tokensPaymentsTotal').then(data => {
                this.tokensPaymentsValue = data
                this.showTokensPaymentsValueSpinner = false
            })
        },
        async makeRequest(url) {
            return axios 
                .get(url)
                .then(response => {
                    if (response.data.status.code == 200) {
                        return response.data.data

                    } else {
                        self.errors.push(response.data.status.message)
                        
                    }

                })
        }
    },
    async mounted() {
        let self = this

        self.getTypesOfTokens()
        self.getNoOfGeneratedTokens()
        self.getNoOfUniqueMeters()
        self.getTokensPaymentsValue()
    }
}
</script>
<style scoped>
.metrics-elem {
    font-size: 2em;
    font-weight: bold;
}
.text-black {
    padding-left: 0;
}
.spinner {
    float: right;
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