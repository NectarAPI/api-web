<template>
    <div class="modal fade" 
        tabindex="-1" 
        id="upload-credential-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new credentials</h5>
                    <button type="button" @click="resetNewCredentialModal" 
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
                    <form ref="form" id="newCredentialForm" class="modal-form">
                        <span for="permissions">Select permissions for credentials</span>
                        <select class="form-select" id="permissions" name="permissions[]" 
                                v-model="permissions" multiple :select-size="4">
                            <option v-for="option in options" :value="option.value">
                                {{  option.text }}
                                </option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                        @click="resetNewCredentialModal" data-dismiss="modal">Cancel</button>
                    <button type="button" :disabled="buttonSubmitDisabled" 
                        @click="onSubmitNewCredential" class="btn btn-primary">
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
            this.permissions = []

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
}

.modal-form select option {
    padding: 0.3em 0.3em;
}
</style>