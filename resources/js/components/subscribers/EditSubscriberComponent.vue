<template>
    <div class="modal fade" 
        tabindex="-1" 
        id="edit-subscriber-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subscriber</h5>
                    <button type="button" @click="resetSubscriberModal" 
                            class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                    <form ref="form" id="editSubscriberForm" class="modal-form">
                        <label for="text-key-name">Name</label>
                        <input id="name" :disabled="buttonSubmitDisabled" name="name" v-model="currSubscriber.name"/>

                        <label for="text-key-name">Contact Phone No</label>
                        <input id="contact_phone_no" :disabled="buttonSubmitDisabled" 
                            name="contact_phone_no" v-model="currSubscriber.phone_no"/>

                        <input type="checkbox"
                            :disabled="buttonSubmitDisabled"
                            class="mt-2"
                            id="activated"
                            name="activated"
                            :checked="currSubscriber.activated ? true : false"/>
                        <span>Activated</span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                        @click="resetSubscriberModal" data-dismiss="modal">Cancel</button>
                    <button type="button" :disabled="buttonSubmitDisabled" 
                        @click="onSubmitEditSubscriber" class="btn btn-primary">
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
    </div>
</template>
<script>
export default {
    name: "EditSubscriberComponent",
    props: [
        'subscriber'
    ],
    data() {
        return {
            errors: [],
            saveSpinner: false,
            buttonSubmitDisabled: false,
        };
    },
    methods: {
        resetSubscriberModal: function() {
            this.errors = []

        },
        onSubmitEditSubscriber: function(event) {
            let self = this
            self.errors = []
            self.saveSpinner = true
            self.buttonSubmitDisabled = true

            let formData = new FormData(document.getElementById("editSubscriberForm"))
            formData.append('subscriber_ref', self.subscriber.ref)

            axios.post('/subscriber/updateSubscriber', formData).then(function(response, status, request) {  
                    
                let responseStatus = response.data.status.code
                let responseMessage = response.data.status.message

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
                    let message = responseMessage + " " + response.data.data.subscriber.data.subscriber.name
                    self.errors.push(message)
                    self.$emit('updatedSubscriber',  response.data.data.subscriber.data.subscriber)

                }

            }, function() {
                self.errors.push('Updating subscriber failed')

            }).finally(() => {
                self.saveSpinner = false
                self.buttonSubmitDisabled = false

            })
            event.preventDefault()

        },
    },
    computed: {
        currSubscriber () {
            return {...this.subscriber}
        }
    },
    mounted: function() {
        let self = this
        self.saveSpinner = false
        self.buttonSubmitDisabled = false
    }
}
</script>
<style scoped>
.modal-header .btn-close {
    position: absolute;
    right: 22px;
    top: 12px;
    width: 25px;
    height: 25px;
    opacity: 0.3;
    border: 0;
    background-color: #fff;
}
.modal-header .btn-close:hover {
  opacity: 1;
}
.modal-header .btn-close:before, .modal-header .btn-close:after {
  position: absolute;
  top: 0;
  left: 15px;
  content: ' ';
  height: 25px;
  width: 2px;
  background-color: #333;
}
.modal-header .btn-close:before {
  transform: rotate(45deg);
}
.modal-header .btn-close:after {
  transform: rotate(-45deg);
}

.modal-form label, .modal-form textarea, .modal-form > input:not(input[type=checkbox]) {
    letter-spacing: 0.03rem;
    display: block;
    width: 100%;
}

.modal-form > input:not(input[type=checkbox]), .modal-form textarea {
    border: 1px solid #ccc;
    border-radius: 0.3em;
    padding: 0.5em;
}

.modal-form label {
    margin-top: 0.5em;
    margin-bottom: 0.1em;
}

.modal-form > input[type=checkbox] {
    margin-right: 0.5em;
    border: 1px solid #ccc;
}

.modal-form select {
    display: block;
    width: 100%;
    border: 1px solid #ccc;
    padding: 0.1em;
    height: auto;
    padding: 0.5em 0.2em
}

.modal-form select option {
    padding: 0.3em 0.3em;
}
</style>