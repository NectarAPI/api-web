<template>
    <div class="container">
        <div class="col-12 row text-center">
            <p class="col-12 pb-2" v-if="errors.length">
                <ul class="list-group">
                    <li v-for="error in errors" 
                        v-bind:key="error" 
                        class="list-group-item list-group-item-danger">{{ error }}
                    </li>
                </ul>
            </p>
        </div>
        <div class="row spinner-row">
            <div class="col-10"></div>
            <div class="col-2">
                <div
                    v-if="showSpinner"
                    id="load-details-spinner"
                    class="spinner-border text-primary float-right"
                    role="status"
                    style="height:20px; width: 20px">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-8 equel-grid">
            <div class="grid">
              <div class="grid-body py-3">
                <div class="row">
                  <div class="col-10">
                    <p class="card-title ml-n1">Notifications</p>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-primary"
                              :disabled="inputDisabled"
                              data-toggle="modal"
                              data-target="#clear-notifications-modal"> Clear</button>
                    <clear-notifications-component
                        :clearNotificationsStatus="clearNotificationsStatus"
                        :errors="clearNotificationsErrors"
                        @clearNotifications="clearNotifications">
                    </clear-notifications-component>
                  </div>
                </div>
              </div>

              <div class="row mt-2 mb-2 pl-4">
                <search-component
                  :disabled="inputDisabled"
                  @searchTerms="searchTerms($event)">
                </search-component>
              </div>

              <div class="col-lg-12">
                <div class="grid">
                  <div class="item-wrapper">
                    <notifications-table-component
                      :searched="searched"
                      :notifications="displayedNotifications"
                      @displayNotificationDetails="displayNotificationDetails($event)"
                      ref="notificationsTable">
                    </notifications-table-component>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="col-md-4 equel-grid">
            <notification-component
              v-if="currNotification"
              :notification="currNotification">
            </notification-component>
          </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'NotificationsComponent',
    data() {
        return {
            errors: [],
            clearNotificationsErrors: [],
            showSpinner: false,
            currPage: 0,
            noOfPages: 0,
            currNotification: null,
            searched: '',
            displayedNotifications: [],
            clearNotificationsStatus: false,
            inputDisabled: false
        }
    },
    methods: {
        clearNotifications: function () {
          this.clearNotificationsErrors = []
          this.inputDisabled = true
          this.errors = []
          let selectedNotificationsObjs = this.$refs.notificationsTable.selectedNotifications

          let selectedNotifications = []

          selectedNotificationsObjs.forEach(element => {
            selectedNotifications.push(element.ref)
          });

          if (selectedNotifications.length > 0) {
            this.clearNotificationsStatus = true

            return axios
                    .put('/notif', {
                      notifications: selectedNotifications

                     })
                    .then(response => {
                      this.clearNotificationsErrors.push(response.data.status.message)

                      if (response.data.status.code == 200) {
                          let filteredItems = this.displayedNotifications.filter(item => !selectedNotificationsObjs.includes(item))
                          this.displayedNotifications = filteredItems
                          
                      }
                    })
                    .finally(() => {
                      this.clearNotificationsStatus = false
                      this.inputDisabled = false

                    })

          } else {
            this.clearNotificationsStatus = false
            this.inputDisabled = false
            this.clearNotificationsErrors.push('No notifications selected');

          }
        },
        searchTerms: function(terms) {
          this.searched = terms
          this.getNotifications()
        },
        displayNotificationDetails: function(selectedNotification) {
            this.currNotification = selectedNotification;
        },
        getNotifications: function() {
            let notifications = this.$store.getters.getNotifications
            let searched = this.searched

            if (searched) {
                this.displayedNotifications = []
                for (var notification of notifications) {
                    if (notification.subject.includes(searched)
                        || notification.text.includes(searched)
                        || notification.type.includes(searched)) {
                        this.displayedNotifications.push(notification)
                    }
                }
            } else {
                this.displayedNotifications = notifications
            }

            if (this.displayedNotifications.length > 0)
              this.currNotification = this.displayedNotifications[0]
            else
              this.currNotification = null
        }
    },
    async mounted() {
        let self = this
        self.showSpinner = true
        self.inputDisabled = true

        try {
            await self.$store.dispatch('fetchNotifications')
            this.getNotifications()
            
        } catch(e) {
            self.errors.push(e)

        } finally {
            self.showSpinner = false
            self.inputDisabled = false

        }
    },
    
}
</script>
<style scoped>
.spinner-row {
    margin: 0;
    padding: 0;
    position: relative;
    top: -30px;
    height: 0;
    max-height: 0;
}
</style>