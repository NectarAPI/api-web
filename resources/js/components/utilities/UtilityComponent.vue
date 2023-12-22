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
                            <a class="dropdown-item" data-toggle="modal"
                                href="#activate-deactivate-public-key-modal">
                                <span v-if="utility.activated">
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
                        <p class="pb-2 small">{{ utility.created_at }}</p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Name
                        </small>
                        <p class="text-muted">
                            {{ utility.name }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Ref
                        </small>
                        <p class="text-muted">
                            {{ utility.ref }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Activated
                        </small>
                        <span class="text-gray">
                            <span
                                v-if="utility.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span
                                v-else-if="!utility.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ utility.activated }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <edit-utility-component
                :utility="utility"
                @activateDeactivateUtility="activateDeactivateUtility">
        </edit-utility-component>

    </div>
</template>
<script>
import EditUtilityComponent from "./EditUtilityComponent.vue";

export default {
    components: { EditUtilityComponent },
    name: "UtilityComponent",
    props: [
        'utility'
    ],
     data() {
        return {
            errors: [],

        };
    },
    methods: {
        activateDeactivateUtility: function() {
            this.utility.activated = !this.utility.activated

        },
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>
