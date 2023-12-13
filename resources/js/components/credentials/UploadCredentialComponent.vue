<template>
        <b-modal
        id="upload-credential-modal"
        title="Create new credentials"
        @show="resetNewCredentialModal"
        @ok="onSubmitNewCredential">
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
            <b-form ref="form" id="newCredentialForm" @submit="onSubmitNewCredential">
                <label for="permissions">Select permissions for credentials</label>
                <b-form-select id="permissions" name="permissions[]" v-model="permissions" :options="options" multiple :select-size="4"></b-form-select>
            </b-form>
            <div slot="modal-footer">
                    <b-btn variant="secondary">Cancel</b-btn>
                    <b-btn :disabled="buttonSubmitDisabled" variant="primary" @click="onSubmitNewCredential">
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
    name: "UploadCredentialComponent",
    data() {
        return {
            permissions: [],
            options: [],
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        }
    },
    methods: {
        fetchPermissions: function() {
            let self = this

            return axios
                .get("/permissions")
                .then(response => {
                    if (response.data.status.code == 200) {
                        let permissions = response.data.data.permissions
                        for (let permission of permissions) {
                            let permObj = {
                                value: permission.id,
                                text: permission.name
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
        resetNewCredentialModal: function() {
            this.errors = []

        },
        onSubmitNewCredential: function(event) {
            this.errors = []
            
            if (!this.permissions) {
                this.errors.push('Please select desired permissions')

            } else {

                let self = this
                let formData = new FormData(document.getElementById("newCredentialForm"))

                self.saveSpinner = true
                self.buttonSubmitDisabled = true

                axios.post('/creds', formData).then(function(response, status, request) {  
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
                        let message = responseMessage + " " + response.data.data.credentials.credential.ref
                        self.errors.push(message)
                        self.$emit('createdCredential',  response.data.data.credentials.credential)

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