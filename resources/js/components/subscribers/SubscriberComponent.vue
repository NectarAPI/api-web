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
                                href="#edit-subscriber-modal">
                                Edit
                            </a>
                            <a data-toggle="modal"
                                class="dropdown-item" 
                                href="#activate-deactivate-subscriber-modal">
                                <span v-if="subscriber.activated">
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
                            Name
                        </small>
                        <p class="text-muted">
                            {{ subscriber.name }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Ref
                        </small>
                        <p class="text-muted">
                            {{ subscriber.ref }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Contact Phone No
                            </small>
                        <p class="text-muted text-justify"
                            style="word-wrap: break-word;">
                            {{ subscriber.phone_no }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Activated
                        </small>
                        <span class="text-gray">
                            <span
                                v-if="subscriber.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span
                                v-else-if="!subscriber.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ subscriber.activated }}
                        </span>
                        <small class="text-black font-weight-medium d-block pt-2">
                            Created At
                        </small>
                        <p class="text-muted">
                            {{ subscriber.created_at }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <edit-subscriber-component
                :subscriber="subscriber"
                @updatedSubscriber="updatedSubscriber">
        </edit-subscriber-component>

        <activate-deactivate-subscriber-component
                :subscriber="subscriber"
                @activateDeactivateSubscriber="activateDeactivateSubscriber">
        </activate-deactivate-subscriber-component>

    </div>
</template>
<script>
import EditSubscriberComponent from "./EditSubscriberComponent.vue";
import ActivateDeactivateUtilityComponent from "./ActivateDeactivateSubscriberComponent.vue";

export default {
    components: { 
        EditSubscriberComponent, 
        ActivateDeactivateUtilityComponent 
    },
    name: "SubscriberComponent",
    props: [
        'subscriber'
    ],
     data() {
        return {
            errors: [],

        };
    },
    methods: {
        updatedSubscriber: function(subscriber) {
            this.subscriber.name = subscriber.name
            this.subscriber.phone_no = subscriber.phone_no
            this.subscriber.activated = subscriber.activated
            this.subscriber.created_at = subscriber.created_at
            this.subscriber.updated_at = subscriber.updated_at
        },
        activateDeactivateSubscriber: function() {
            this.subscriber.activated = !this.subscriber.activated

        },
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>
