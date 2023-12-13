<template>
    <div class="container">
        <div class="col-md-12 text-center">
            <p v-if="errors.length">
                <ul class="list-group">
                    <li v-for="error in errors" 
                        v-bind:key="error" 
                        class="list-group-item list-group-item-danger">{{ error }}</li>
                </ul>
            </p>
            <div v-if="loginfalse=true">
                <form @submit="checkForm" id="resetEmailForm">
                    
                  <input type="hidden" id="user_key" name="user_key" :value="userKey" />
                  
                  <div style="text-align:center">
                    <small style="line-height: 3.5em">Please enter the details below.</small>
                  </div> 
                  <div class="form-group">
                    <input name="email" id="email" class="form-control" v-model="email" placeholder="Email" type="text" required>
                  </div>
                  <div class="form-group">
                    <input name="password" id="password" class="form-control" v-model="password" placeholder="New Password" type="password" required>
                  </div>
                  <div class="form-group">
                    <input name="password_confirmation" id="password_confirmation" class="form-control" v-model="password_confirmation" placeholder="Renter New Password" type="password" required>
                  </div>
                  <button :disabled="buttonSubmitDisabled" id="submit" type="submit" class="btn btn-primary btn-block"> Reset Password &nbsp;&nbsp;
                    <div v-if="showSpinner" id="spinner" class="spinner-border text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div> 
                </button>
                </form>
            </div>    
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'userKey'
        ],
        data() {
            return {
                errors: [],
                email: '',
                password: '',
                password_confirmation: '',
                showSpinner: false,
                buttonSubmitDisabled: false
            }
        },
        methods:{
          checkForm: function (e) {
                this.errors = [];
          
                if (!this.email) {
                    this.errors.push('Email required.');
                } 

                if (!this.password) {
                    this.errors.push('Password required');
                }

                if (!this.password_confirmation) {
                    this.errors.push('Password confirmation required');
                } else {
                    let self = this;
                    let formData = new FormData(document.getElementById("resetEmailForm"));
    
                    self.showSpinner = true
                    self.buttonSubmitDisabled = true

                    axios.post('/password/reset', formData).then(function(response, status, request) {  

                        let responseStatus = response.data.status;
                        let responseMessage = response.data.message;

                        if (responseStatus != 200) {
                                if (typeof responseMessage === 'string' || responseMessage instanceof String) {
                                    self.errors.push(responseMessage);

                                } else if (Array.isArray(responseMessage) || typeof responseMessage == 'object') {
                                    for (const [key, value] of Object.entries(responseMessage)) {
                                    self.errors.push(`${value}`);

                                    }
                                } else {
                                    self.errors.push(responseMessage);
                                }

                            } else {
                                self.errors.push(responseMessage);

                            }

                        }, function() {
                            console.log('reset email form failed');

                    }).finally(() => {
                        this.showSpinner = false
                        this.buttonSubmitDisabled = false

                    });
                }
                e.preventDefault();
            }
        },
        mounted: function() {
            this.showSpinner = false
            this.buttonSubmitDisabled = false
        }
    }
</script>