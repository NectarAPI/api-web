<template>
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="solid-header">
                    <th>Name</th>
                    <th>Ref</th>
                    <th>Activated</th>
                </tr>
            </thead>
            <tbody>
                 <tr v-if="utilities.length == 0" style="text-align: center">
                    <td colspan="3">
                        No Utilities
                    </td>
                </tr>
                <tr v-else class="data-row"
                    @click="displayUtilityDetails(utility)"
                    v-for="utility in utilities"
                    v-bind:key="utility.ref">
                    <td>
                        <span class="text-gray">
                            {{ utility.name }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            {{ utility.ref }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            <span v-if="utility.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span v-else-if="!utility.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ utility.activated }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: "UtilitiesTableComponent",
    props: [
        'utilities',
    ],
    data() {
        return {};
    },
    methods: {
        displayUtilityDetails: function(utility) {
            this.$emit('displayUtilityDetails', utility)
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
