<template>
    <div class="container">
        <div class="col-md-12 text-center mt-2">
            <p v-if="errors.length">
                <ul class="list-group">
                    <li v-for="error in errors" 
                        v-bind:key="error" 
                        class="list-group-item list-group-item-danger">{{ error }}
                    </li>
                </ul>
            </p>
        </div>
        <div class="row showcase_row_area mb-3">
            
            <div class="col-md-8 col-sm-12 pb-4">
                <div class="col-12 pt-4">
                    <p class="pb-4">
                        Step 1: Upload an encrypted configuration file.
                        <button size="sm" class="learn_more btn btn-primary"
                            data-toggle="modal" 
                            data-target="#information-modal" 
                            @click="displayLabel('encrypted-configuration')">Learn more
                        </button>
                    </p>
                </div>
                <div class="col-md-10 showcase_content_area">
                    <input class="form-control" type="file"
                        @change="handleEncryptedSTSConfiguration"
                        accept="text/plain"
                        placeholder="Choose an encrypted STS configuration file"
                        drop-placeholder="Drop file here..."/>
                </div>
            </div>

            <div class="col-md-8 col-sm-12">
                <div class="col-12 pt-4">
                    <p class="pb-4">
                        Step 2: Upload an encrypted message digest file.
                        <button size="sm" class="learn_more btn btn-primary" 
                            data-toggle="modal"
                            data-target="#information-modal" 
                            @click="displayLabel('encrypted-message-digest')">Learn more</button>
                    </p>
                </div>
                <div class="col-md-10 showcase_content_area">
                    <input class="form-control" type="file"
                        @change="handleEncryptedMessageDigest"
                        accept="text/plain"
                        placeholder="Choose an encrypted message digest file"
                        drop-placeholder="Drop file here..."/>
                </div>
            </div>

            <div class="col-md-8 col-sm-12 pb-4">
                <div class="col-12 pt-4">
                    <p class="pb-4">
                        Step 3: Upload an encrypted symmetric key
                        <button size="sm" class="learn_more btn btn-primary" 
                            data-toggle="modal"
                            data-target="#information-modal" 
                            @click="displayLabel('encrypted-symmetric-key')">Learn more</button>
                    </p>
                </div>
                <div class="col-md-10 showcase_content_area">
                     <input class="form-control" type="file"
                        @change="handleEncryptedSymmetricKey"
                        accept="text/plain"
                        placeholder="Choose an encrypted symmetric key"
                        drop-placeholder="Drop file here..."/>
                </div>
            </div>
        </div>

        <div class="row showcase_row_area pt-4 pl-3">
            <button :disabled="buttonSubmitDisabled" class="btn btn-primary" @click="submitEncryptedFiles">
                Save &nbsp;&nbsp;
                <div v-if="showSpinner" id="spinner" class="spinner-border text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div> 
            </button>
        </div>
    </div>
</template>
<script>

export default {
    name: 'UploadSTSConfigurationComponent',
    props: [
        'publicKeysRoute',
    ],
    data() {
        return {
            errors: [],
            buttonSubmitDisabled: false,
            showSpinner: false,
            encryptedSymmetricKey: null,
            encryptedSTSConfiguration: null,
            encryptedMessageDigest: null
        }
    }, 
    methods: {
        handleEncryptedSymmetricKey(event) {
            this.encryptedSymmetricKey = event.target.files[0];
        },
        handleEncryptedMessageDigest(event) {
            this.encryptedMessageDigest = event.target.files[0];
        },
        handleEncryptedSTSConfiguration(event) {
            this.encryptedSTSConfiguration = event.target.files[0];
        },
        displayLabel: function(label) {
            this.$emit('displayLabel', label)
        },
        async submitEncryptedFiles() {
            let self = this

            self.errors = []
            self.showSpinner = true
            self.buttonSubmitDisabled = true

            if (!self.encryptedSymmetricKey) {
                 self.errors.push('Symmetric key file required')
            }
    
            if (!self.encryptedSTSConfiguration) {
                self.errors.push('Encrypted STS configuration required')
            } 

            if (!self.encryptedMessageDigest) {
                self.errors.push('Encrypted message digest required')
            }
            
            if (self.errors.length == 0) {
                let data = await self.readFile(self.encryptedSTSConfiguration)
                let digest = await self.readFile(self.encryptedMessageDigest)
                let key = await self.readFile(self.encryptedSymmetricKey)

                try {
                        await self.$store.dispatch('createConfigurations', 
                                            {
                                                'data': data,
                                                'digest': digest,
                                                'key': key 

                                            }).then((res) => {
                                                self.errors.push('Created config ' + res.config.name)
                                                self.showSpinner = false
                                                self.buttonSubmitDisabled = false

                                            }).catch(err => {
                                                 self.errors.push(err)

                                            });
                } catch(e) {
                    self.errors.push(e)
                }
                
            }

            self.showSpinner = false
            self.buttonSubmitDisabled = false
        },
        readFile: function(fileName) {
            let reader = new FileReader()

            reader.readAsText(fileName, "UTF-8")
            return new Promise((resolve, reject) => {
                reader.onload =  evt => {
                    resolve(evt.target.result.trim());
                }

                reader.onerror = evt => {
                    reject(evt);
                }
            })
        },

    },
    mounted: function() {
        this.showSpinner = false
        this.buttonSubmitDisabled = false

    }
}
</script>
<style scoped>
.learn_more {
    height: 2em;
    padding: 0.5em;
    margin: 0;
    color: #fff;
}
input[type=file] {
    padding: 0
}
</style>
