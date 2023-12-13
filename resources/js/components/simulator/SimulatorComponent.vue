<template>
    <div class="content-viewport">

        <div class="row">
            <nav class="col-12">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a
                        class="nav-item nav-link active"
                        id="nav-profile-tab"
                        data-toggle="tab"
                        href="#nav-option-1"
                        role="tab"
                        aria-controls="nav-option-1"
                        aria-selected="true"
                        >Token Generator</a
                    >
                    <a
                        class="nav-item nav-link"
                        id="nav-home-tab"
                        data-toggle="tab"
                        href="#nav-option-2"
                        role="tab"
                        aria-controls="nav-option-2"
                        aria-selected="false"
                        >Meter Simulator</a
                    >
                </div>
            </nav>

            <div class="tab-content col-12 text-left" id="nav-tabContent">
                <div
                    class="tab-pane fade show active"
                    id="nav-option-1"
                    role="tabpanel"
                    aria-labelledby="nav-profile-tab"
                >
                    <div class="col-lg-12">
                        <generator-component
                            :sts_configs="sts_configs"
                            :sts_config_options="sts_config_options">
                        </generator-component>
                    </div>
                </div>

                <div
                    class="tab-pane fade"
                    id="nav-option-2"
                    role="tabpanel"
                    aria-labelledby="nav-home-tab"
                >
                    <div class="col-lg-12">
                        <div class="grid">
                            <div class="grid-body">
                                <meter-component
                                    :sts_configs="sts_configs"
                                    :sts_config_options="sts_config_options">
                                </meter-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'SimulatorComponent',
    data() {
        return {
            sts_configs: [],
            sts_config_options: []
        }
    },
    methods: {
        getSTSConfigurations() {
            this.sts_configs =  this.$store.getters.getSTSConfigurations
            this.sts_configs.forEach(config => {
                this.sts_config_options.push({
                    value: config.config.ref,
                    text: config.config.name
                })
            });
        }
    },
    async mounted() {
        let self = this

        try {
            await self.$store.dispatch('fetchConfigurations')
            self.getSTSConfigurations()

        } catch(e) {
            self.errors.push(e)
        }
    }

}
</script>