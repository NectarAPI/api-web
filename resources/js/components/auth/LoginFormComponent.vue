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
            <form @submit="checkForm" id="loginForm">
                <div style="text-align:center">
                    <small style="line-height: 3.5em">Please enter your login credentials</small>
                </div>
                <div class="form-group">
                    <input v-model="username" type="text" class="form-control" placeholder="Username" id="username" name="username">
                </div>
                <div class="form-group">
                    <input v-model="password" type="password" class="form-control" placeholder="Password" id="password" name="password">
                </div>
                <div class="form-inline">
                    <div class="checkbox">
                        <input style="float:left" v-model="remember_me" type="checkbox" class="form-control" id="remember_me" name="remember_me">
                        <label style="padding-top: 0.4em" for="remember_me">Remember Me</label>
                    </div>
                </div>
                <button :disabled="buttonSubmitDisabled" id="submit" type="submit" class="btn btn-primary btn-block"> Login &nbsp;&nbsp;
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
                username: '',
                password: '',
                remember_me: false,
                showSpinner: false,
                buttonSubmitDisabled: false
            }
        },
        methods:{
            checkForm: function (e) {
                this.errors = [];
          
                if (!this.username) {
                    this.errors.push('Username required.');
                }
         
                if (!this.password) {
                    this.errors.push('Password required.');

                } else {
                    let self = this;
                    let formData = new FormData(document.getElementById("loginForm"))

                    this.showSpinner = true
                    this.buttonSubmitDisabled = true

                    axios.post('/login', formData).then(function(response, status, request) {  

                            let responseStatus = response.data.status;
                            let responseMessage = response.data.message;

                            if (responseStatus != 200) {
                                if (typeof responseMessage === 'string' || responseMessage instanceof String) {

                                    self.errors.push(responseMessage);

                                } else if (Array.isArray(responseMessage)) {
                                    for (const [key, value] of Object.entries(responseMessage)) {
                                    self.errors.push(`${value}`);

                                    }
                                } else {
                                    self.errors.push(responseMessage);
                                }

                            } else {
                                window.location.replace('/dashboard');
                            }

                        }, function() {
                            console.log('login failed');

                    }).finally(() => {
                        this.showSpinner = false
                        this.buttonSubmitDisabled = false

                    });
                }
                e.preventDefault();
            },
        },
        mounted: function() {
            this.showSpinner = false

        }
    }
</script>
<style scoped>
.checkbox {
    width: 100%;
}
.checkbox #remember_me {
    float: left;
    width: 1.5em;
    height: 1.5em;
}
</style>