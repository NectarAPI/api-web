<template>
    <b-modal
        id="activate-deactivate-configuration-modal"
        title="Confirm"
        @show="resetActivateDeactivateConfigurationsModal">
            <div class="col-md-12 text-center mb-2">
                <p v-if="errors.length">
                    <ul class="list-group">
                        <li v-for="error in errors" 
                            v-bind:key="error" 
                            class="list-group-item list-group-item-danger">{{ error }}</li>
                    </ul>
                </p>
            </div>
            <b-form ref="form" id="editConfigurationForm">
                
                <input type="hidden" name="configuration_activated_status" id="key_activated_status" :value="configuration.config.activated" />

                <p>Are you sure that you would like to 

                    <span v-if="configuration.config.activated">
                        deactivate
                    </span>
                    <span v-else>
                        activate
                    </span>

                    configuration {{ configuration.config.name }}?
                </p>

            </b-form>
            <div slot="modal-footer">
                <b-btn variant="secondary">Cancel</b-btn>
                <span v-if="!configuration.config.activated">
                    <b-button variant="danger" 
                        @click="activateConfiguration(configuration, true)">
                        Activate &nbsp;&nbsp;   
                        <div v-if="showSpinner" 
                            id="save-spinner" 
                            class="spinner-border text-secondary" 
                            role="status">
                            <span class="sr-only">Loading...</span>
                        </div> 
                    </b-button>
                </span>

                <span v-else>
                    <b-button variant="success"
                        @click="activateConfiguration(configuration, false)">
                        Deactivate &nbsp;&nbsp;   
                        <div v-if="showSpinner" 
                            id="save-spinner" 
                            class="spinner-border text-secondary" 
                            role="status">
                            <span class="sr-only">Loading...</span>
                        </div> 
                    </b-button>
                </span>
            </div>
    </b-modal>
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