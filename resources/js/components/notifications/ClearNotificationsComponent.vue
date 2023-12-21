<template>
    <div class="modal fade" 
        tabindex="-1" 
        id="clear-notifications-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clear notifications</h5>
                    <button type="button" 
                            class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                        data-dismiss="modal">Cancel</button>
                    <button type="button" :disabled="buttonSubmitDisabled" 
                        @click="onSubmitClearNotifications" class="btn btn-primary">
                        Save &nbsp;&nbsp;   
                        <div v-if="saveSpinner" 
                            id="save-spinner" 
                                class="spinner-border text-secondary" 
                                role="status">
                                <span class="sr-only">Loading...</span>
                        </div> 
                    </button>
                </div>
            </div>
        </div>
    </div>
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