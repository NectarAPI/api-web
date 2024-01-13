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
                    configuration data will encrypted using the private key locally on this client
                    before it is transmitted. The private key will not be transmitted from this client.
                    <a href="/docs">Learn More</a>
                </p>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="sts_config_type">STS Configuration Type</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <select name="sts_config_type" id="sts_config" 
                            v-model="currSTSConfigType">
                            <option value="NATIVE">Native</option>
                            <option value="PRISM">Prism</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="cn">Config Name</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="cn" name="cn" v-model="cn"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" v-if="currSTSConfigType == 'PRISM'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="host">Host</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="host" name="host" v-model="host"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" v-if="currSTSConfigType == 'PRISM'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="realm">Realm</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="realm" name="realm" v-model="realm"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" v-if="currSTSConfigType == 'PRISM'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="port">Port</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="port" name="port" v-model="port"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" v-if="currSTSConfigType == 'PRISM'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="username" name="username" v-model="username"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" v-if="currSTSConfigType == 'PRISM'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="password" name="password" v-model="password"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="sgc">Supply Group Code (SGC)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="sgc" name="sgc" v-model="sgc"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" v-if="currSTSConfigType == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="iin">Issuer Identification No (IIN)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <select class="form-select" id="iin" name="iin" 
                            v-model="iin">
                            <option v-for="option in iin_options" :value="option.value">
                                {{  option.text }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row showcase_row_area"  v-if="currSTSConfigType == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="kt">Key Type (KT)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input id="kt" name="kt" v-model="kt"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="krn">Key Revision No (KRN)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <input id="krn" name="krn" v-model="krn"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="ti">Tariff Index (TI)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <input id="ti" name="ti" v-model="ti"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label for="ken">Key Expiry Number (KEN)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <input id="ken" name="ken" v-model="ken"/>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" 
                            v-if="currSTSConfigType == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="vk">Vending Key (VK)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                         <input id="vk" name="vk" v-model="vk"/>
                    </div>
                </div>
                <div class="row showcase_row_area" 
                            v-if="currSTSConfigType == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label>Decoder Key Generation Algorithm (DKGA)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <select class="form-select" v-model="dkga">
                            <option v-for="option in dkga_options" :value="option.value">
                                {{  option.text }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row showcase_row_area">
                    <div class="col-md-3 showcase_text_area">
                        <label>Encryption Algorithm (EA)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <select class="form-select" v-model="ea">
                            <option v-for="option in ea_options" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row showcase_row_area" v-if="currSTSConfigType == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="bd">Base Date (BD)</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <select class="form-select" v-model="bd">
                            <option v-for="option in bd_options" :value="option.value">
                                {{  option.text }}
                            </option>
                        </select>
                    </div>
                </div>
            
                <div class="form-group row showcase_row_area">
                     <div class="col-md-3 showcase_text_area">
                        <p class="pb-4">
                            Symmetric key
                            <button type="button"
                                size="sm" 
                                class="learn_more btn btn-primary"
                                data-toggle="modal" 
                                data-target="#information-modal" 
                                @click="displayLabel('symmetric-key')">Learn more</button>
                        </p>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input class="form-control" type="file"
                            id="user-symmetric-key"
                            name="user-symmetric-key"
                            @change="handleSymmetricKey"
                            accept="text/plain"
                            placeholder="Choose a symmetric key"
                            drop-placeholder="Drop file here..."/>
                    </div>
                </div>
                
                <div class="form-group row showcase_row_area">
                     <div class="col-md-3 showcase_text_area">
                        <p class="pb-4">
                            Private key
                            <button type="button" 
                                class="learn_more btn btn-primary" 
                                data-toggle="modal"
                                size="sm" 
                                data-target="#information-modal" 
                                @click="displayLabel('private-key')">Learn more</button>
                        </p>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <input class="form-control" type="file"
                            id="user-private-key"
                            name="user-private-key"
                            @change="handleUserPrivateKey"
                            accept="text/plain"
                            placeholder="Choose a private key"
                            drop-placeholder="Drop file here..."/>
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
import * as crypto from 'crypto';

export default {
    name: 'STSConfigurationFormComponent',
    props: [
        'nectarPublicKey',
    ],
    data() {
      return {
        errors: [],
        currSTSConfigType: 'NATIVE',
        crypto: null,
        buttonSubmitDisabled: false,
        showSpinner: false,
        symmetricKey: null,
        userPrivateKey: null,
        host: '',
        realm: '',
        port: '',
        username: '',
        password: '',
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
        handleSymmetricKey(event) {
            this.symmetricKey = event.target.files[0];
        },
        handleUserPrivateKey(event) {
            this.userPrivateKey = event.target.files[0];
        },
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
                                                    self.errors.push('Created config ' + res.config.config.name)
                                                    self.showSpinner = false
                                                    self.buttonSubmitDisabled = false

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

            if (self.currSTSConfigType == 'NATIVE' && !/^(600727|0000)$/.test(self.iin)) {
                self.errors.push('Invalid Issuer Identification Number')
            }

            if (self.currSTSConfigType == 'NATIVE' && !/^([0-3])$/.test(self.kt)) {
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

            if (self.currSTSConfigType == 'NATIVE' && !/^([0-9a-fA-F]{16})$/.test(self.vk)) {
                self.errors.push('Invalid Vending Key')
            }

            if (self.currSTSConfigType == 'NATIVE' && !/^(01|02|03|04)$/.test(self.dkga)) {
                self.errors.push('Invalid Decoder Key Generation Algorithm')
            }

            if (!/^(sta|dea|misty)$/.test(self.ea)) {
                self.errors.push('Invalid Encryption Algorithm')
            }

            if (self.currSTSConfigType == 'NATIVE' && !/^(1993|2014|2035)$/.test(self.bd)) {
                self.errors.push('Invalid Base Date')
            }

            if (self.currSTSConfigType == 'PRISM' && !/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(self.host)) {
                self.errors.push('Invalid host')
            }

            if (self.currSTSConfigType == 'PRISM' && !/^\d{1,}$/.test(self.port)) {
                self.errors.push('Invalid port')
            }

            if (self.currSTSConfigType == 'PRISM' &&  (self.realm == undefined || self.realm == '')) {
                self.errors.push('Invalid realm')
            }

            if (self.currSTSConfigType == 'PRISM' && (self.username == undefined || self.username == '')) {
                self.errors.push('Invalid username')
            }

            if (self.currSTSConfigType == 'PRISM' && (self.password == undefined || self.password == '')) {
                self.errors.push('Invalid password')
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
            if (self.currSTSConfigType == 'NATIVE') {
                return `---\n` +
                        `name: ${self.cn}\n` +
                        `type: native\n` +
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
            } else if (self.currSTSConfigType == 'PRISM') {
                return `---\n` +
                        `name: ${self.cn}\n` +
                        `type: prism-thrift\n` +
                        `host: ${self.host}\n` +
                        `port: ${self.port}\n` +
                        `realm: ${self.realm}\n` +
                        `username: ${self.username}\n` +
                        `password: ${self.password}\n` +
                        `encryption_algorithm: ${self.ea}\n` +
                        `token_carrier_type: numeric\n` +
                        `supply_group_code: ${self.sgc}\n` +
                        `key_revision_no: ${self.krn}\n` +
                        `key_expiry_no: ${self.ken}\n` +
                        `tariff_index: ${self.ti}`
            }
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
            refactoredUserPrivateKey = userPrivateKey.replace("-----BEGIN PRIVATE KEY-----", "");
            refactoredUserPrivateKey = refactoredUserPrivateKey.replace("-----END RSA PRIVATE KEY-----", "");
            refactoredUserPrivateKey = refactoredUserPrivateKey.replace("-----END PRIVATE KEY-----", "");
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
            this.crypto = crypto
         } catch (err) {
            throw 'crypto support is disabled!'

        }
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
input:not(input[type=file]), select {
    border: 1px solid #ccc;
    border-radius: 0.3em;
    width: 100%;
    letter-spacing: 0.03rem;
    padding: 0.3em 0.2em;
}
input[type=file] {
    padding: 0
}
</style>