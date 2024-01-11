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
                                href="#edit-utility-modal">
                                Edit
                            </a>
                            <a class="dropdown-item" 
                                data-toggle="modal"
                                href="#activate-deactivate-utility-modal">
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
                            Contact Phone No
                        </small>
                        <p class="text-muted">
                            {{ utility.contact_phone_no }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Unit Charge
                        </small>
                        <p class="text-muted">
                            {{ utility.unit_charge }}
                        </p>

                        <span v-for="configOption in configsOptions" v-if="configsOptions">
                            <span v-if="configOption.value == utility.config_ref">
                                <small class="text-black font-weight-medium d-block pt-2">
                                    STS Configuration
                                </small>
                                <p class="text-muted">
                                    {{  configOption.text }}
                                </p>
                            </span>
                        </span>

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

        <activate-deactivate-utility-component
                :utility="utility"
                @activateDeactivateUtility="activateDeactivateUtility">
        </activate-deactivate-utility-component>

        <edit-utility-component
                :utility="utility"
                :configsOptions="configsOptions"
                @updatedUtility="updatedUtility">
        </edit-utility-component>

    </div>
</template>
<script>
import ActivateDeactivateUtilityComponent from "./ActivateDeactivateUtilityComponent.vue";
import EditUtilityComponent from './EditUtilityComponent.vue';

export default {
    components: { 
        ActivateDeactivateUtilityComponent,
        EditUtilityComponent
     },
    name: "UtilityComponent",
    props: [
        'utility',
        'configsOptions'
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
        updatedUtility: function(utility) {
            this.utility.name = utility.name
            this.utility.contact_phone_no = utility.contact_phone_no
            this.utility.unit_charge = utility.unit_charge
            this.utility.activated = utility.activated
            this.utility.config_ref = utility.config_ref
        }
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>
