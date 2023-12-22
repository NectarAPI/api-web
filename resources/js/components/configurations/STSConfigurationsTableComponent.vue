<template>
    <div class="container">
        <div class="col-md-12 text-center">
            <p v-if="errors.length">
                <ul class="list-group">
                    <li v-for="error in errors" 
                        v-bind:key="error" 
                        class="list-group-item list-group-item-danger">{{ error }}
                    </li>
                </ul>
            </p>
        </div>
        <div class="row spinner-row">
            <div class="col-10"></div>
                <div class="col-2">
                    <div
                        v-if="showSpinner"
                        id="load-details-spinner"
                        class="spinner-border text-primary float-right"
                        role="status"
                        style="height:20px; width: 20px">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="solid-header">
                            <th>Name</th>
                            <th>Ref</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="configurations.length == 0" style="text-align: center">
                            <td colspan="3">
                                No STS Configurations
                            </td>
                        </tr>
                        <tr v-else class="data-row"
                            @click="displaySTSConfigurationDetails(configuration)"
                            v-for="configuration in configurations"
                            v-bind:key="configuration.config.ref">
                            <td>
                                <span class="text-gray">
                                    {{ configuration.config.name }}
                                </span>
                            </td>
                            <td>
                                <span class="text-gray">
                                    {{ configuration.config.ref }}
                                </span>
                            </td>
                            <td>
                                <span class="text-gray">
                                    {{ configuration.config.created_at }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
</template>
<script>
export default {
    name: 'STSConfigurationsTableComponent',
    props: [
        'configurations',
        'showSpinner'
    ],
    data() {
        return {
            errors: [],
            inputDisabled: false
        };
    },
    methods: {
        displaySTSConfigurationDetails: function(configuration) {
            this.$emit('displaySTSConfigurationDetails', configuration)
        }
    }
}
</script>
<style scoped>
.spinner-row {
    margin: 0;
    padding: 0;
    position: relative;
    top: -30px;
    height: 0;
    max-height: 0;
}
.table-responsive {
    height: 411px;
    overflow-y: scroll;
}
tr.data-row {
    cursor: pointer;
}
.list-group {
    margin-bottom: 1em;
}
</style>