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
                 <tr v-if="subscribers.length == 0" style="text-align: center">
                    <td colspan="3">
                        No Subscribers
                    </td>
                </tr>
                <tr v-else class="data-row"
                    @click="displaySubscribersDetails(subscriber)"
                    v-for="subscriber in subscribers"
                    v-bind:key="subscriber.ref">
                    <td>
                        <span class="text-gray">
                            {{ subscriber.name }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            {{ subscriber.ref }}
                        </span>
                    </td>
                    <td>
                        <span class="text-gray">
                            <span v-if="subscriber.activated"
                                class="status-indicator rounded-indicator small bg-primary"
                            ></span>
                            <span v-else-if="!subscriber.activated"
                                class="status-indicator rounded-indicator small bg-secondary"
                            ></span>
                            {{ subscriber.activated }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: "SubscribersTableComponent",
    props: [
        'subscribers',
    ],
    data() {
        return {};
    },
    methods: {
        displaySubscribersDetails: function(subscriber) {
            this.$emit('displaySubscribersDetails', subscriber)
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
