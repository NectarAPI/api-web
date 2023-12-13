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
                            <a class="dropdown-item"  v-b-modal.activate-deactivate-configuration-modal>
                                <span v-if="configuration.config.activated">
                                    Deactivate
                                </span>
                                <span v-else>
                                    Activate
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid" id="sts-config-details-body">
            <div class="grid-body">
                <small class="text-black font-weight-medium d-block pt-2">
                    Name
                </small>
                <p class="text-muted">
                    {{ configuration.config.name }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Ref
                </small>
                <p class="text-muted">
                    {{ configuration.config.ref }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Activated
                </small>
                <p class="text-muted">
                    {{ configuration.config.activated }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Config Type
                </small>
                <p class="text-muted">
                    {{ configuration.config.config_type }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Created At
                </small>
                <p class="text-muted">
                    {{ configuration.config.created_at }}
                </p>

                <div v-if="configuration.config.config_type == 'NATIVE'">

                    <small class="text-black font-weight-medium d-block pt-2">
                        Decoder Key Generation Algorithm
                    </small>
                    <p class="text-muted">
                        {{ configuration.decoder_key_generation_algorithm }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Vending Key
                    </small>
                    <p class="text-muted">
                        {{ configuration.vending_key }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Key Type
                    </small>
                    <p class="text-muted">
                        {{ configuration.key_type }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Base Date
                    </small>
                    <p class="text-muted">
                        {{ configuration.base_date }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Issuer Identification No
                    </small>
                    <p class="text-muted">
                        {{ configuration.issuer_identification_no }}
                    </p>

                </div>

                <div v-else-if="configuration.config.config_type == 'PRISM_THRIFT'">
                                
                    <small class="text-black font-weight-medium d-block pt-2">
                        Host
                    </small>
                    <p class="text-muted">
                        {{ configuration.host }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Port
                    </small>
                    <p class="text-muted">
                        {{ configuration.port }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Realm
                    </small>
                    <p class="text-muted">
                        {{ configuration.realm }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Username
                    </small>
                    <p class="text-muted">
                        {{ configuration.username }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Password
                    </small>
                    <p class="text-muted">
                        {{ configuration.password }}
                    </p>
                </div>

                <small class="text-black font-weight-medium d-block pt-2">
                    Key Expiry No
                </small>
                <p class="text-muted">
                    {{ configuration.key_expiry_no }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Encryption Algorithm
                </small>
                <p class="text-muted">
                    {{ configuration.encryption_algorithm }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Tariff Index
                </small>
                <p class="text-muted">
                    {{ configuration.tariff_index }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Key Revision No
                </small>
                <p class="text-muted">
                    {{ configuration.key_revision_no }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Supply Group Code
                </small>
                <p class="text-muted">
                    {{ configuration.supply_group_code }}
                </p>

                <small class="text-black font-weight-medium d-block pt-2">
                    Token Carrier Type
                </small>
                <p class="text-muted">
                    {{ configuration.token_carrier_type }}
                </p>
            </div>  
        </div>

        <edit-configuration-component
            :configuration="configuration"
        >
        </edit-configuration-component>
    </div>
</template>
<script>
import EditConfigurationComponent from "./EditConfigurationComponent.vue";

export default {
    components: { EditConfigurationComponent },
    name: 'STSConfigurationDetailsComponent',
    props: [
        'configuration'
    ],
    data() {
        return {
            errors: []
        }
    },
    mounted: function() {
        let self = this;
    }
}
</script>
<style scoped>
#sts-config-details-body {
    height: 411px;
    overflow-y: scroll;
}
</style>
