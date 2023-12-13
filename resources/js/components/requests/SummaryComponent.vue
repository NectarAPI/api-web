<template>
    <div class="grid">
        <div class="grid-body d-flex flex-column h-100">
            <div class="wrapper">
                <div class="d-flex justify-content-between">
                    <div class="split-header">
                        <p class="card-title">
                            <i
                                class="mdi mdi-format-list-bulleted-type link-icon"
                            ></i>
                            Summary
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-auto">
                <div class="row">
                    <div class="col-lg-6 col-md-12 pt-4">
                        <h3 class="font-weight-medium">Configs</h3>
                        <p class="text-gray">
                            <i class="mdi mdi-view-headline"></i> {{ noOfConfigurations }}
                        </p>
                        <small class="text-muted">No of configurations</small>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-4">
                        <h3 class="font-weight-medium">Generated</h3>
                        <p class="text-gray">
                            <i class="mdi mdi-xml"></i> {{ noOfGeneratedTokens }}
                        </p>
                        <small class="text-muted">No of generated tokens</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 pt-4">
                        <h3 class="font-weight-medium">Credentials</h3>
                        <p class="text-gray">
                            <i class="mdi mdi-close-octagon-outline"></i> {{ noOfCredentials }}
                        </p>
                        <small class="text-muted">No of credentials</small>
                    </div>
                   
                    <div class="col-lg-6 col-md-12 pt-4">
                        <h3 class="font-weight-medium">Credits</h3>
                        <p class="text-gray">
                            <i class="mdi mdi-credit-card"></i> {{ noOfCreditsUsed }}
                        </p>
                        <small class="text-muted"
                            >No of credits used</small
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 pt-4">
                        <h3 class="font-weight-medium">Types</h3>
                        <p class="text-gray">
                            <i class="mdi mdi-format-list-bulleted-type"></i>
                            {{ typesOfTokens }}
                        </p>
                        <small class="text-muted">Types of tokens</small>
                    </div>
                     <div class="col-lg-6 col-md-12 pt-4">
                        <h3 class="font-weight-medium">Meters</h3>
                        <p class="text-gray">
                            <i class="mdi mdi-speedometer"></i> {{ noOfUniqueMeters }}
                        </p>
                        <small class="text-muted">No of unique meters</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'SummaryComponent',
    data() {
        return {
            noOfConfigurations: 0,
            noOfGeneratedTokens: 0,
            noOfCredentials: 0,
            noOfCreditsUsed: 0,
            typesOfTokens: 0,
            noOfUniqueMeters: 0
        }
    },
    methods: {
        getNoOfConfigurations: function() {
            this.makeRequest('/noOfConfigurations').then(data => {
                 this.noOfConfigurations = data
            })
        },
        getNoOfGeneratedTokens: function() {
            this.makeRequest('/noOfGeneratedTokens').then(data => {
                this.noOfGeneratedTokens = data
            })
        },
        getNoOfCredentials: function() {
            this.makeRequest('/noOfCredentials').then(data => {
                this.noOfCredentials = data
            })
        },
        getNoOfCreditsUsed: function() {
            this.makeRequest('/noOfCredits').then(data => {
                this.noOfCreditsUsed = data
            })
        },
        getTypesOfTokens: function() {
            this.makeRequest('/typesOfTokens').then(data => {
                this.typesOfTokens = data
            })
        },
        getNoOfUniqueMeters: function() {
                this.makeRequest('/noOfUniqueMeters').then(data => {
                    this.noOfUniqueMeters = data
                })
        },
        makeRequest: function(url) {
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
        
        self.getNoOfConfigurations()
        self.getNoOfGeneratedTokens()
        self.getNoOfCredentials()
        self.getNoOfCreditsUsed()
        self.getTypesOfTokens()
        self.getNoOfUniqueMeters()

    }
}
</script>