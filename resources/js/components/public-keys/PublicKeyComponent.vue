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
                            <a data-toggle="modal"
                                class="dropdown-item" 
                                href="#activate-deactivate-public-key-modal">
                                <span v-if="publicKey.activated">
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
                            {{ publicKey.name }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Ref
                        </small>
                        <p class="text-muted">
                            {{ publicKey.ref }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Key
                            </small>
                        <p class="text-muted text-justify"
                            style="word-wrap: break-word;">
                            {{ publicKey.key }}
                        </p>

                        <small class="text-black font-weight-medium d-block pt-2">
                            Activated
                        </small>
                        <span class="text-gray">
                            <span
                                v-if="publicKey.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span
                                v-else-if="!publicKey.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ publicKey.activated }}
                        </span>
                        <small class="text-black font-weight-medium d-block pt-2">
                            Created At
                        </small>
                        <p class="text-muted">
                            {{ publicKey.created_at  }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <edit-public-key-component
                :publicKey="publicKey"
                @activateDeactivatePublicKey="activateDeactivatePublicKey">
        </edit-public-key-component>

    </div>
</template>
<script>
import EditPublicKeyComponent from "./EditPublicKeyComponent.vue";

export default {
    components: { EditPublicKeyComponent },
    name: "PublicKeyComponent",
    props: [
        'publicKey'
    ],
     data() {
        return {
            errors: [],

        };
    },
    methods: {
        activateDeactivatePublicKey: function() {
            this.publicKey.activated = !this.publicKey.activated

        },
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>
