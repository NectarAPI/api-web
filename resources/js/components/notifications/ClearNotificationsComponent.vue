<template>
        <b-modal
        id="clear-notifications-modal"
        title="Clear notifications">
            <div class="col-md-12 text-center mb-2">
                <p v-if="errors.length">
                    <ul class="list-group">
                        <li v-for="error in errors" 
                            v-bind:key="error" 
                            class="list-group-item list-group-item-danger">{{ error }}
                        </li>
                    </ul>
                </p>
            </div>
           <p>Are you sure you want to mark selected notifications as read?</p>
            <div slot="modal-footer">
                    <b-btn variant="secondary">Cancel</b-btn>
                    <b-btn :disabled="buttonSubmitDisabled" variant="primary" @click="onSubmitClearNotifications">
                        Save &nbsp;&nbsp;   
                        <div v-if="clearNotificationsStatus" 
                            id="save-spinner" 
                                class="spinner-border text-secondary" 
                                role="status">
                                <span class="sr-only">Loading...</span>
                        </div> 
                    </b-btn>
                </div>
        </b-modal>
</template>
<script>
export default {
    name: 'ClearNotificationsComponent',
    props: [
        'clearNotificationsStatus',
        'errors'
    ],
    data() {
        return {
            buttonSubmitDisabled: false
        }
    },
    methods: {
        onSubmitClearNotifications: function () {
            this.$emit('clearNotifications')
        }
    }
}
</script>