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
          </div>
          <div v-if="loginfalse=true">
              <form @submit="checkForm" id="registerForm" enctype="multipart/form-data">
                <div style="text-align:center">
                    <small style="line-height: 3.5em">Please enter your registration details</small>
                </div>
                <div class="form-group">
                  <input v-model="first_name" type="text" class="form-control" placeholder="First Name" id="first_name" name="first_name">
                </div>
                <div class="form-group">
                  <input v-model="last_name" type="text" class="form-control" placeholder="Last Name" id="last_name" name="last_name">
                </div>
                <div class="form-group">
                  <input v-model="username" type="text" class="form-control" placeholder="Username" id="username" name="username">
                </div>
                <div class="form-group">
                  <input v-model="phone_no" type="text" class="form-control" placeholder="Phone No" id="phone_no" name="phone_no">
                </div>
                <div class="form-group">
                  <input v-model="email" type="text" class="form-control" placeholder="Email" id="email" name="email">
                </div>
                <div class="form-group">
                  <input v-model="password" type="password" class="form-control" placeholder="Password" id="password" name="password">
                </div>
                <div class="form-group">
                  <input v-model="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                </div>
                <div class="form-group">
                  <div class="custom-file">
                    <input @change="onFileChange" type="file" class="form-control custom-file-input" id="image" name="image">
                    <label id="avatar-label" class="custom-file-label" for="image">{{ avatarLabelText }}</label>
                    <small style="line-height: 3.5em;">* optional</small>
                  </div>
                </div>
                <button :disabled="buttonSubmitDisabled" id="submit" type="submit" class="btn btn-primary btn-block"> Register &nbsp;&nbsp;
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
                image: '',
                first_name: '',
                last_name: '',
                username: '',
                phone_no: '',
                email: '',
                password: '',
                password_confirmation: '',
                image: '',
                showSpinner: false,
                buttonSubmitDisabled: false,
                avatarLabelText: 'Choose avatar'
            }
        },
        methods:{
          onFileChange(e) {
              var files = e.target.files || e.dataTransfer.files;
              if (!files.length)
                return;

              let self = this;
              self.image = files[0];

              self.avatarLabelText = this.image.name

            },
            check: function(elemsTitle) {
              let self = this;
                if (elemsTitle) {
                    elemsTitle.forEach(function(elem, title) {
                        if (!elemsTitle[title][0]) {
                            self.errors.push(elemsTitle[title][1] + ' required');
                        }
                    });
                }
            },
            checkForm: function (e) {
              
                this.errors = [];
          
                this.check([
                    [this.first_name, 'First Name'],
                    [this.last_name, 'Last Name'],
                    [this.username, 'Username'],
                    [this.phone_no, 'Phone No'],
                    [this.email, 'Email'],
                    [this.password, 'Password'],
                    [this.password_confirmation, 'Confirm Password']

                ]);
            
                if (this.errors.length == 0) {

                  let self = this;
                  let formData = new FormData(document.getElementById("registerForm"));

                  self.showSpinner = true
                  self.buttonSubmitDisabled = true

                    axios.post('/register', formData).then(function(response, status, request) {  

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
                            console.log('registration failed');

                    }).finally(() => {
                        self.showSpinner = false
                        self.buttonSubmitDisabled = false

                    });
                }
                e.preventDefault();
            }
        },
        mounted: function() {
            this.showSpinner = false
        }
    }
</script>