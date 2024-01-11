<template>
    <div class="container">
        <div class="grid">
            <div class="grid-body">
                <div class="split-header">
                    <p class="card-title">Details</p>
                    <div class="btn-group">
                        <button
                            type="button"
                            class="btn btn-trasnparent action-btn btn-xs component-flat pr-0"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item"
                                data-toggle="modal"
                                href="#edit-meter-modal">
                                Edit
                            </a>
                            <a class="dropdown-item" 
                                data-toggle="modal"
                                href="#activate-deactivate-meter-modal">
                                <span v-if="meter.activated">
                                    Deactivate
                                </span>
                                <span v-else>
                                    Activate
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="grid-body">
                    
                        <small class="text-black font-weight-medium d-block pt-2">
                            No
                        </small>
                        <p class="text-muted">
                            {{ meter.no }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Ref
                        </small>
                        <p class="text-muted">
                            {{ meter.ref }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Type
                        </small>
                        <p v-if="meter.meterType" class="text-muted">
                            {{ meter.meterType.name }}
                        </p>

                        <span v-if="meter.utility">
                            <small class="text-black font-weight-medium d-block pt-2">
                                Utility
                            </small>
                            <p v-if="meter.meterType" class="text-muted">
                                {{ meter.utility.name }}
                            </p>

                        </span>

                        <span v-if="meter.subscriber">

                            <small class="text-black font-weight-medium d-block pt-2">
                                Subscriber
                            </small>
                            <p v-if="meter.meterType" class="text-muted">
                                {{ meter.subscriber.name }}
                            </p>
                        
                        </span>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Activated
                        </small>
                        <span class="text-gray">
                            <span
                                v-if="meter.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span
                                v-else-if="!meter.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ meter.activated }}
                        </span>
                        <small class="text-black font-weight-medium d-block pt-2">
                            Created At
                        </small>
                        <p class="text-muted">
                            {{ meter.created_at }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <activate-deactivate-meter-component
                :meter="meter"
                @activateDeactivateMeter="activateDeactivateMeter">
        </activate-deactivate-meter-component>

        <edit-meter-component
                :meter="meter"
                :utilities="utilities"
                :meter_types="meter_types"
                :meter_subscribers="meter_subscribers"
                @updatedMeter="updatedMeter"
                @activateDeactivateMeter="activateDeactivateMeter">
        </edit-meter-component>
    </div>
</template>
<script>
import EditMeterComponent from "./EditMeterComponent.vue";
import ActivateDeactivateMeterComponent from "./ActivateDeactivateMeterComponent.vue";

export default {
    components: { 
        EditMeterComponent,
        ActivateDeactivateMeterComponent
    },
    name: "SubscriberMeterComponent",
    props: [
        'meter',
        'utilities',
        'meter_types',
        'meter_subscribers'
    ],
     data() {
        return {
            errors: [],

        };
    },
    methods: {
        updatedMeter: function(meter) {
            this.meter.no = meter.no
            this.meter.ref = meter.ref
            this.meter.meterType.name = meter.meterType.name
            this.meter.activated = meter.activated
            this.meter.utility = meter.utility
            this.meter.subscriber = meter.subscriber
        },
        activateDeactivateMeter: function() {
            this.meter.activated = !this.meter.activated

        },
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>
