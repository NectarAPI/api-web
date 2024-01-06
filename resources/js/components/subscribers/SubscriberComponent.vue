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
                        <p class="pb-2 small">{{ subscriber.created_at }}</p>

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
                    </div>
                </div>
            </div>
        </div>

        <edit-subscriber-component
                :subscriber="subscriber"
                @activateDeactivateSubscriber="activateDeactivateSubscriber">
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
        activateDeactivateSubscriber: function() {
            this.subscriber.activated = !this.subscriber.activated

        },
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>
