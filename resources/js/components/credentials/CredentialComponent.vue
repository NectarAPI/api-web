<template>
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
                            <a class="dropdown-item" v-b-modal.activate-deactivate-credential-modal>
                                <span v-if="credential.activated">
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
                    <p class="pb-2 small">{{ credential.created_at }}</p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Key
                    </small>
                    <p class="text-muted">
                        {{ credential.key }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Secret
                    </small>
                    <p class="text-muted">
                        {{ credential.secret }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Activated
                    </small>
                    <span class="text-gray">
                        <span
                            v-if="credential.activated"
                                class="status-indicator rounded-indicator small bg-primary">
                        </span>
                        <span
                            v-else-if="!credential.activated"
                            class="status-indicator rounded-indicator small bg-secondary">
                        </span>
                            {{ credential.activated }}
                    </span>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Permissions
                    </small>
                    <p class="text-muted">
                        <span v-for="permission in credential.permissions"
                                v-bind:key="permission.ref">
                            {{ permission.name }},
                        </span>
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Ref
                    </small>
                    <p class="text-muted">
                        {{ credential.ref }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Created At
                    </small>
                    <p class="text-muted">
                        {{ credential.createdAt }}
                    </p>
                </div>
            </div>
        </div>

        <edit-credentials-component
                :credential="credential"
                @activateDeactivateCredential="activateDeactivateCredential">
        </edit-credentials-component>
    </div>
</template>
<script>
import EditCredentialsComponent from "./EditCredentialsComponent.vue";

export default {
    components: { EditCredentialsComponent },
    name: "CredentialComponent",
    props: [
        'credential'
    ],
     data() {
        return {
            errors: [],

        };
    },
    methods: {
        activateDeactivateCredential: function() {
            this.credential.activated = !this.credential.activated

        },
    },
    mounted: function() {
        let self = this;
        
    }
};
</script>