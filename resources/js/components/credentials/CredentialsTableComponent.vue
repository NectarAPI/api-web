<template>
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="solid-header">
                    <th>Ref</th>
                    <th>Created At</th>
                    <th>Activated</th>
                </tr>
            </thead>
            <tbody>
                 <tr v-if="credentials.length == 0" style="text-align: center">
                    <td colspan="3">
                        No Credentials
                    </td>
                </tr>
                <tr v-else class="data-row"
                    @click="displayCredentialsDetails(credential)"
                    v-for="credential in credentials"
                    v-bind:key="credential.ref">
                    <td>
                        <span class="text-gray">
                            {{ credential.ref }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            {{ credential.createdAt }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            <span v-if="credential.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span v-else-if="!credential.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ credential.activated }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: "CredentialsTableComponent",
    props: [
        'credentials',
    ],
    data() {
        return {};
    },
    methods: {
        displayCredentialsDetails: function(credential) {
            this.$emit('displayCredentialsDetails', credential)
        }
    },
    filters: {
        formatRef: function(string) {
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
    height: 42em;
    overflow-y: scroll;
}
</style>