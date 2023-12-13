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
                    Please fill in the following details to generate a token.
                </p>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label for="token_type">Token Type</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <p v-if="currSTSConfig">{{ currSTSConfig.config.config_type }}</p>
                </div>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label for="sts_config">STS Configuration</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <b-form-select name="sts_config" id="sts_config" v-model="sts_config" :options="sts_config_options" @change="setCurrentSTSConfig"></b-form-select>
                </div>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label for="drn">Enter Meter No</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <b-form-input :disabled="inputDisabled" id="decoder_reference_number" name="decoder_reference_number" v-model="decoder_reference_number"></b-form-input>
                </div>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label>Token Class</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <b-form-select v-model="token_class" :options="token_class_options" @change="updateTokenFields"></b-form-select>
                </div>
            </div>
            <div class="form-group row showcase_row_area col-12">
                <div class="col-md-3 showcase_text_area">
                    <label>Token SubClass</label>
                </div>
                <div class="col-md-9 showcase_content_area">
                    <b-form-select v-model="token_subclass" :options="token_subclass_options" @change="updateTokenFields"></b-form-select>
                </div>
            </div>

            <!-- class 0 tokens -->

            <div class="col-12" v-if="token_class == 0 && token_subclass">
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9">
                        <datepicker class="vue-picker1" 
                            name="token_id" v-model="token_id" :config="datepicker_options">
                        </datepicker>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="amount">Amount</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="amount" name="amount" v-model="amount"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="random_no">Random No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="random_no" name="random_no" v-model="random_no"></b-form-input>
                    </div>
                </div>
            </div>

            <!-- class 1 tokens -->

            <div class="col-12" v-if="token_class == 1 && token_subclass">
                 <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <datepicker class="vue-picker1" 
                            name="token_id" :disabled="inputDisabled" 
                            v-model="token_id" :config="datepicker_options">
                        </datepicker>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="control">Control</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="control" name="control" v-model="control"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="manufacturer_code">Manufacturer Code</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="manufacturer_code" name="manufacturer_code" v-model="manufacturer_code"></b-form-input>
                    </div>
                </div>
            </div>

            <!-- class 2,0 tokens -->

            <div class="col-12" v-if="token_class == 2 && token_subclass == 0">
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <datepicker class="vue-picker1" 
                            name="token_id"  :disabled="inputDisabled"
                            v-model="token_id" :config="datepicker_options">
                        </datepicker>                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="maximum_power_limit">Maximum Power Limit</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="maximum_power_limit" name="maximum_power_limit" v-model="maximum_power_limit"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="random_no">Random No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="random_no" name="random_no" v-model="random_no"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'PRISM_THRIFT'">
                    <div class="col-md-3 showcase_text_area">
                        <label>Flag Token Type</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-select v-model="flag_token_type" :options="flag_token_types"></b-form-select>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'PRISM_THRIFT'">
                    <div class="col-md-3 showcase_text_area">
                        <label>Flag Token Value</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-select v-model="flag_token_value" :options="flag_token_values"></b-form-select>
                    </div>
                </div>
            </div>

            <!-- class 2,1 tokens -->
            <div class="col-12" v-if="token_class == 2 && token_subclass == 1 && currSTSConfig.config.config_type == 'NATIVE'">
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <datepicker class="vue-picker1" 
                            name="token_id" :disabled="inputDisabled" 
                            v-model="token_id" :config="datepicker_options">
                        </datepicker>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="register">Register</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="register" name="register" v-model="register"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="random_no">Random No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="random_no" name="random_no" v-model="random_no"></b-form-input>
                    </div>
                </div>
            </div>

            <!-- class 2,2 tokens -->

            <div class="col-12" v-if="token_class == 2 && token_subclass == 2 && currSTSConfig.config.config_type == 'NATIVE'">
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <datepicker class="vue-picker1" 
                            name="token_id" :disabled="inputDisabled" 
                            v-model="token_id" :config="datepicker_options">
                        </datepicker>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="tariff_rate">Tariff Rate</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="tariff_rate" name="tariff_rate" v-model="tariff_rate"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="random_no">Random No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="random_no" name="random_no" v-model="random_no"></b-form-input>
                    </div>
                </div>
            </div>

            <!-- class 2,3 tokens -->

            <div class="col-12" v-if="token_class == 2 && 
                                        (token_subclass == 3 || token_subclass == 4)">
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_vending_key">New Vending Key </label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_vending_key" name="new_vending_key" v-model="new_vending_key"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_supply_group_code">New Supply Group Code</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_supply_group_code" name="new_supply_group_code" v-model="new_supply_group_code"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_tariff_index">New Tariff Index</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_tariff_index" name="new_tariff_index" v-model="new_tariff_index"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_key_revision_no">New Key Revision No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_key_revision_no" name="new_key_revision_no" v-model="new_key_revision_no"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_key_type">New Key Type</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_key_type" name="new_key_type" v-model="new_key_type"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_key_expiry_no">New Key Expiry No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_key_expiry_no" name="new_key_expiry_no" v-model="new_key_expiry_no"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_decoder_reference_number">New DRN</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_decoder_reference_number" name="new_decoder_reference_number" v-model="new_decoder_reference_number"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="new_issuer_identification_no">New Issuer Identification No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="new_issuer_identification_no" name="new_issuer_identification_no" v-model="new_issuer_identification_no"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'NATIVE'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="ro">RO</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="ro" name="ro" v-model="ro"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12" v-if="currSTSConfig.config.config_type == 'PRISM_THRIFT'">
                    <div class="col-md-3 showcase_text_area">
                        <label for="allow_3Kct">Allow 3Kct</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-select v-model="allow_3Kct" :options="allow_3Kct_options"></b-form-select>
                    </div>
                </div>
            </div>

             <!-- class 2,5 tokens -->

            <div class="col-12" v-if="token_class == 2 && token_subclass == 5 && currSTSConfig.config.config_type == 'NATIVE'">
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <datepicker class="vue-picker1" 
                            name="token_id" :disabled="inputDisabled" 
                            v-model="token_id" :config="datepicker_options">
                        </datepicker>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="pad">Pad</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="pad" name="pad" v-model="pad"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="random_no">Random No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="random_no" name="random_no" v-model="random_no"></b-form-input>
                    </div>
                </div>
            </div>

            <!-- class 2,6 tokens -->

            <div class="col-12" v-if="token_class == 2 && token_subclass == 6 && currSTSConfig.config.config_type == 'NATIVE'">
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <datepicker class="vue-picker1" 
                            name="token_id" :disabled="inputDisabled" 
                            v-model="token_id" :config="datepicker_options">
                        </datepicker>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="mppul">MPPUL</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="mppul" name="mppul" v-model="mppul"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="random_no">Random No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="random_no" name="random_no" v-model="random_no"></b-form-input>
                    </div>
                </div>
            </div>

             <!-- class 2,7 tokens -->

            <div class="col-12" v-if="token_class == 2 && token_subclass == 7 && currSTSConfig.config.config_type == 'NATIVE'">
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="token_id">Token ID</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <datepicker class="vue-picker1" 
                            name="token_id" :disabled="inputDisabled" 
                            v-model="token_id" :config="datepicker_options">
                        </datepicker>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="wm_factor">WM Factor</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="wm_factor" name="wm_factor" v-model="wm_factor"></b-form-input>
                    </div>
                </div>
                <div class="form-group row showcase_row_area col-12">
                    <div class="col-md-3 showcase_text_area">
                        <label for="random_no">Random No</label>
                    </div>
                    <div class="col-md-9 showcase_content_area">
                        <b-form-input :disabled="inputDisabled" id="random_no" name="random_no" v-model="random_no"></b-form-input>
                    </div>
                </div>
            </div>

            <div class="row showcase_row_area pt-4 pl-3 col-12 d-block text-center">
                <button :disabled="buttonSubmitDisabled" class="btn btn-primary" @click="generateToken">
                    Generate Token &nbsp;&nbsp;
                        <div v-if="showSpinner" id="spinner" class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div> 
                </button>
            </div>
            <div class="col-12 m-4 generatedToken">
                <span id="generated-token" class="d-block text-center">{{ generatedToken }}</span>
            </div>
        </div>
    </div>
</template>
<script>

import Datepicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';


export default {
    components: { 
        datepicker: Datepicker,
    },
    name: 'GeneratorComponent',
    props: [
        'sts_configs',
        'sts_config_options'
    ],
    data() {
        return {
            datepicker_options: {
                format: 'YYYY-MM-DDTHH:mm',
                useCurrent: false,
                icons: {
                    time: 'mdi mdi-clock mdi-1x',
                    date: 'mdi mdi-calendar mdi-1x',
                    up: 'mdi mdi-arrow-up mdi-1x',
                    down: 'mdi mdi-arrow-down mdi-1x',
                    previous: 'mdi mdi-chevron-left mdi-1x',
                    next: 'mdi mdi-chevron-right mdi-1x',
                    today: 'mdi mdi-calendar-check mdi-1x',
                    clear: 'mdi mdi-trash-can mdi-1x',
                    close: 'mdi mdi-close-circle mdi-1x'
                }
            },
            errors: [],
            currSTSConfig: null,
            token_type: null,
            sts_config: null,
            decoder_reference_number: null,
            token_class: null,
            token_subclass: null,
            flag_token_type: null,
            flag_token_value: null,
            allow_3Kct: null,
            generatedToken: '',
            buttonSubmitDisabled: false,
            inputDisabled: false,
            showSpinner:false,
            token_class_options: [
                { value: '0', text: 'Class 0' },
                { value: '1', text: 'Class 1' },
                { value: '2', text: 'Class 2' },
            ],
            token_subclass_options: [],
            flag_token_types: [
                { value: '0', text: 'SetFlagCTSTest' },
                { value: '1', text: 'DetectTamper' },
                { value: '2', text: 'DisconnectService' },
                { value: '3', text: 'DisconnectOnTamper' },
                { value: '4', text: 'DisconnectOnPowerLimit' },
                { value: '5', text: 'DisconnectOnUnderFrequency' },
                { value: '6', text: 'SetElectricityPaymentMode' },
                { value: '7', text: 'SetWaterPaymentMode' },
                { value: '8', text: 'SetGasPaymentMode' },
                { value: '9', text: 'SetTimePaymentMode' },
                { value: '10', text: 'SetCommissioningMode' },
                { value: '11', text: 'EnableTIFallbackPowerLimit' },
            ],
            flag_token_values: [
                { value: '0', text: '0' },
                { value: '1', text: '1' },
            ],
            allow_3Kct_options: [
                { value: true, text: 'Yes' },
                { value: false, text: 'No' },
            ],
            token_id: '',
            amount: '',
            random_no: '',
            control: '',
            manufacturer_code: '',
            pad: '',
            maximum_power_limit: '',
            register: '',
            tariff_rate: '',
            new_vending_key: '',
            new_supply_group_code: '',
            new_tariff_index: '',
            new_key_revision_no: '',
            new_key_type: '',
            new_key_expiry_no: '',
            new_decoder_reference_number: '',
            new_issuer_identification_no: '',
            wm_factor: '',
            ro: ''

        }
    },
    methods: {
        setCurrentSTSConfig: function() {
            let self = this;
            this.sts_configs.forEach(config => {
                if (config.config.ref == this.sts_config) {
                    self.currSTSConfig = config;
                    return
                }
            });
        },
        updateTokenFields: function() {
            this.errors = []
            switch(this.token_class){
                case '0':
                    this.token_subclass_options = [
                                                    { value: '0', text: 'Electricity' },
                                                    { value: '1', text: 'Water' },
                                                    { value: '2', text: 'Gas' },
                                                ]    
                break
                case '1':
                    this.token_subclass_options = [
                                                    { value: '0', text: 'InitiateMeterTestDisplay_10' },
                                                    { value: '1', text: 'InitiateMeterTestDisplay_11' },
                                                ]  
                break
                case '2':
                this.token_subclass_options = [
                                                    { value: '0', text: 'SetMaximumPowerLimit' },
                                                    { value: '1', text: 'ClearCredit' },
                                                    { value: '2', text: 'SetTariffRate' },
                                                    { value: '3', text: 'Key Change Tokens' },
                                                    { value: '5', text: 'ClearTamperCondition' },
                                                    { value: '6', text: 'SetMaximumPhasePowerUnbalanceLimit' },
                                                    { value: '7', text: 'SetWaterMeterFactor' },
                                                ]  
                break
                default:
                    this.token_subclass_options = []

            }
        },
        generateToken: function() {
            let self = this
            self.errors = []
            self.generatedToken =  ''

            if (!self.token_class) {
                self.errors.push('Invalid token class')
            }

            if (!self.token_subclass) {
                self.errors.push('Invalid token subclass')
            }

            if (!self.sts_config) {
                self.errors.push('Invalid STS configuration')
            }

            if(!self.decoder_reference_number || !self.decoder_reference_number.match(/^[0-9]{11}|[0-9]{13}$/)) {
                self.errors.push('Invalid meter no')
            }

            let params = self.validateTokenParams()
            
            if (self.errors.length == 0) {
                params['class'] = self.token_class
                params['subclass'] = self.token_subclass
                params['sts_config_ref'] = self.sts_config
                params['decoder_reference_number'] = self.decoder_reference_number
                params['is_stid'] = true

                if (this.currSTSConfig.config.config_type == 'PRISM_THRIFT') {
                    params['type'] = 'prism-thrift'
                }

                self.showSpinner = true
                self.buttonSubmitDisabled = true

                    axios.post('/generateToken', params)
                        .then((response) => {
                            if (response.data.status.code == 200) {
                                self.generatedToken = response.data.data
                            } else  {
                                self.errors.push(response.data.status.message)
                            }

                        }, (error) => {
                            self.errors.push(error);

                        }).finally(() => {
                            this.showSpinner = false
                            this.buttonSubmitDisabled = false

                        });
                        
            }

        },
        validateTokenParams: function() {
            let self = this

            if (self.token_class == 0) {
                return self.validateClass0Params()
            } else if (self.token_class == 1) {
                return self.validateClass1Params()
            } else if (self.token_class == 2 && self.token_subclass == 0) {
                return self.validateClass20Params()
            } else if (self.token_class == 2 && self.token_subclass == 1) {
                return self.validateClass21Params()
            } else if (self.token_class == 2 && self.token_subclass == 2) {
                return self.validateClass22Params()
            } else if (self.token_class == 2 && 
                    (self.token_subclass == 3 || self.token_subclass == 4)) {
                return self.validateClass234Params()
            } else if (self.token_class == 2 && self.token_subclass == 5) {
                return self.validateClass25Params()
            } else if (self.token_class == 2 && self.token_subclass == 6) {
                return self.validateClass26Params()
            } else if (self.token_class == 2 && self.token_subclass == 7) {
                return self.validateClass27Params()
            }
            
        },
        validateClass0Params: function() {
            this.validateAmount()
           
            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validateRandomNo()

                if (this.errors.length == 0) {
                    return {
                        'token_id' : this.token_id,
                        'amount' : this.amount,
                        'random_no' : this.random_no
                    }
                }
            } else if (this.currSTSConfig.config.config_type == 'PRISM_THRIFT') {
                if (this.errors.length == 0) {
                    return {
                        'amount' : this.amount,
                    }
                }
            }
        },
        validateClass1Params: function() {
            this.validateControl()
            this.validateManufacturerCode()

            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()

                if (this.errors.length == 0) {
                    return {
                        'token_id' : this.token_id,
                        'control' : this.control,
                        'manufacturer_code' : this.manufacturer_code
                    }
                }

            } else if (this.currSTSConfig.config.config_type == 'PRISM_THRIFT') {
                if (this.errors.length == 0) {
                    return {
                        'control' : this.control,
                        'manufacturer_code' : this.manufacturer_code
                    }
                }
            }
            
        },
        validateClass20Params: function() {
            
            this.validateMaximumPowerLimit()

            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validateRandomNo()

                if (this.errors.length == 0)
                    return {
                        'token_id' : this.token_id,
                        'maximum_power_limit' : this.maximum_power_limit,
                        'random_no' : this.random_no
                    }

            } else if (this.currSTSConfig.config.config_type == 'PRISM_THRIFT') {
                this.validateFlagTokenType()
                this.validateFlagTokenValue()

                if (this.errors.length == 0)
                    return {
                        'flag_token_type' : this.flag_token_type,
                        'maximum_power_limit' : this.maximum_power_limit,
                        'flag_token_value' : this.flag_token_value
                    }
            }
            
        },
        validateClass21Params: function() {
            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validateRegister()
                this.validateRandomNo()

                if (this.errors.length == 0)
                    return {
                        'token_id' : this.token_id,
                        'register' : this.register,
                        'random_no' : this.random_no
                    }
            } else return {}
        },
        validateClass22Params: function() {
            
            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validateTariffRate()
                this.validateRandomNo()

                if (this.errors.length == 0)
                    return {
                        'token_id' : this.token_id,
                        'tariff_rate' : this.tariff_rate,
                        'random_no' : this.random_no
                    }
                
            } else return {}
        },
        validateClass234Params: function() {
            this.validateNewSupplyGroupCode()
            this.validateNewTariffIndex()
            this.validateNewKeyRevisionNo()

            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validateNewVendingKey()
                this.validateNewKeyType()
                this.validateNewKeyExpiryNo()
                this.validateNewDrn()
                this.validateNewIssuerIdentificationNo()
                this.validateRo()   

                if (this.errors.length == 0) {
                    return {
                            'token_id' : this.token_id,
                            'new_vending_key' : this.new_vending_key,
                            'new_supply_group_code' : this.new_supply_group_code,
                            'new_tariff_index' : this.new_tariff_index,
                            'new_key_revision_no' : this.new_key_revision_no,
                            'new_key_type' : this.new_key_type,
                            'new_key_expiry_no' : this.new_key_expiry_no,
                            'new_decoder_reference_number' : this.new_decoder_reference_number,
                            'new_issuer_identification_no' : this.new_issuer_identification_no,
                            'ro' : this.ro,
                        }
                }

            } else if (this.currSTSConfig.config.config_type == 'PRISM_THRIFT') {
                if (this.errors.length == 0) {
                    return {
                        'new_supply_group_code' : this.new_supply_group_code,
                        'new_tariff_index' : this.new_tariff_index,
                        'new_key_revision_no' : this.new_key_revision_no,
                        'allow_3Kct': this.allow_3Kct
                    }
                }

            }
        },
        validateClass25Params: function() {
            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validatePad()
                this.validateRandomNo()

                if (this.errors.length == 0)
                    return {
                        'token_id' : this.token_id,
                        'pad' : this.pad,
                        'random_no' : this.random_no
                    }
            } else return {}

        },
        validateClass26Params: function() {
            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validateMppul()
                this.validateRandomNo()

            if (this.errors.length == 0) {
                return {
                        'token_id' : this.token_id,
                        'mppul' : this.mppul,
                        'random_no' : this.random_no
                    }
                }
            } else return {}
        },
        validateClass27Params: function() {
            if (this.currSTSConfig.config.config_type == 'NATIVE') {
                this.validateTokenID()
                this.validateWmFactor()
                this.validateRandomNo()

                if (this.errors.length == 0) {
                    return {
                        'token_id' : this.token_id,
                        'wm_factor' : this.wm_factor,
                        'random_no' : this.random_no
                    }
                }
            } else return {}
        },
        validateTokenID: function() {
            if (!/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/.test(this.token_id)) 
                this.errors.push('Invalid token ID')            
        },
        validateAmount: function() {
            if (!/^\d+$|^[0-9].*\.[0-9]{2}$/.test(this.amount)) {
                this.errors.push('Invalid amount')
            }
        },
        validateRandomNo: function() {
            if (!/^[0-9]$/.test(this.random_no)) {
                this.errors.push('Invalid random no')
            }
        },
        validateControl: function() {
            if (!/^\d+$/.test(this.control)) {
                this.errors.push('Invalid control')
            }
        },
        validateManufacturerCode: function() {
            if (!/^[0-9]{2}$|^[0-9]{4}$/.test(this.manufacturer_code)) {
                this.errors.push('Invalid Manufacturer Code')
            }
        },
        validateMaximumPowerLimit: function() {
            if (!/^\d+$/.test(this.maximum_power_limit)) {
                this.errors.push('Invalid Maximum Power Limit')
            }
        },
        validateRegister: function() {
            if (!/^[0-7]$/.test(this.register)) {
                this.errors.push('Invalid register')
            }
        },
        validateTariffRate: function() {
            if (!/^\d+$/.test(this.tariff_rate)) {
                this.errors.push('Invalid tariff rate')
            }
        },
        validateNewVendingKey: function() {
            if (!/^[0-9a-fA-F]{16}$/.test(this.new_vending_key)) {
                this.errors.push('Invalid vending key')
            }
        },
        validateNewSupplyGroupCode: function() {
            if (!/^[0-9]{6}$/.test(this.new_supply_group_code)) {
                this.errors.push('Invalid new supply group code')
            }
        },
        validateNewTariffIndex: function() {
            if (!/^[0-9]{2}$/.test(this.new_tariff_index)) {
                this.errors.push('Invalid new tariff Index')
            }
        },
        validateNewKeyRevisionNo: function() {
            if (!/^[1-9]{1}$/.test(this.new_key_revision_no)) {
                this.errors.push('Invalid new key revision no')
            }
        },
        validateNewKeyType: function() {
            if (!/^[0-3]$/.test(this.new_key_type)) {
                this.errors.push('Invalid key type')
            }
        },
        validateNewKeyExpiryNo: function() {
            if (!/^([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])$/.test(this.new_key_expiry_no)) {
                this.errors.push('Invalid new key expiry no')
            }
        },
        validateNewIssuerIdentificationNo: function() {
            if (!/^[0-9]{6}$|^[0]{4}$/.test(this.new_issuer_identification_no)) {
                this.errors.push('Invalid new issuer identification no')
            }
        },
        validateNewDrn: function() {
            if (!/^[0-9]{11,13}$/.test(this.new_decoder_reference_number)) {
                this.errors.push('Invalid new DRN')
            }
        },
        validateRo: function() {
            if (!/^[0-1]$/.test(this.ro)) {
                this.errors.push('Invalid RO')
            }
        },
        validatePad: function() {
            if (!/^\d+$/.test(this.pad)) {
                this.errors.push('Invalid pad')
            }
        },
        validateMppul: function() {
            if (!/^\d+$/.test(this.mppul)) {
                this.errors.push('Invalid MPPUL')
            }
        },
        validateWmFactor: function() {
            if (!/^\d+$/.test(this.wm_factor)) {
                this.errors.push('Invalid WM Factor')
            }
        },
        validateFlagTokenType: function() {
            if (!/^10|[0-9]$/.test(this.flag_token_type)) {
                this.errors.push('Invalid flag token type')
            }
        },
        validateFlagTokenValue: function() {
            if (!/^[0-1]$/.test(this.flag_token_value)) {
                this.errors.push('Invalid flag token value')
            }
        }
    }
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Jura:wght@300&display=swap');

.form-control {
    display: flex;
    align-items: stretch;
    height: auto;
}
</style>

<style>
#token_id {
    border: 0;
    padding: 0;
    box-shadow: none!important;
    margin: 0;
}

#token_id__value_ {
    border: 0;
    height: auto;
    line-height: 1em;
}

#generated-token {
    font-family: 'Jura', sans-serif;
    font-size: 1em;
}

.bootstrap-datetimepicker-widget {
    position: absolute;
    z-index: 100;
}
</style>