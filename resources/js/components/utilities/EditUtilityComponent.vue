<template>
    <div class="modal fade" 
        tabindex="-1" 
        id="edit-utility-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit utility</h5>
                    <button type="button" @click="resetUtilityModal" 
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
                    <form ref="form" id="editUtilityForm" class="modal-form">
                        <label for="text-key-name">Name</label>
                        <input id="name" name="name" :value="utility.name"/>

                        <label for="text-key-name">Contact Phone No</label>
                        <input id="name" name="name" :value="utility.contact_phone_no"/>

                        <label for="text-key-name">Unit Charge</label>
                        <input id="name" name="name" :value="utility.unit_charge"/>

                        <label for="configurations">STS configuration</label>
                        <select id="configurations" name="configurations[]" v-model="utility.ref">                        
                            <option v-for="option in utilitiesOptions" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>

                        <input type="checkbox"
                            class="mt-2"
                            id="activated"
                            name="activated"
                            :checked="utility.activated ? true : false" 
                            v-model="utilityActivated"/>
                        <span>Activated</span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                        @click="resetUtilityModal" data-dismiss="modal">Cancel</button>
                    <button type="button" :disabled="buttonSubmitDisabled" 
                        @click="onSubmitEditUtility" class="btn btn-primary">
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
    name: "EditUtilityComponent",
    props: [
        'utility'
    ],
    data() {
        return {
            utilityName: '',
            utilityContactPhoneNo: '',
            utilityUnitCharge: '',
            utilityAccountType: '',
            utilityActivated: Boolean,
            utilitiesOptions: [],
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        };
    },
    methods: {
        fetchUtilties: function() {
            let self = this
            return axios
                .get("/utility")
                .then(response => {
                    if (response.data.status.code == 200) {
                        let utilities = response.data.data.utilities
                        for (let utility of utilities) {
                            let utilityObj = {
                                value: utility.ref,
                                text: utility.name
                            }
                            self.utilitiesOptions.push(utilityObj)
                        }

                    } else {
                        throw response.data.status.message
                    }
                })
                .catch(err => {
                    throw err
                });

        },
        resetUtilityModal: function() {
            this.errors = []

        },
        onSubmitEditUtility: function(event) {
            this.errors = []
            
            if (!this.configs) {
                this.errors.push('Please select desired configuration')

            } else {
                let self = this
                let formData = new FormData(document.getElementById("editUtilityForm"))
                self.saveSpinner = true
                self.buttonSubmitDisabled = true

                axios.put('/utility', formData).then(function(response, status, request) {  
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
                        let message = responseMessage + " " + response.data.data.utilities.utility.ref
                        self.errors.push(message)
                        self.$emit('updatedUtility',  response.data.data.utilities.utility)

                    }

                }, function() {
                    console.log('Updating utility failed')

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
        self.fetchUtilties()
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