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
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="grid-body">
                        <p class="pb-2 small">{{ meter.created_at }}</p>

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

                    </div>
                </div>
            </div>
        </div>
        <edit-meter-component
                :meter="meter"
                @activateDeactivateMeter="activateDeactivateMeter">
        </edit-meter-component>
    </div>
</template>
<script>
import EditMeterComponent from "./EditMeterComponent.vue";

export default {
    components: { EditMeterComponent },
    name: "SubscriberMeterComponent",
    props: [
        'meter'
    ],
     data() {
        return {
            errors: [],

        };
    },
    methods: {
        activateDeactivateMeter: function() {
            this.meter.activated = !this.meter.activated

        },
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>
