<template>
    <div class="content-viewport">
        <div class="row">
            <div class="col-12 pb-4 pt-2">
                <h4>Manage Configurations</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 equel-grid">
                <div class="grid">
                    <div class="grid-body py-3">
                        <div class="row">
                            <div class="col-12">
                                <p class="card-title ml-n1">
                                    STS Configurations
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- <sts-configurations-table-component
                        :configurations="getSTSConfigurations"
                        :showSpinner="showSpinner"
                        @displaySTSConfigurationDetails="displaySTSConfigurationDetails($event)">
                    </sts-configurations-table-component> -->
                </div>
            </div>
            <div class="col-md-4 equel-grid">
                <div class="grid">
                    <!-- <sts-configuration-details-component
                        :configuration="currConfiguration">
                    </sts-configuration-details-component> -->
                </div>
            </div>
        </div>
        <div class="row">
            <h5 class="pb-4 pt-2">Add Configurations</h5>
            <nav class="col-12">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a
                        class="nav-item nav-link active"
                        id="nav-profile-tab"
                        data-toggle="tab"
                        href="#nav-option-1"
                        role="tab"
                        aria-controls="nav-option-1"
                        aria-selected="true">Option 1: Upload STS Config File (Recommended)</a>
                    <a
                        class="nav-item nav-link"
                        id="nav-home-tab"
                        data-toggle="tab"
                        href="#nav-option-2"
                        role="tab"
                        aria-controls="nav-option-2"
                        aria-selected="false">Option 2: Fill in STS configuration</a>
                </div>
            </nav>

            <div class="tab-content col-12 text-left" id="nav-tabContent">
                <div
                    class="tab-pane fade show active"
                    id="nav-option-1"
                    role="tabpanel"
                    aria-labelledby="nav-profile-tab">
                    <div class="col-lg-12">
                        <upload-sts-configuration-component 
                            @displayLabel="displayLabel">
                        </upload-sts-configuration-component>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    id="nav-option-2"
                    role="tabpanel"
                    aria-labelledby="nav-home-tab">
                    <div class="col-lg-12">
                        <div class="grid">
                            <div class="grid-body">
                                <!-- <sts-configuration-form-component
                                    @displayLabel="displayLabel"
                                    :nectar-public-key="nectarPublicKey">
                                </sts-configuration-form-component> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <information-component
            :label="selectedLabel">
        </information-component>
    </div>
</template>
<script>
import InformationComponent from "./InformationComponent.vue";

export default {
    components: { InformationComponent },
    name: 'BaseConfigurationsComponent',
    props: [
        'nectarPublicKey'
    ],
    data() {
      return {
        errors: [],
        selectedLabel: '',
        currConfiguration: Object,
        showSpinner: false,
      }
    },
    methods: {
        displayLabel: function(label) {
            this.selectedLabel = label
        },
        displaySTSConfigurationDetails: function(selectedConfiguration) {
            let self = this;
            self.currConfiguration = selectedConfiguration;
        }
    },
    async mounted() {
        let self = this
        self.showSpinner = true

        try {
            await self.$store.dispatch('fetchConfigurations')
        } catch(e) {
            self.errors.push(e)
        } finally {
            self.showSpinner = false
        }
    },
    computed: {
        getSTSConfigurations() {
            let configurations =  this.$store.getters.getSTSConfigurations
            if (configurations.length > 0) {
                this.currConfiguration = configurations[0];
            }
            this.showSpinner = false
            return configurations
        }
    }
}
</script>
