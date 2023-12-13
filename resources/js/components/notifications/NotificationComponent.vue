<template>
    <div class="grid">
              <div class="grid-body">
                <div class="grid">
                  <div class="grid-body">
                    <p class="pb-2 small">{{ notification.created_at }}</p>

                    <small class="text-black font-weight-medium d-block pt-2">{{ notification.subject }}</small>
                    <p class="text-muted text-justify" style="word-wrap: break-word;">
                      {{ notification.text }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">Type</small>
                    
                    <label v-if="notification.type == 'ERROR'" class="badge badge-danger">{{ notification.type }}</label>
                    <label v-if="notification.type == 'WARNING'" class="badge badge-warning">{{ notification.type }}</label>
                    <label v-if="notification.type == 'INFO'" class="badge badge-success">{{ notification.type }}</label>

                    <small class="text-black font-weight-medium d-block pt-2">Affected</small>
                    
                    <span class="mr-2"
                            v-for="affected in notification.affected.split(',')"
                            v-bind:key="affected">
                      
                      <label class="badge badge-danger">
                            {{ affected }}
                      </label>
                    </span>
                      
                  </div>
                </div>
                
              </div>
            </div>
</template>
<script>
export default {
  name: 'NotificationComponent',
  props: [
    'notification'
  ],
  data() {
    return {
      errors: []
    }
  }
}
</script>