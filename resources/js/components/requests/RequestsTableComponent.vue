<template>
    <div class="grid col-md-8 col-12">
        <div class="grid-body py-3">
            <p class="card-title ml-n1">
                Token Requests
            </p>
            <div class="content-wrapper v-centered spinner">
                <span
                    class="btn action-btn btn-refresh btn-xs component-flat">
                    <i class="mdi mdi-autorenew text-muted mdi-2x"
                        :class="{ spin: showSpinner }"></i>
                </span>
            </div> 
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="solid-header">
                        <th>Ref</th>
                        <th>Created</th>
                        <th>Token No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="requests.length == 0" style="text-align: center">
                        <td colspan="4">
                            No requests
                        </td>
                    </tr>
                    <tr v-else class="data-row"
                        v-for="request in requests"
                        v-bind:key="request.ref"
                        @click="displayRequestDetails(request)">
                        <td>
                            <span class="text-gray">
                                {{ request.ref }}
                            </span>
                        </td>
                        <td>
                            <span class="text-gray">
                               {{ request.created_at }}
                            </span>
                        </td>
                        <td>
                            <span class="text-gray">
                                <span
                                    class="status-indicator rounded-indicator small bg-primary">
                                    </span>
                                    {{ request.token_no }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    name: 'RequestsTableComponent',
    data() {
        return {
            currRequest: null,
            requests: [],
            showSpinner: false
        }
    },
    methods: {
        displayRequestDetails: function(request) {
            this.$emit('displayRequestDetails', request)
        }
    },
    async mounted() {
        try {
            let self = this
            self.showSpinner = true

            return axios
                    .get('/tokenRequests')
                    .then(response => {
                        if (response.data.status.code == 200) {
                            self.requests = response.data.data
                            self.currRequest = self.requests[0]

                        } else {
                            throw response.data.status.message

                        }
                    }).finally(() => {
                        self.showSpinner = false
                    })
                    .catch(err => {
                        throw err
                    });

        } catch(e) {
            self.errors.push(e)
            
        }
    }
}
</script>
<style scoped>
tr.data-row {
  cursor: pointer;
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
.spinner {
    float: right;
    position: relative;
    top: -20px
}
.table-responsive {
    height: 30em;
    overflow-y: scroll;
}
</style>