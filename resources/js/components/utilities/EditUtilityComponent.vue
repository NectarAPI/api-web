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
                        <input id="name" name="name" v-model="utilityName"/>

                        <label for="text-key-name">Contact Phone No</label>
                        <input id="name" name="name" v-model="utilityContactPhoneNo"/>

                        <label for="text-key-name">Unit Charge</label>
                        <input id="name" name="name" v-model="utilityUnitCharge"/>

                        <label for="configurations">Select STS configurations for user</label>
                        <select id="configurations" name="configurations[]" 
                            v-model="utilityConfiguration">
                            <option v-for="option in utilitiesOptions" :value="option.value">
                                {{  option.text }}
                            </option>
                        </select>

                        <label for="text-key-name">Account Type</label>
                        <input id="name" name="name" v-model="utilityAccountType"/>
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
    name: "UploadUtilityComponent",
    data() {
        return {
            utilityName: '',
            utilityContactPhoneNo: '',
            utilityUnitCharge: '',
            utilityConfiguration: '',
            utilityAccountType: '',
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
                                value: utility.id,
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