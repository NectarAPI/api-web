<template>
    <b-modal
        id="activate-deactivate-credential-modal"
        title="Confirm"
        @show="resetActivateDeactivateCredentialsModal"
        @ok="onSubmitEditCredential">
            <div class="col-md-12 text-center mb-2">
                <p v-if="errors.length">
                    <ul class="list-group">
                        <li v-for="error in errors" 
                            v-bind:key="error" 
                            class="list-group-item list-group-item-danger">{{ error }}</li>
                    </ul>
                </p>
            </div>
            <b-form ref="form" id="editCredentialForm" @submit="onSubmitEditCredential">
                
                <input type="hidden" name="status" id="status" :value="credential.activated" />

                <p>Are you sure that you would like to 

                    <span v-if="credential.activated">
                        deactivate
                    </span>
                    <span v-else>
                        activate
                    </span>

                    credential {{ credential.ref }}?
                </p>

            </b-form>
            <div slot="modal-footer">
                <b-btn variant="secondary">Cancel</b-btn>
                <b-btn :disabled="buttonSubmitDisabled" variant="primary" @click="onSubmitEditCredential">
                    Save &nbsp;&nbsp;   
                        <div v-if="saveSpinner" 
                        id="save-spinner" 
                        class="spinner-border text-secondary" 
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div> 
                </b-btn>
            </div>
    </b-modal>
</template>
<script>
export default {
    name: "EditCredentialsComponent",
    props: [
        'credential'
    ],
    data() {
        return {
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        };
    },
    methods: {
        resetActivateDeactivateCredentialsModal: function() {
            this.errors = []
        },
        onSubmitEditCredential: function(event) {
            let self = this

            self.errors = []
            
            let formData = new FormData(document.getElementById("editCredentialForm"))

            self.saveSpinner = true
            self.buttonSubmitDisabled = true

            axios.post('/creds/' + self.credential.ref, formData).then(function(response, status, request) {  
                    
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
                        self.$emit('activateDeactivateCredential')

                    }

                }, function() {
                    self.errors.push('activating or deactivating credential failed')
                    console.log(response)

                }).finally(() => {
                    self.saveSpinner = false
                    self.buttonSubmitDisabled = false

                })
            
            event.preventDefault()
        },
    }, 
    mounted: function() {
        let self = this

        self.saveSpinner = false
        self.buttonSubmitDisabled = false
    }
};
</script>