<template>
    <div>
        <h6 class="mb-2 display-income">{{ availCredits }} Credits</h6>
        <b-button :disabled="inputDisabled" v-b-modal.buy-credits-modal>
            Buy
        </b-button>
        <b-modal
        id="buy-credits-modal"
        title="Buy Credits">
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
            <div>
                <b-tabs content-class="mt-3">
                    <b-tab title="MPESA" active>
                        <div role="group">
                            <label for="phone-no">Phone No:</label>
                            <b-form-input
                                id="phone-no"
                                v-model="phoneNo"
                                :state="phoneNoState"
                                :disabled="inputDisabled"
                                aria-describedby="phone-no-help phone-no-feedback"
                                placeholder="Enter an MPESA enabled phone No"
                                trim
                            ></b-form-input>

                            <b-form-invalid-feedback id="phone-no-feedback">Enter a valid Safaricom phone number</b-form-invalid-feedback>

                            <b-form-text id="phone-no-help">A Safaricom phone no.</b-form-text>
                        </div>

                        <div role="group">
                            <label for="smount">Amount:</label>
                            <b-form-input 
                                    v-model="amount"
                                    :state="amountState"
                                    :disabled="inputDisabled"
                                    aria-describedby="amount-help amount-feedback"
                                    placeholder="Enter an MPESA enabled phone no"
                                    trim>
                                <b-form-input></b-form-input>
                            </b-form-input>

                            <b-form-invalid-feedback id="amount-feedback">Enter a valid amount</b-form-invalid-feedback>

                            <b-form-text id="amount-help">Reload amount</b-form-text>

                            <div class="mt-2"><b-badge>Credits: {{ credits }}</b-badge></div>

                        </div>

                    </b-tab>
                     <b-tab title="Others" >
                        <p>Other payment types coming soon. Please reach out to info@nectar.software for alternative payment modes</p>
                    </b-tab>
                </b-tabs>
            </div>
            <div slot="modal-footer">
                    <b-btn variant="secondary" :disabled="inputDisabled">Cancel</b-btn>
                    <b-btn :disabled="inputDisabled" variant="primary" @click="onBuyCredits">
                        Buy &nbsp;&nbsp;   
                        <div v-if="buyCreditsStatus" 
                            id="save-spinner" 
                                class="spinner-border text-secondary" 
                                role="status">
                                <span class="sr-only">Loading...</span>
                        </div> 
                    </b-btn>
                </div>
        </b-modal>
    </div>
</template>
<script>                        
export default {
    name: 'BuyCreditsComponent',
    computed: {
      phoneNoState() {
        return /^07[0-9]{8}$/.test(this.phoneNo)
      },
      amountState() {
          if (/^\d+$/.test(this.amount) && this.amount > 0) {
              this.credits = this.amount
              return true
          } else {
              this.credits = 0
          }
          return false
      }
    },
    data() {
        return {
            errors: [],
            credits: 0,
            buyCreditsStatus: false,
            phoneNo: '',
            amount: '',
            credits: 0,
            availCredits: '',
            completed: false, 
            pollInterval: null,
            inputDisabled: false
        }
    },
    methods: {
        checkPaymentStatus(transactionRef) {
            axios
                .get('/getPaymentStatus?ref=' + transactionRef)
                .then(response => {
                    if(response.data.status.code == 200 
                        && response.data.payment_status.resultCode) {
                        this.errors.push(response.data.payment_status.resultDesc)
                        clearInterval(this.pollInterval)
                        this.completed = true

                        if (response.data.payment_status.resultDesc) {
                            this.getCredits()
                            this.buyCreditsStatus = false
                            this.inputDisabled = false
                        }   
                    }
            });
        },
        async schedulePayment() {
            return axios
                .post('/schedulePayment', {
                    amount: this.amount,
                    phone_no: '254' + this.phoneNo.substring(1),

                })
                .then(response => {
                    if (response.data.status.code == 200) {
                        return response.data.transaction_ref
            
                    } else {
                        this.errors.push(response.data.status.message)
                    }
                })
        },
        onBuyCredits: function() {
            this.buyCreditsStatus = true
            this.inputDisabled = true
            this.errors = []

            this.schedulePayment().then((transactionRef) => {
                this.pollInterval = setInterval(() => { this.checkPaymentStatus(transactionRef) }, 5000);
                
                setTimeout(() => {
                    if (!this.completed) {
                        this.errors.push('Error processing payment ' + transactionRef + '. Please try again.')
                        clearInterval(this.pollInterval)
                        this.buyCreditsStatus = false
                        this.inputDisabled = false
                    }
                }, 60000)
                
            })
        },
        getCredits: function() {
            let self = this
            return axios 
                .get('/getCredits')
                .then(response => {
                    if (response.data.status.code == 200) {
                        self.availCredits = response.data.data.credits.credits
   
                    } else {
                        self.errors.push(response.data.status.message)
                        
                    }
                })
        }
    },
    async mounted() {
        let self = this
        self.showSpinner = true

        self.getCredits()
    }
}
</script>