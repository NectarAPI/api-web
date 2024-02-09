<template>
    <div class="modal fade" 
        tabindex="-1" 
        id="edit-meter-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit meter</h5>
                    <button type="button" @click="resetEditMeterModal" 
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
                    <form ref="form" id="editMeterForm" class="modal-form">
                        <label for="meter_no">Meter No</label>
                        <input id="meter_no" name="meter_no" v-model="currMeter.no"/>

                        <label for="utility">Utility</label>
                        <select id="utility" name="utility" v-if="currMeter.utility" v-model="currMeter.utility.ref">
                            <option v-for="option in utilities" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>

                        <select id="utility" name="utility" v-else>
                            <option value="null"></option>
                            <option v-for="option in utilities" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                        
                        <label for="type">Type</label>
                        <select id="type" name="type" v-if="currMeter.meterType" v-model="currMeter.meterType.ref">
                            <option v-for="option in meter_types" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>

                        <select id="type" name="type" v-else>
                            <option value="null"></option>
                            <option v-for="option in meter_types" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>

                        <label for="subscriber">Subscriber (*Optional)</label>
                        <select id="subscriber" name="subscriber" v-if="currMeter.subscriber" v-model="currMeter.subscriber.ref">
                            <option v-for="option in meter_subscribers" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>

                        <select id="subscriber" name="subscriber" v-else>
                            <option value="null"></option>
                            <option v-for="option in meter_subscribers" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>

                        <input type="checkbox"
                            :disabled="buttonSubmitDisabled"
                            class="mt-2"
                            id="activated"
                            name="activated"
                            :checked="currMeter.activated ? true : false"/>
                        <span>Activated</span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                        @click="resetEditMeterModal" data-dismiss="modal">Cancel</button>
                    <button type="button" :disabled="buttonSubmitDisabled" 
                        @click="onSubmitEditMeter" class="btn btn-primary">
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
    name: "EditMeterComponent",
    props: [
        'meter',
        'utilities',
        'meter_types',
        'meter_subscribers'
    ],
    data() {
        return {
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        };
    },
    methods: {
        resetEditMeterModal: function() {
            this.errors = []
        },
        onSubmitEditMeter: function(event) {
            let self = this
            let formData = new FormData(document.getElementById("editMeterForm"))
            self.errors = []
            self.saveSpinner = true
            self.buttonSubmitDisabled = true
            formData.append('meter_ref', self.meter.ref)

            axios.post('/subscriberMeters/updateMeter', formData).then(function(response, status, request) {  
                    
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
                    self.errors.push(responseMessage + " " + response.data.data.meter.data.meter.no)
                    self.$emit('updatedMeter',  response.data.data.meter.data.meter)

                }

            }, function() {
                self.errors.push('updating meter failed')

            }).finally(() => {
                self.saveSpinner = false
                self.buttonSubmitDisabled = false

            })
            
            event.preventDefault()
        },
    },
    computed: {
        currMeter () {
            return {...this.meter}
        }
    },
    mounted: function() {
        let self = this

        self.saveSpinner = false
        self.buttonSubmitDisabled = false
    }
};
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
    padding: 0.5em;
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