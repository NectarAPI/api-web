<template>
    <div class="modal fade" 
        tabindex="-1" 
        id="activate-deactivate-configuration-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm</h5>
                    <button type="button" @click="resetActivateDeactivateConfigurationsModal" 
                            class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 text-center mb-2">
                        <p v-if="errors.length">
                            <ul class="list-group">
                                <li v-for="error in errors" 
                                    v-bind:key="error" 
                                    class="list-group-item list-group-item-danger">{{ error }}
                                </li>
                            </ul>
                        </p>
                    </div>
                    <form ref="form" id="editConfigurationForm">
                        <input type="hidden" name="configuration_activated_status" 
                                id="key_activated_status" :value="configuration.config.activated" />
                        <p>Are you sure that you would like to 
                            <span v-if="configuration.config.activated">
                                deactivate
                            </span>
                            <span v-else>
                                activate
                            </span>
                            configuration {{ configuration.config.name }}?
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                        @click="resetActivateDeactivateCredentialsModal" data-dismiss="modal">Cancel</button>
                    <button type="button" :disabled="buttonSubmitDisabled" 
                        @click="resetActivateDeactivateConfigurationsModal" class="btn btn-primary">
                        Save &nbsp;&nbsp;   
                        <div v-if="saveSpinner" 
                            id="save-spinner" 
                                class="spinner-border text-secondary" 
                                role="status">
                                <span class="sr-only">Loading...</span>
                        </div> 
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "EditConfigurationComponent",
    props: [
        'configuration'
    ],
    data() {
        return {
            errors: [],
            showSpinner: false,
            buttonSubmitDisabled: false,
            inputDisabled: false
        };
    },
    methods: {
        resetActivateDeactivateConfigurationsModal: function() {
            this.errors = []
        },
        activateConfiguration: function(config, state) {
            let self = this

            self.errors = []
            self.showSpinner = true
            self.inputDisabled = true

            let formData = new FormData()
            formData.append('status', state)

            axios.post('/configs/' + config.config.ref, formData)
                .then(function(response, status, request) {
                    
                let responseStatus = response.data.status.code
                let responseMessage = response.data.status.message

                if (responseStatus != 200) {

                    if (typeof responseMessage === 'string' || responseMessage instanceof String) {
                            self.errors.push(responseMessage)

                    } else if (Array.isArray(responseMessage) || typeof responseMessage == 'object') {
                        for (const [key, value] of Object.entries(responseMessage)) {
                            self.errors.push(`${value}`)

                        }

                    } else {
                        self.errors.push(responseMessage)

                    }

                } else {
                    self.errors.push(responseMessage)
                    config.config.activated = !config.config.activated
                }

            }, function() {
                console.log('activating or deactivating configuration failed')

            }).finally(() => {
                self.showSpinner = false
                self.buttonSubmitDisabled = false

            })
        }
    }, 
    mounted: function() {
        let self = this

        self.showSpinner = false
        self.buttonSubmitDisabled = false
    }
};
</script>