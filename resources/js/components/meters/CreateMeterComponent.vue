<template>
    <div class="modal fade" 
        tabindex="-1" 
        id="create-meter-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new meter</h5>
                    <button type="button" @click="resetNewMeterModal" 
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
                    <form  ref="form" id="newMeterForm" class="modal-form">

                        <label for="new-meter-no">Meter No</label>
                        <input id="new-meter-no" name="new-meter-no" v-model="newMeterNo"/>

                        <label for="new-meter-utility">Utility</label>
                        <select id="newMeterUtility" name="newMeterUtility" v-model="newMeterUtility">Type
                            <option v-for="option in utilities" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                        
                        <label for="new-meter-type">Type</label>
                        <select id="newMeterType" name="newMeterType" v-model="newMeterType">
                            <option v-for="option in meter_types" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>

                        <label for="new-meter-type">Subscriber</label>
                        <select id="newMeterSubscriber" name="newMeterSubscriber" v-model="newMeterSubscriber">
                            <option v-for="option in meter_subscribers" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                        @click="resetNewMeterModal" data-dismiss="modal">Cancel</button>
                    <button type="button" :disabled="buttonSubmitDisabled" 
                        @click="onSubmitNewMeter" class="btn btn-primary">
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
    name: "CreateSubscriberMeterComponent",
    data() {
        return {
            newMeterName: '',
            newMeterNo: '',
            newMeterSubscriberContact: '',
            newMeterType: '',
            newMeterSubscriber: '',
            newMeterUtility: '',
            utilities:[],
            meter_types: [],
            meter_subscribers: [],
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        }
    },
    methods: {
        fetch: function(path) {
            return axios
                .get(path)
                .then(response => {
                    if (response.data.status.code == 200) {
                        return response.data.data
                    } else {
                        throw response.data.status.message
                    }
                })
                .catch(err => {
                    throw err
                });

        },
        fetchUtilities() {
            let self = this
            self.fetch("/utility")
                .then(response => {
                    console.log(response.utilities)
                    for (let obtainedUtility of response.utilities) {
                        let utilityObj = {
                                            value: obtainedUtility.ref,
                                            text: obtainedUtility.name
                                            }
                        self.utilities.push(utilityObj)
                    }
                })
        },
        fetchMeterTypes() {
            let self = this
            self.fetch("/subscriberMeters/meterTypes")
                .then(response => {
                    for (let obtainedMeterType of response.meter_types) {
                        let meterTypeObj = {
                                            value: obtainedMeterType.ref,
                                            text: obtainedMeterType.name
                                            }
                        self.meter_types.push(meterTypeObj)
                    }
                })
        },
        fetchSubscribers() {
            this.utilities = this.fetch("/subscribers", "subscribers")
        },
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
        self.fetchUtilities()
        self.fetchMeterTypes()
        // self.fetchSubscribers()                                  
    }
}
</script>
<style scoped>
.modal-header .btn-close {
    position: absolute;
    right: 22px;
    top: 12px;
    width: 25px;
    height: 25px;
    opacity: 0.3;
    border: 0;
    background-color: #fff;
}
.modal-header .btn-close:hover {
  opacity: 1;
}
.modal-header .btn-close:before, .modal-header .btn-close:after {
  position: absolute;
  top: 0;
  left: 15px;
  content: ' ';
  height: 25px;
  width: 2px;
  background-color: #333;
}
.modal-header .btn-close:before {
  transform: rotate(45deg);
}
.modal-header .btn-close:after {
  transform: rotate(-45deg);
}

.modal-form label, .modal-form textarea, .modal-form > input:not(input[type=checkbox]) {
    letter-spacing: 0.03rem;
    display: block;
    width: 100%;
}

.modal-form > input:not(input[type=checkbox]), .modal-form textarea {
    border: 1px solid #ccc;
    border-radius: 0.3em;
}

.modal-form label {
    margin-top: 0.5em;
    margin-bottom: 0.1em;
}

.modal-form > input[type=checkbox] {
    margin-right: 0.5em;
    border: 1px solid #ccc;
}

.modal-form select {
    display: block;
    width: 100%;
    border: 1px solid #ccc;
    padding: 0.1em;
    height: auto;
    padding: 0.5em 0.2em
}

.modal-form select option {
    padding: 0.3em 0.3em;
}
</style>