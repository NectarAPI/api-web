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
                                    data-target="#upload-meter-modal">Create</button>

                                <!-- <upload-meter-component
                                    @createdMeter="createdMeter">
                                </upload-meter-component> -->
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
                    :meter="currMeter">
                </subscriber-meter-component>
            </div>
        </div>
    </div>
</template>
<script>
import UploadMeterComponent from "./UploadMeterComponent.vue";
import MetersTableComponent from "./SubscriberMetersTableComponent.vue";
import SubscriberMeterComponent from "./SubscriberMeterComponent.vue";

export default {
    components: { UploadMeterComponent, MetersTableComponent, SubscriberMeterComponent },
    name: "SubscriberMetersComponent",
    data() {
        return {
            errors: [],
            meters: Array,
            currMeter: Object,
            showSpinner: false,
            editKey: ""
        };
    },
    methods: {
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
    }
};
</script>