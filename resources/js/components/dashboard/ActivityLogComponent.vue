<template>
    <div class="col-md-4 equel-grid">
        <div class="grid">
            <div class="grid-body">
                <div class="split-header">
                    <p class="card-title">Activity Log</p>
                    <div class="content-wrapper v-centered">
                        <span
                            class="btn action-btn btn-refresh btn-xs component-flat">
                            <i class="mdi mdi-autorenew text-muted mdi-2x"
                                :class="{ spin: showSpinner }"></i>
                        </span>
                    </div>
                </div>
                <div class="vertical-timeline-wrapper">
                    <div class="timeline-vertical dashboard-timeline">

                        <div v-for="log in activityLogs"
                            v-bind:key="log.ref"
                            class="activity-log">
                            <p class="log-name">{{ log.category.notes }}</p>
                            <div class="log-details">
                                {{ log.description }}<span
                                    class="text-primary ml-1"
                                ></span>
                            </div>
                            <small class="log-time">{{ log.updated_at }}</small>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ActivityLogComponent',
    data(){
        return {
            errors: [],
            activityLogs: [],
            showSpinner: false
        }
    },
    methods: {
        getActivityLog: function() {
            this.showSpinner = true
             return axios 
                .get('/getActivityLog')
                .then(response => {
                    
                    if (response.data.status.code == 200) {
                        this.activityLogs = response.data.data

                    } else {
                        self.errors.push(response.data.status.message)
                        
                    }
                })
                .finally(() => {
                    this.showSpinner = false
                })
        }
    },
    async mounted() {
        let self = this
        self.getActivityLog()
    }
}
</script>
<style scoped>
.dashboard-timeline {
    min-height: 30em;
}
@keyframes spin-animation {
  to {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.spin:before {
  display: block;
  transform-origin: center center;
  -webkit-backface-visibility: hidden;
  -webkit-animation: spin-animation 2s linear infinite;
  animation: spin-animation 2s linear infinite;
}
</style>