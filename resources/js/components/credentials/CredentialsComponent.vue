<template>
    <div class="container">
        <div class="col-12 row text-center">
            <p v-if="errors.length">
                <ul class="list-group">
                    <li v-for="error in errors" 
                        v-bind:key="error" 
                        class="list-group-item list-group-item-danger">{{ error }}
                    </li>
                </ul>
            </p>
        </div>
        <div class="row spinner-row">
            <div class="col-10"></div>
            <div class="col-2">
                <div
                    v-if="showSpinner"
                    id="load-details-spinner"
                    class="spinner-border text-primary float-right"
                    role="status"
                    style="height:20px; width: 20px"
                >
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 equel-grid">
                <div class="grid">
                    <div class="grid-body py-3">
                        <div class="row">
                            <div class="col-10">
                                <p class="card-title ml-n1">Credentials</p>
                            </div>
                            <div class="col-2">
                                <b-button v-b-modal.upload-credential-modal
                                    >Create</b-button
                                >

                                <upload-credential-component
                                    @createdCredential="createdCredential"
                                >
                                </upload-credential-component>
                            </div>
                        </div>
                    </div>

                    <credentials-table-component
                        :credentials="credentials"
                        @displayCredentialsDetails="
                            displayCredentialsDetails($event)
                        "
                    >
                    </credentials-table-component>
                </div>
            </div>
            <div class="col-md-4 equel-grid">
                <credential-component
                    :credential="currCredential"></credential-component>
            </div>
        </div>
    </div>
</template>
<script>
import UploadCredentialComponent from "./UploadCredentialComponent.vue";

export default {
    components: { UploadCredentialComponent },
    name: "CredentialsComponent",
    data() {
        return {
            errors: [],
            credentials: Array,
            currCredential: Object,
            showSpinner: false,
            editKey: ""
        };
    },
    methods: {
        createdCredential: function(credential) {
            this.credentials.push(credential);
        },
        displayCredentialsDetails: function(selectedCredential) {
            let self = this;
            self.currCredential = selectedCredential;
        },
        fetchCredentials: function() {
            let self = this;

            axios
                .get("/creds")
                .then(function(response, status, request) {
                    if (response.data.status.code == 200) {
                        self.credentials = response.data.data.credentials;
                        
                        if (self.credentials.length > 0) {
                            self.currCredential = self.credentials[0];
                        }
                    } else {
                        self.errors.push(response.data.status.message)
                    }
                    
                })
                .finally(() => {
                    self.showSpinner = false;
                });
        }
    },
    mounted: function() {
        let self = this;
        self.showSpinner = true;
        self.fetchCredentials();
    }
};
</script>
