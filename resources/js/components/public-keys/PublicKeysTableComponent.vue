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
                 <tr v-if="publicKeys.length == 0" style="text-align: center">
                    <td colspan="3">
                        No Public Keys
                    </td>
                </tr>
                <tr v-else class="data-row"
                    @click="displayPublicKeyDetails(publicKey)"
                    v-for="publicKey in publicKeys"
                    v-bind:key="publicKey.ref"
                >
                    <td>
                        <span class="text-gray">
                            {{ publicKey.name }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            {{ publicKey.ref }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            <span v-if="publicKey.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span v-else-if="!publicKey.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ publicKey.activated }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: "PublicKeysTableComponent",
    props: [
        'publicKeys',
    ],
    data() {
        return {};
    },
    methods: {
        displayPublicKeyDetails: function(publicKey) {
            this.$emit('displayPublicKeyDetails', publicKey)
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
