<template>
    <div class="container">
        <div class="row spinner-row">
            <div class="col-10"></div>
            <div class="col-2">
                <div
                    v-if="showSpinner"
                    id="load-details-spinner"
                    class="spinner-border text-primary float-right"
                    role="status"
                    style="height:20px; width: 20px">
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
                                <p class="card-title ml-n1">Public Keys</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#upload-public-key-modal">Upload</button>
                                        
                                <upload-public-key-component
                                    @fetchPublicKeys="fetchPublicKeys"
                                    @createdPublicKey="createdPublicKey">
                                </upload-public-key-component>
                            </div>
                        </div>
                    </div>
                    <public-keys-table-component
                        :public-keys="publicKeys"
                        @displayPublicKeyDetails="displayPublicKeyDetails($event)">
                    </public-keys-table-component>
                </div>
            </div>
            <div class="col-md-4 equel-grid">
                <public-key-component
                    :public-key="currPublicKey">
                </public-key-component>
            </div>
        </div>

    </div>
</template>
<script>
import UploadPublicKeyComponent from "./UploadPublicKeyComponent.vue";

export default {
    components: { UploadPublicKeyComponent },
    name: "PublicKeysComponent",
    data() {
        return {
            errors: [],
            publicKeys: Array,
            currPublicKey: Object,
            showSpinner: false,
            editKey: ""
        };
    },
    methods: {
        createdPublicKey: function(publicKey) {
            this.publicKeys.push(publicKey);
            
        },
        displayPublicKeyDetails: function(selectedPublicKey) {
            let self = this;
            self.currPublicKey = selectedPublicKey;
        },
        fetchPublicKeys: function() {
            let self = this;

            axios
                .get("/pkeys")
                .then(function(response, status, request) {
                    self.publicKeys = response.data.data.public_keys;

                    if (self.publicKeys.length > 0) {
                        self.currPublicKey = self.publicKeys[0];
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
        self.fetchPublicKeys();
    }
};
</script>
<style scoped>
.spinner-row {
    margin: 0;
    padding: 0;
    position: relative;
    top: -30px;
    height: 0;
    max-height: 0;
}
</style>
