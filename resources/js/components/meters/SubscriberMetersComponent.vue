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
                                <p class="card-title ml-n1">Meters</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#create-meter-modal">Create</button>

                                <create-meter-component
                                    :utilities="utilities"
                                    :meter_types="meter_types"
                                    :meter_subscribers="meter_subscribers"
                                    @createdMeter="createdMeter">
                                </create-meter-component>
                            </div>
                        </div>
                    </div>
 
                    <subscriber-meters-table-component
                        :meters="meters"
                        @displayMeterDetails="displayMeterDetails($event)">
                    </subscriber-meters-table-component>
                </div>
            </div>
            <div class="col-md-4 equel-grid">
                <subscriber-meter-component
                    :utilities="utilities"
                    :meter_types="meter_types"
                    :meter_subscribers="meter_subscribers"
                    :meter="currMeter">
                </subscriber-meter-component>
            </div>
        </div>
    </div>
</template>
<script>
import CreateMeterComponent from "./CreateMeterComponent.vue";
import MetersTableComponent from "./SubscriberMetersTableComponent.vue";
import SubscriberMeterComponent from "./SubscriberMeterComponent.vue";

export default {
    components: { 
        CreateMeterComponent, 
        MetersTableComponent, 
        SubscriberMeterComponent 
    },
    name: "SubscriberMetersComponent",
    data() {
        return {
            utilities: [],
            meter_types: [],
            meter_subscribers: [],
            errors: [],
            meters: [],
            currMeter: Object,
            showSpinner: false,
            editKey: ""
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
        fetchMeterTypes() {
            let self = this
            self.fetch("/subscriberMeters/meterTypes")
                .then(response => {
                    for (let obtainedMeterType of response.meter_types) {
                        let meterTypeObj = {
                                            value: obtainedMeterType.ref,
                                            text: obtainedMeterType.name
                                            }
                        self.meter_types.push(meterTypeObj)
                    }
                })
        },
        fetchSubscribers() {
            let self = this
            this.fetch("/subscriberMeters/subscribers")
                .then(response => {
                    for (let obtainedSubscriber of response.subscribers) {
                        let subscriberObj = {
                                                value: obtainedSubscriber.ref,
                                                text: obtainedSubscriber.name
                                            }
                        self.meter_subscribers.push(subscriberObj)
                    }
                })
        },
        createdMeter: function(meter) {
            this.meters.push(meter);
        },
        displayMeterDetails: function(selectedMeter) {
            let self = this;
            self.currMeter = selectedMeter;
        },
        fetchMeters: function() {
            let self = this;

            axios
                .get("/subscriberMeters")
                .then(function(response, status, request) {
                    if (response.data.status.code == 200) {
                        self.meters = response.data.data.meters;
                        
                        if (self.meters.length > 0) {
                            self.currMeter = self.meters[0];
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
        self.fetchMeters();
        self.fetchUtilities()
        self.fetchMeterTypes()
        self.fetchSubscribers()
    }
};
</script>