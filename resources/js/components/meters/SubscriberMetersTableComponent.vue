<template>
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="solid-header">
                    <th>Ref</th>
                    <th>Meter No</th>
                    <th>Activated</th>
                </tr>
            </thead>
            <tbody>
                 <tr v-if="meters.length == 0" style="text-align: center">
                    <td colspan="3">
                        No Meters
                    </td>
                </tr>
                <tr v-else class="data-row"
                    @click="displayMeterDetails(meter)"
                    v-for="meter in meters"
                    v-bind:key="meter.ref">
                    <td>
                        <span class="text-gray">
                            {{ meter.ref }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            {{ meter.no }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            {{ meter.activated }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: "SubscriberMetersTableComponent",
    props: [
        'meters',
    ],
    data() {
        return {};
    },
    methods: {
        displayMeterDetails: function(meter) {
            this.$emit('displayMeterDetails', meter)
        }
    },
    filters: {
        formatKey: function(string) {
            return string.substring(0, 35) + "...";
        }
    }
};
</script>
<style scoped>
tr.data-row {
    cursor: pointer;
}
.table-responsive {
    height: 60em;
    overflow-y: scroll;
}

</style>
