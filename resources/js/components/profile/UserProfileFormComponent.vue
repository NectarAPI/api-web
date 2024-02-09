<template>
<div class="container">

    <div class="col-md-12 text-center mb-2">
            <p v-if="errors.length">
                <ul class="list-group">
                    <li v-for="error in errors" 
                        v-bind:key="error" 
                        class="list-group-item list-group-item-danger">{{ error }}</li>
                </ul>
              </p>
          </div>

    <form id="updateUserForm" @submit="checkForm" enctype="multipart/form-data">

        <input type="hidden" id="user_ref" name="user_ref" :value="authUserRef" />

        <div class="row">
            
            <div class="col-md-3 col-sm-12 equel-grid">
                <div class="text-center">
                <img :src="image" style="min-height: 200px; min-width:100%" class="avatar img-circle img-thumbnail" alt="avatar">
                <p class="card-title p-2">Upload a different photo...</p>
                <input :disabled="inputDisabled" v-on:change="onFileChange" type="file" accept="image/*" id="image" name="image" class="text-center center-block file-upload">
                </div>
            </div>

            <div class="col-md-9 col-sm-12 equel-grid">
                <div class="grid pt-2">

                    <div class="row pr-4 pl-4 pb-4">
                        <div class="col-10">
                                <small class="text-muted">User ref: {{ authUserRef }} </small>
                        </div>
                        <div class="col-2">
                            <div v-if="showSpinner" 
                                    id="user-details-spinner" 
                                    class="spinner-border text-primary float-right" 
                                    role="status" 
                                    style="height:20px; width: 20px">
                                <span class="sr-only">Loading...</span>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="row pr-4 pl-4">
                        <div class="form-group col-md-6 col-sm-12">
                        <label for="first_name">First Name</label> 
                        <input :disabled="inputDisabled"  v-model="first_name" type="text" class="form-control" id="first_name" name="first_name">
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                        <label for="last_name">Last Name</label> 
                        <input :disabled="inputDisabled" v-model="last_name" type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                    </div>

                    <div class="row p4-4 pl-4">
                        <div class="form-group col-md-6 col-sm-12">
                        <label for="phone_no">Phone No</label> 
                        <input :disabled="inputDisabled" v-model="phone_no" type="text" class="form-control" id="phone_no" name="phone_no">
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                        <label for="email">Email</label> 
                        <input :disabled="inputDisabled" v-model="email" type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <div class="row p4-4 pl-4">
                        <div class="form-group col-md-6 col-sm-12">
                        <label for="username">Username</label> 
                        <input :disabled="inputDisabled" v-model="username" type="text" class="form-control" id="username" name="username">
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                        <label for="password">Password</label> 
                        <input :disabled="inputDisabled" v-model="password" type="password" class="form-control" id="password" placeholder="Enter new password or leave blank to keep current password" name="password">
                        </div>
                    </div>

                    <button @click="resetData" type="button" id="reset" class="btn btn-secondary float-right"> 
                        Reset &nbsp;&nbsp;
                        <div v-if="resetSpinner" 
                                id="reset-spinner" 
                                class="spinner-border text-primary" 
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div> 
                    </button>

                    <button :disabled="buttonSubmitDisabled" 
                            id="submit" type="submit" class="btn btn-primary float-right mr-2"> 
                        Save &nbsp;&nbsp;   
                        <div v-if="saveSpinner" 
                                id="save-spinner" 
                                class="spinner-border text-secondary" 
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div> 
                    </button>

                </div>
            </div>

        </div>
    </form>
</div>
</template>
<script>
    export default {
        name: 'UserProfileFormComponent',
        props: [
            'authUserRef'
        ],
        data() {
            return {
                errors: [],
                image: '',
                first_name: '',
                last_name: '',
                phone_no: '',
                email: '',
                username: '',
                password: '',
                showSpinner: false,
                saveSpinner: false,
                resetSpinner: false,
                inputDisabled: false,
                buttonSubmitDisabled: false
            }
        },
        methods:{
          onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files
                if (!files.length)
                    return
                this.createImage(files[0])
            },
            createImage(file) {
                var image = new Image()
                var reader = new FileReader()
                var self = this

                reader.onload = (e) => {
                    self.image = e.target.result
                }
                reader.readAsDataURL(file)
            },
            check: function(elemsTitle) {
              let self = this
                if (elemsTitle) {
                    elemsTitle.forEach(function(elem, title) {
                        if (!elemsTitle[title][0]) {
                            self.errors.push(elemsTitle[title][1] + ' required')
                        }
                    })
                }
            },
            checkForm: function (e) {
             
                this.errors = []

                this.check([
                    [this.first_name, 'First Name'],
                    [this.last_name, 'Last Name'],
                    [this.username, 'Username'],
                    [this.phone_no, 'Phone No'],
                    [this.email, 'Email'],

                ])

                if (this.errors.length == 0) {

                  let self = this
                  let formData = new FormData(document.getElementById("updateUserForm"))

                  self.saveSpinner = true
                  self.buttonSubmitDisabled = true

                    axios.post('/user', formData).then(function(response, status, request) {  

                            let responseStatus = response.data.status
                            let responseMessage = response.data.message

                            if (responseStatus != 200) {

                                if (typeof responseMessage === 'string' || responseMessage instanceof String) {
                                    self.errors.push(responseMessage)

                                } else if (Array.isArray(responseMessage) || typeof responseMessage == 'object') {
                                    for (const [key, value] of Object.entries(responseMessage)) {
                                    self.errors.push(`${value}`)

                                    }

                                } else {
                                    self.errors.push(responseMessage)

                                }

                            } else {
                                self.errors.push(responseMessage)

                            }

                        }, function(error) {
                            self.errors.push('Registration failed. ' + error.response.statusText)

                    }).finally(() => {
                        self.saveSpinner = false
                        self.buttonSubmitDisabled = false

                    })
                }
                e.preventDefault()
            },
            resetData: function() {
                let self = this
                self.resetSpinner = true

                this.errors = []
                self.fetchData()

            },
            fetchData: function() {
                let self = this

                self.inputDisabled = true

                axios
                    .get('/user?user_ref=' + this.authUserRef)
                    .then(function(response, status, request) {
                        let user = response.data.data.user

                        self.first_name = user.first_name
                        self.last_name = user.last_name
                        self.email = user.email
                        self.phone_no = user.phone_no
                        self.username = user.username
                        self.image = user.image_url

                    }).finally(() => {
                            this.showSpinner = false
                            this.resetSpinner = false
                            self.inputDisabled = false

                    })
            }
        },
        mounted: function() {
            let self = this

            self.image = 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'

            self.saveSpinner = false
            self.resetSpinner = false

            self.showSpinner = true
            self.inputDisabled = true

            self.fetchData()
        }
    }
</script>