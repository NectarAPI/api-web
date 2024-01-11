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
                                <p class="card-title ml-n1">Subscribers</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#create-subscriber-modal">Create</button>
                                        
                                <create-subscriber-component 
                                    :utilities="utilities"
                                    @createdSubscriber="createdSubscriber($event)" />
                            </div>
                        </div>
                    </div>
                    <subscribers-table-component
                        :subscribers="subscribers"
                        @displaySubscribersDetails="displaySubscriberDetails($event)">
                    </subscribers-table-component>
                </div>
            </div>
            <div class="col-md-4 equel-grid">
                <subscriber-component
                    :subscriber="currSubscriber">
                </subscriber-component>
            </div>
        </div>

    </div>
</template>
<script>
import SubscribersTableComponent from "./SubscribersTableComponent.vue";
import SubscriberComponent from "./SubscriberComponent.vue";
import CreateSubscriberComponent from "./CreateSubscriberComponent.vue";

export default {
    components: { 
        SubscribersTableComponent,
        SubscriberComponent,
        CreateSubscriberComponent
    },
    name: "SubscribersComponent",
    data() {
        return {
            utilities: [],
            errors: [],
            subscribers: [],
            currSubscriber: Object,
            showSpinner: false,
        };
    },
    methods: {
        fetch: function(path) {
            return axios
                .get(path)
                .then(response => {
                    if (response.data.status.code == 200) {
                        return response.data.data
                    } else {
                        throw response.data.status.message
                    }
                })
                .catch(err => {
                    throw err
                });

        },
        fetchUtilities() {
            let self = this
            self.fetch("/utility")
                .then(response => {
                    for (let obtainedUtility of response.utilities) {
                        let utilityObj = {
                                            value: obtainedUtility.ref,
                                            text: obtainedUtility.name
                                            }
                        self.utilities.push(utilityObj)
                    }
                })
        },
        createdSubscriber: function(subscriber) {
            this.subscribers.push(subscriber);
            
        },
        displaySubscriberDetails: function(selectedSubscriber) {
            let self = this;
            self.currSubscriber = selectedSubscriber;
        },
        fetchSubscribers: function() {
            let self = this;

            axios
                .get("/subscriber")
                .then(function(response, status, request) {
                    self.subscribers = response.data.data.subscribers;

                    if (self.subscribers.length > 0) {
                        self.currSubscriber = self.subscribers[0];
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
        self.fetchSubscribers();
        self.fetchUtilities();
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
