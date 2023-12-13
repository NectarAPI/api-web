<template>
        <b-modal
        id="upload-utility-modal"
        title="Create new utility"
        @show="resetNewUtilityModal"
        @ok="onSubmitNewUtility">
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
            <b-form ref="form" id="newUtilityForm" @submit="onSubmitNewUtility">
                <label for="text-key-name">Name</label>
                <b-form-input id="name" name="name" v-model="newUtilityName"></b-form-input>

                <label for="text-key-name">Contact Phone No</label>
                <b-form-input id="name" name="name" v-model="newUtilityContactPhoneNo"></b-form-input>

                <label for="text-key-name">Unit Charge</label>
                <b-form-input id="name" name="name" v-model="newUtilityUnitCharge"></b-form-input>

                <label for="configurations">Select STS configurations for user</label>
                <b-form-select id="configurations" name="configurations[]" v-model="newUtilityConfiguration" 
                    :options="options"></b-form-select>

                <label for="text-key-name">Account Type</label>
                <b-form-input id="name" name="name" v-model="newUtilityAccountType"></b-form-input>
            </b-form>
            <div slot="modal-footer">
                    <b-btn variant="secondary">Cancel</b-btn>
                    <b-btn :disabled="buttonSubmitDisabled" variant="primary" @click="onSubmitNewUtility">
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
    name: "UploadUtilityComponent",
    data() {
        return {
            newUtilityName,
            newUtilityContactPhoneNo,
            newUtilityUnitCharge,
            newUtilityConfiguration,
            newUtilityAccountType,
            permissions: [],
            options: [],
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        }
    },
    methods: {
        fetchConfigs: function() {
            let self = this

            return axios
                .get("/configs")
                .then(response => {
                    if (response.data.status.code == 200) {
                        let configs = response.data.data.configs
                        for (let config of configs) {
                            let permObj = {
                                value: config.id,
                                text: config.name
                            }
                            self.options.push(permObj)
                        }

                    } else {
                        throw response.data.status.message
                    }
                })
                .catch(err => {
                    throw err
                });

        },
        resetNewUtilityModal: function() {
            this.errors = []

        },
        onSubmitNewUtility: function(event) {
            this.errors = []
            
            if (!this.permissions) {
                this.errors.push('Please select desired permissions')

            } else {

                let self = this
                let formData = new FormData(document.getElementById("newUtilityForm"))

                self.saveSpinner = true
                self.buttonSubmitDisabled = true

                axios.post('/utilities', formData).then(function(response, status, request) {  
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
                        self.$emit('createdUtility',  response.data.data.utilities.utility)

                    }

                }, function() {
                    console.log('adding new key failed')

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
        self.fetchPermissions()
    }
}
</script>