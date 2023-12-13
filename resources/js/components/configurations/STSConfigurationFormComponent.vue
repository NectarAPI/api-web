<template>
    <div class="item-wrapper">
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
        <div class="row mb-3">
            <div class="row col-12">
                <p class="pb-4 pt-2">
                    Please fill in the following STS Configuration data. STS
                    configuration data will be sent to our servers
                    encrypted.
                    <a href="#">Learn More</a>
                </p>
            </div>
            <div class="col-md-8 col-sm-12">

                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="cn">Config Name</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input id="cn" name="cn" v-model="cn"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="sgc">Supply Group Code (SGC)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input id="sgc" name="sgc" v-model="sgc"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="iin"
                            >Issuer Identification No (IIN)</label
                        >
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-select id="iin" name="iin" v-model="iin" :options="iin_options"></b-form-select>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="kt">Key Type (KT)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input id="kt" name="kt" v-model="kt"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="krn">Key Revision No (KRN)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <b-form-input id="krn" name="krn" v-model="krn"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="ti">Tariff Index (TI)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <b-form-input id="ti" name="ti" v-model="ti"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="ken">Key Expiry Number (KEN)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <b-form-input id="ken" name="ken" v-model="ken"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="vk">Vending Key (VK)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <b-form-input id="vk" name="vk" v-model="vk"></b-form-input>
                    </div>
                </div>
                <div class="row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label>Decoder Key Generation Algorithm (DKGA)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-select v-model="dkga" :options="dkga_options"></b-form-select>
                    </div>
                </div>
                <div class="row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label>Encryption Algorithm (EA)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-select v-model="ea" :options="ea_options"></b-form-select>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="bd">Base Date (BD)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-select v-model="bd" :options="bd_options"></b-form-select>
                    </div>
                </div>
            
                <div class="form-group row showcase_row_area">
                     <div class="col-md-3 showcase_text_area">
                        <p class="pb-4">
                            Symmetric key
                            <b-button size="sm" class="learn_more" v-b-modal.information-modal @click="displayLabel('symmetric-key')">Learn more</b-button>
                        </p>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-file
                            id="user-symmetric-key"
                            name="user-symmetric-key"
                            v-model="symmetricKey"
                            accept="text/plain"
                            placeholder="Choose a symmetric key"
                            drop-placeholder="Drop file here...">
                        </b-form-file>
                    </div>
                </div>
                
                <div class="form-group row showcase_row_area">
                     <div class="col-md-3 showcase_text_area">
                        <p class="pb-4">
                            Private key
                            <b-button size="sm" class="learn_more" v-b-modal.information-modal @click="displayLabel('private-key')">Learn more</b-button>
                        </p>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-file
                            id="user-private-key"
                            name="user-private-key"
                            v-model="userPrivateKey"
                            accept="text/plain"
                            placeholder="Choose a private key"
                            drop-placeholder="Drop file here...">
                        </b-form-file>
                    </div>
                </div>

                <div class="row showcase_row_area pt-4 pl-3">
                    <button :disabled="buttonSubmitDisabled" class="btn btn-primary" @click="submitConfig">
                        Save &nbsp;&nbsp;
                        <div v-if="showSpinner" id="spinner" class="spinner-border text-secondary" role="status">
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
    name: 'STSConfigurationFormComponent',
    props: [
        'nectarPublicKey',
    ],
    data() {
      return {
        errors: [],
        crypto: null,
        buttonSubmitDisabled: false,
        showSpinner: false,
        symmetricKey: null,
        userPrivateKey: null,
        cn: '',
        sgc: '',
        iin: null,
        kt: '',
        krn: '',
        ti: '',
        ken: '',
        vk: '',
        dkga: null,
        ea: null,
        bd: null,
        iin_options: [
            { value: '600727', text: '600727' },
            { value: '0000', text: '0000' }
        ],
        dkga_options: [
            { value: '01', text: '01' },
            { value: '02', text: '02' },
            { value: '03', text: '03' },
            { value: '04', text: '04' }
        ],
        ea_options: [
            { value: 'sta', text: 'STA' },
            { value: 'dea', text: 'DEA' },
            { value: 'misty1', text: 'MISTY1' },
        ],
        bd_options: [
            { value: '1993', text: '1993' },
            { value: '2014', text: '2014' },
            { value: '2035', text: '2035' },
        ]
      }
    }, 
    methods: {
        displayLabel: function(label) {
            this.$emit('displayLabel', label)
        },
        async submitConfig() {
            let self = this

            try {
                self.errors = []
                self.showSpinner = true
                self.buttonSubmitDisabled = true

                if (self.validateFields()) {
                    let yamlConfig = self.generateYAMLConfig()

                    let symmetricKey = await self.loadSymmetricKey()
                    let userPrivateKey = await self.loadPrivateKey()

                    let encryptedSTSConfiguration = self.encryptSTSConfig(yamlConfig, symmetricKey)
                    let encryptedMessageDigest = self.generateAndEncryptMessageDigest(yamlConfig, userPrivateKey)
                    let encryptedSymmetricKey = self.encryptSymmetricKey(symmetricKey, self.nectarPublicKey)
                    
                    await self.$store.dispatch('createConfigurations', 
                                                {
                                                    'data': encryptedSTSConfiguration,
                                                    'digest': encryptedMessageDigest,
                                                    'key': encryptedSymmetricKey

                                                }).then((res) => {
                                                    self.errors.push('Created config ' + res.config.name)
                                                    self.showSpinner = false
                                                    self.buttonSubmitDisabled = false
                                                    self.cn = ''
                                                    self.sgc = ''
                                                    self.iin = null
                                                    self.kt = ''
                                                    self.krn = ''
                                                    self.ti = ''
                                                    self.ken = ''
                                                    self.vk = ''
                                                    self.dkga = null
                                                    self.ea = null
                                                    self.bd = null

                                                }).catch(err => {
                                                    self.errors.push(err)

                                                })

                } else {
                    self.showSpinner = false
                    self.buttonSubmitDisabled = false

                }

            } catch(e) {
                self.errors.push(e)
    
            } finally {
                self.showSpinner = false
                self.buttonSubmitDisabled = false
                
            }
        }, 
        validateFields: function() {
            let self = this

             if (self.cn == undefined || self.cn == '') {
                 self.errors.push('Invalid configuration name')
             } 

            if (!/^([0-9]{6})$/.test(self.sgc)) {
                self.errors.push('Invalid Supply Group Code')
            }

            if (!/^(600727|0000)$/.test(self.iin)) {
                self.errors.push('Invalid Issuer Identification Number')
            }

            if (!/^([0-3])$/.test(self.kt)) {
                self.errors.push('Invalid Key Type')
            }

            if (!/^([1-9]{1})$/.test(self.krn)) {
                self.errors.push('Invalid Key Revision No')
            }

            if (!/^([0-9]{2})$/.test(self.ti)) {
                self.errors.push('Invalid Tariff Index')
            }

            let ken = parseInt(self.ken, 10)
            if (!self.ken || self.ken == null || isNaN(self.ken) || ken < 0 || ken > 255) {
                self.errors.push('Invalid Key Expiry No')
            }

            if (!/^([0-9a-fA-F]{16})$/.test(self.vk)) {
                self.errors.push('Invalid Vending Key')
            }

            if (!/^(01|02|03|04)$/.test(self.dkga)) {
                self.errors.push('Invalid Decoder Key Generation Algorithm')
            }

            if (!/^(sta|dea|misty)$/.test(self.ea)) {
                self.errors.push('Invalid Encryption Algorithm')
            }

            if (!/^(1993|2014|2035)$/.test(self.bd)) {
                self.errors.push('Invalid Base Date')
            }

            if (!self.symmetricKey || self.symmetricKey['type'] != 'text/plain') {
                 self.errors.push('Error with Symmetric Key File')
            }

            if (!self.userPrivateKey || self.userPrivateKey['type'] != 'text/plain') {
                self.errors.push('Error with user private key')
            }

            return self.errors.length == 0

        },
        generateYAMLConfig: function() {
            let self = this
            return `---\n` +
                    `name: ${self.cn}\n` +
                    `key_expiry_no: ${self.ken}\n` +
                    `encryption_algorithm: ${self.ea}\n` +
                    `token_carrier_type: numeric\n` +
                    `decoder_key_generation_algorithm: ${self.dkga}\n` +
                    `tariff_index: ${self.ti}\n` +
                    `key_revision_no: ${self.krn}\n` +
                    `vending_key: ${self.vk}\n` +
                    `supply_group_code: ${self.sgc}\n` +
                    `key_type: ${self.kt}\n` +
                    `base_date: ${self.bd}\n` +
                    `issuer_identification_no: ${self.iin}`
        },
        encryptSTSConfig: function(yamlConfig, symmetricKey) {
            let self = this
            let iv = self.crypto.randomBytes(16)
            let cipher = self.crypto.createCipheriv('aes-128-cbc', symmetricKey, iv)
            let ciphertext = Buffer.concat([ cipher.update(yamlConfig), cipher.final() ])
            return Buffer.concat([ iv, ciphertext ]).toString('base64')
        },
        generateAndEncryptMessageDigest: function(yamlConfig, userPrivateKey) {
            let self = this
            let digest = self.crypto.createHash('sha256').update(yamlConfig, "utf8").digest()
            let annotatedUserPrivateKey = self.refactorUserPrivateKey(userPrivateKey)
            var encrypted = self.crypto.privateEncrypt({     
                                                            key: userPrivateKey, 
                                                            padding: self.crypto.constants.RSA_PKCS1_PADDING
                                                        }, 
                                                        digest)

            return encrypted.toString("base64")
        },
        refactorUserPrivateKey: function(userPrivateKey) {
            let refactoredUserPrivateKey = userPrivateKey.replace("-----BEGIN RSA PRIVATE KEY-----", "");
            refactoredUserPrivateKey = refactoredUserPrivateKey.replace("-----END RSA PRIVATE KEY-----", "");
            refactoredUserPrivateKey = refactoredUserPrivateKey.replace("\r", "");
            return refactoredUserPrivateKey.replace("\n", "");
        },
        encryptSymmetricKey: function(symmetricKey, nectarPublicKey) {
            let self = this
            var buffer = new Buffer.from(symmetricKey, 'utf8')
            let annotatedNectarPublicKey = "-----BEGIN PUBLIC KEY-----\n" + nectarPublicKey + "\n-----END PUBLIC KEY-----"
            var encrypted = self.crypto.publicEncrypt({     
                                                            key: annotatedNectarPublicKey, 
                                                            padding: self.crypto.constants.RSA_PKCS1_PADDING
                                                        }, 
                                                    buffer)
            return encrypted.toString("base64")
        },
        loadPrivateKey: function() {
            let self = this
            return this.loadFile(self.userPrivateKey)
        },
        loadSymmetricKey: function() {
            let self = this
            return this.loadFile(self.symmetricKey)
        },
        loadFile: function(fileObj) {
            let reader = new FileReader()

            reader.readAsText(fileObj, "UTF-8")
            return new Promise((resolve, reject) => {
                reader.onload =  evt => {
                    resolve(evt.target.result.trim())
                }

                reader.onerror = evt => {
                    reject(evt)
                }
            })
        }
    },
    mounted: function() {
        this.showSpinner = false
        this.buttonSubmitDisabled = false

        try {
            this.crypto = require('crypto')
        } catch (err) {
            throw 'crypto support is disabled!'

        }
    }
}
</script>
<style scoped>
.learn_more {
    height: 1.5em;
    padding: 0.2em;
    margin: 0;
    color: #696ffb;
}
</style>