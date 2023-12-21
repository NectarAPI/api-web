<template>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <div class="checkbox mb-3">
                            <label>
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    @click="selectAll"
                                    v-model="allSelected"/>
                                <i class="input-frame"></i>
                            </label>
                        </div>
                    </th>
                    <th>Issue Date</th>
                    <th>Level</th>
                    <th>Notification</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="notifications.length == 0" style="text-align: center">
                    <td colspan="3">
                        No new notifications
                    </td>
                </tr>
                <tr v-else class="data-row"
                    v-for="notification in notifications"
                    v-bind:key="notification.ref"
                    @click="displayNotificationDetails(notification)">
                    <td>
                        <div class="checkbox mb-3">
                            <label>
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    :value="notification"
                                    v-model="selectedNotifications"
                                />
                                <i class="input-frame"></i>
                            </label>
                        </div>
                    </td>
                    <td>{{ notification.created_at }}</td>
                    <td>
                        <label v-if="notification.type == 'ERROR'" class="badge badge-danger">{{ notification.type }}</label>
                        <label v-if="notification.type == 'WARNING'" class="badge badge-warning">{{ notification.type }}</label>
                        <label v-if="notification.type == 'INFO'" class="badge badge-success">{{ notification.type }}</label>
                    </td>
                    <td>{{ notification.subject }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: 'NotificationsTableComponent',
    props: [
        'notifications'
    ],
    data() {
        return {
            errors: [],
            selectedNotifications: [],
            allSelected: false

        }

    },
    methods: {
        displayNotificationDetails: function(notification) {
            this.$emit('displayNotificationDetails', notification)
        },
        selectAll: function() {
            this.selectedNotifications = []

            if (!this.allSelected) {
                this.notifications.forEach(notification => {
                    this.selectedNotifications.push(notification)
                });
            }
        }
    },
}
</script>
<style scoped>
tr.data-row {
  cursor: pointer;
}
</style>