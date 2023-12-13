<template>
    <b-modal
        id="upload-public-key-modal"
        title="Upload new public key"
        @show="resetNewPublicKeysModal"
        @ok="onSubmitNewPublicKey">
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
            <b-form ref="form" id="newKeyForm" @submit="onSubmitNewPublicKey">
                <label for="text-key-name">Name</label>
                <b-form-input id="name" name="name" v-model="newKeyName"></b-form-input>

                <label for="text-key">Public Key</label>
                <b-form-textarea
                    v-model="newKey"
                    id="key"
                    name="key"
                    rows="10"
                    max-rows="10"
                    required
                    aria-describedby="key-help-block">
                </b-form-textarea>
                <b-form-text id="key-help-block">
                    Your public key must be a 4096 bit
                    RSA/ECB/PKCS1Padding key. <a href="/documentation">Learn more</a>
                </b-form-text>

                <b-form-checkbox
                    class="mt-2"
                    id="activated"
                    name="activated"
                    v-model="newKeyActivated">
                    Activated
                </b-form-checkbox>
            </b-form>
            <div slot="modal-footer">
                <b-btn variant="secondary">Cancel</b-btn>
                <b-btn :disabled="buttonSubmitDisabled" variant="primary" @click="onSubmitNewPublicKey">
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
    name: "UploadPublicKeyComponent",
    data() {
        return {
            errors: [],
            newKey: '',
            newKeyName: '',
            newKeyActivated: false,
            saveSpinner: false,
            buttonSubmitDisabled: false,
        
        };
    },
    methods: {
        resetNewPublicKeysModal: function() {
            this.newKeyName = ''
            this.newKey = ''
            this.newKeyActivated = false
            this.errors = []

        },
        onSubmitNewPublicKey: function(event) {
            this.errors = []
            
            if (!this.newKeyName) {
                this.errors.push('Key name is required')

            }
            
            if (!this.newKey) {
                this.errors.push('Key is required')

            } 
            
            if (!this.errors || !this.errors.length) {

                let self = this
                let formData = new FormData(document.getElementById("newKeyForm"))

                self.saveSpinner = true
                self.buttonSubmitDisabled = true

                axios.post('/pkeys', formData).then(function(response, status, request) {  
                    
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
                        self.$emit('fetchPublicKeys')

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
        let self = this;

        self.saveSpinner = false;
        self.buttonSubmitDisabled = false

    }
}
</script>