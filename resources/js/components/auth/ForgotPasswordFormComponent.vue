<template>
    <div class="container">
        <div class="col-md-12 text-center">
            <p v-if="errors.length">
                <ul class="list-group">
                    <li v-for="error in errors" 
                                v-bind:key="error" 
                                class="list-group-item list-group-item-danger">{{ error }}
                    </li>
                </ul>
            </p>
        </div>
        <div v-if="loginfalse=true">
            <form @submit="checkForm" id="forgotPasswordForm">
                <div style="text-align:center">
                    <small style="line-height: 3.5em">Please enter your email to reset your password</small>
                </div>
                <div class="form-group">
                    <input v-model="email" type="text" class="form-control" placeholder="Email" id="email" name="email">
                </div>
                <button :disabled="buttonSubmitDisabled" id="submit" type="submit" class="btn btn-primary btn-block"> Reset Password &nbsp;&nbsp;
                    <div v-if="showSpinner" id="spinner" class="spinner-border text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div> 
                </button>
                
            </form>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                errors: [],
                email: '',
                showSpinner: false,
                buttonSubmitDisabled: false
            }
        },
        methods:{
            checkForm: function (e) {
                this.errors = [];
         
                if (!this.email) {
                    this.errors.push('Email required.');

                } else {
                    let self = this;
                    let formData = new FormData(document.getElementById("forgotPasswordForm"))

                    self.showSpinner = true
                    self.buttonSubmitDisabled = true

                    axios.post('/email/forgot-password', formData).then(function(response, status, request) {  

                            let responseStatus = response.data.status;
                            let responseMessage = response.data.message;

                            if (typeof responseMessage === 'string' || responseMessage instanceof String) {

                                self.errors.push(responseMessage);

                            } else if (Array.isArray(responseMessage)) {
                                for (const [key, value] of Object.entries(responseMessage)) {
                                    self.errors.push(`${value}`);

                                }

                            } else {
                                self.errors.push(responseMessage);
                                
                            }


                        }, function() {
                            console.log('reset password form failed');

                    }).finally(() => {
                        this.showSpinner = false
                        this.buttonSubmitDisabled = false

                    });
                }
                e.preventDefault();
            },
        },
        mounted: function() {
            this.buttonSubmitDisabled = false
            this.showSpinner = false
        }
    }
</script>