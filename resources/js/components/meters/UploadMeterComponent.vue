<template>
        <b-modal
        id="upload-meter-modal"
        title="Create new Meter"
        @show="resetNewMeterModal"
        @ok="onSubmitNewMeter">
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
            <b-form ref="form" id="newMeterForm" @submit="onSubmitNewMeter">
                <label for="new-meter-name">Name</label>
                <b-form-input id="new-meter-name" name="new_meter_name" v-model="newMeterName"></b-form-input>

                <label for="new-meter-no">Number</label>
                <b-form-input id="new-meter-no" name="new-meter-no" v-model="newMeterNo"></b-form-input>

                <label for="meter-subscriber-contact">Subscriber Contact</label>
                <b-form-input id="new-meter-subscriber-contact" name="new-meter-subscriber-contact" 
                    v-model="newMeterSubscriberContact"></b-form-input>

                <label for="new-meter-type">Type</label>
                <b-form-select id="newMeterType" name="newMeterType" v-model="newMeterType" 
                    :options="meter_type_options"></b-form-select>

                <label for="new-meter-gps-location">GPS Location</label>
                <b-form-input id="new-meter-gps-location" name="new-meter-gps-location" 
                    v-model="newMeterGPSLocation"></b-form-input>
            </b-form>
            <div slot="modal-footer">
                    <b-btn variant="secondary">Cancel</b-btn>
                    <b-btn :disabled="buttonSubmitDisabled" variant="primary" @click="onSubmitNewMeter">
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
    name: "UploadMeterComponent",
    data() {
        return {
            newMeterName,
            newMeterNo,
            newMeterSubscriberContact,
            newMeterType,
            newUtilinewMeterGPSLocationtyAccountType,
            permissions: [],
            meter_type_options: [
                'electricity',
                'water',
                'gas'
            ],
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        }
    },
    methods: {
        resetNewMeterModal: function() {
            this.errors = []

        },
        onSubmitNewMeter: function(event) {
            this.errors = []
            
            if (!this.newMeterType) {
                this.errors.push('Please select meter type')

            } else {

                let self = this
                let formData = new FormData(document.getElementById("newMeterForm"))

                self.saveSpinner = true
                self.buttonSubmitDisabled = true

                axios.post('/meters', formData).then(function(response, status, request) {  
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
                        let message = responseMessage + " " + response.data.data.meters.meter.ref
                        self.errors.push(message)
                        self.$emit('createdMeter',  response.data.data.meters.meter)

                    }

                }, function() {
                    console.log('adding new meter failed')

                }).finally(() => {
                    self.saveSpinner = false
                    self.buttonSubmitDisabled = false

                })
            }
            
            event.preventDefault()
        },
    },
    mounted: function() {
        let self = this
        self.saveSpinner = false
        self.buttonSubmitDisabled = false
    }
}
</script>