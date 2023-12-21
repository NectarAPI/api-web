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
        <div class="row mb-3">
            <div class="row col-12">
                <p class="pb-4 pt-2">
                    Please fill in the following details to decode a token.
                </p>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label for="inputType1">STS Configuration</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <select :disabled="inputDisabled" v-model="sts_config" @change="setCurrentSTSConfig">
                        <option v-for="option in sts_config_options" :value="option.value">
                            {{  option.text }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label for="drn">Enter Meter No</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <input :disabled="inputDisabled" id="drn" name="drn" v-model="drn"/>
                </div>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label for="token">Enter Token</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <input :disabled="inputDisabled" id="token" name="token" v-model="token"/>
                </div>
            </div>
            <div class="row showcase_row_area pt-4 pl-3 col-12 d-block text-center">
                <button :disabled="buttonSubmitDisabled" class="btn btn-primary" @click="decodeToken">
                    Decode &nbsp;&nbsp;
                    <div v-if="showSpinner" id="spinner" class="spinner-border text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div> 
                </button>
            </div>
             <div class="form-group row showcase_row_area col-12">
                <h6>Decoded Token parameters</h6>
                <span id="decoded-token" class="text-center">{{ decodedToken }}</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'MeterComponent',
    props: [
        'sts_configs',
        'sts_config_options'
    ],
    data() {
        return {
            errors: [],
            currSTSConfig: null,
            sts_config: null,
            token: '',
            drn: '',
            showSpinner:false,
            inputDisabled: false,
            params: '',
            decodedToken: '',
            buttonSubmitDisabled: false,
            
        }
    },
    methods:{
        setCurrentSTSConfig: function() {
            this.sts_configs.forEach(config => {
                if (config.config.ref == this.sts_config) {
                    this.currSTSConfig = config;
                    return
                }
            });
        },
        decodeToken: function() {
            let self = this
            
            self.errors = []
            self.showSpinner = true
            self.inputDisabled = true
            self.decodedToken = ''

            if (self.sts_config) {
                if (self.token && self.token.match(/^[0-9]{20}$/)) {
                    if(self.drn && self.drn.match(/^[0-9]{11}|[0-9]{13}$/)) {

                        return axios 
                            .get('/decodeToken', {
                                params: {
                                    sts_config_ref: self.sts_config,
                                    token: self.token,
                                    decoder_reference_number: self.drn,
                                    type: self.currSTSConfig.config.config_type == 'PRISM_THRIFT' ? 'prism-thrift' : 'native'
                                }
                            })
                            .then(response => {
                                if (response.data.status.code == 200) {
                                    self.decodedToken = response.data
            
                                } else {
                                    self.errors.push(response.data.status.message)
                                    
                                }
                            }).finally(() => {
                                self.showSpinner = false
                                self.inputDisabled = false
                        
                            })
                    } else {
                        self.errors.push('Invalid meter no ' + self.drn)
                        self.showSpinner = false
                        self.inputDisabled = false

                    }

                } else {
                    self.errors.push('Invalid token ' + self.token)
                    self.showSpinner = false
                    self.inputDisabled = false

                }
            } else {
                self.errors.push('STS config not selected')
                self.showSpinner = false
                self.inputDisabled = false
            }

        },
        
    }
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Jura:wght@300&display=swap');

#decoded-token {
    font-family: 'Jura', sans-serif;
    font-size: 1em;
}
input, select {
    border: 1px solid #ccc;
    border-radius: 0.3em;
    width: 100%;
    letter-spacing: 0.03rem;
    padding: 0.3em 0.2em;
}
input[name=token_id] {
    border: 1px solid #ccc;
    border-radius: 0.3em;
    width: 100%;
    letter-spacing: 0.03rem;
    padding: 0.3em 0.2em;
    border: 1px solid #ccc;
    font-size: 18px;
}
</style>