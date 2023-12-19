<template>
    <b-modal
        id="activate-deactivate-meter-modal"
        title="Confirm"
        @show="resetActivateDeactivateMeterModal"
        @ok="onSubmitEditMeter">
            <div class="col-md-12 text-center mb-2">
                <p v-if="errors.length">
                    <ul class="list-group">
                        <li v-for="error in errors" 
                            v-bind:key="error" 
                            class="list-group-item list-group-item-danger">{{ error }}</li>
                    </ul>
                </p>
            </div>
            <b-form ref="form" id="editMeterForm" @submit="onSubmitEditMeter">
                
                <input type="hidden" name="meter_activated_status" id="meter_activated_status" :value="meter.activated" />

                <p>Are you sure that you would like to 

                    <span v-if="meter.activated">
                        deactivate
                    </span>
                    <span v-else>
                        activate
                    </span>

                    meter {{ meter.name }}?
                </p>

            </b-form>
            <div slot="modal-footer">
                <b-btn variant="secondary">Cancel</b-btn>
                <b-btn :disabled="buttonSubmitDisabled" variant="primary" @click="onSubmitEditMeter">
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
    name: "EditMeterComponent",
    props: [
        'meter'
    ],
    data() {
        return {
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        };
    },
    methods: {
        resetActivateDeactivateMeterModal: function() {
            this.errors = []
        },
        onSubmitEditMeter: function(event) {
            let self = this

            self.errors = []
            
                
                let formData = new FormData(document.getElementById("editMeterForm"))

                self.saveSpinner = true
                self.buttonSubmitDisabled = true

                axios.post('/meters/' + self.meter.ref, formData).then(function(response, status, request) {  
                    
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
                        self.$emit('activateDeactivateMeter')

                    }

                }, function() {
                    console.log('activating or deactivating meter failed')

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