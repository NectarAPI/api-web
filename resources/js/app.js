require('./bootstrap');

import BootstrapVue from 'bootstrap-vue';
import Vuex from 'vuex';
import storeData from "./store/index";

window.Vue = require('vue');  

Vue.use(BootstrapVue);
Vue.use(Vuex);

const store = new Vuex.Store(
    storeData 
 )
 

Vue.component('login-component', require('./components/auth/LoginFormComponent.vue').default);
Vue.component('register-component', require('./components/auth/RegisterFormComponent.vue').default);
Vue.component('forgot-password-component', require('./components/auth/ForgotPasswordFormComponent.vue').default);
Vue.component('reset-password-component', require('./components/auth/ResetPasswordFormComponent.vue').default);
Vue.component('user-profile-form-component', require('./components/profile/UserProfileFormComponent.vue').default);
Vue.component('public-keys-component', require('./components/public-keys/PublicKeysComponent.vue').default);
Vue.component('public-keys-table-component', require('./components/public-keys/PublicKeysTableComponent.vue').default);
Vue.component('public-key-component', require('./components/public-keys/PublicKeyComponent.vue').default);
Vue.component('edit-public-key-component', require('./components/public-keys/EditPublicKeyComponent.vue').default);
Vue.component('upload-public-key-component', require('./components/public-keys/UploadPublicKeyComponent.vue').default);

Vue.component('base-configurations-component', require('./components/configurations/BaseConfigurationsComponent.vue').default);
Vue.component('sts-configuration-details-component', require('./components/configurations/STSConfigurationDetailsComponent.vue').default);
Vue.component('sts-configurations-table-component', require('./components/configurations/STSConfigurationsTableComponent.vue').default);
Vue.component('upload-sts-configuration-component', require('./components/configurations/UploadSTSConfigurationComponent.vue').default);
Vue.component('sts-configuration-form-component', require('./components/configurations/STSConfigurationFormComponent.vue').default);
Vue.component('edit-configuration-component', require('./components/configurations/EditConfigurationComponent.vue').default);


Vue.component('credentials-component', require('./components/credentials/CredentialsComponent.vue').default);
Vue.component('credentials-table-component', require('./components/credentials/CredentialsTableComponent.vue').default);
Vue.component('credential-component', require('./components/credentials/CredentialComponent.vue').default);
Vue.component('upload-credential-component', require('./components/credentials/UploadCredentialComponent.vue').default);
Vue.component('edit-credentials-component', require('./components/credentials/EditCredentialsComponent.vue').default);
Vue.component('notifications-component', require('./components/notifications/NotificationsComponent.vue').default);
Vue.component('notification-component', require('./components/notifications/NotificationComponent.vue').default);
Vue.component('notifications-table-component', require('./components/notifications/NotificationsTableComponent.vue').default);
Vue.component('entries-selector-component', require('./components/notifications/EntriesSelectorComponent.vue').default);
Vue.component('search-component', require('./components/notifications/SearchComponent.vue').default);
Vue.component('clear-notifications-component', require('./components/notifications/ClearNotificationsComponent.vue').default);

Vue.component('requests-component', require('./components/requests/RequestsComponent.vue').default);
Vue.component('api-requests-component', require('./components/requests/ApiRequestsComponent.vue').default);
Vue.component('summary-component', require('./components/requests/SummaryComponent.vue').default);
Vue.component('requests-table-component', require('./components/requests/RequestsTableComponent.vue').default);
Vue.component('request-details-component', require('./components/requests/RequestDetailsComponent.vue').default);

Vue.component('activity-log-component', require('./components/dashboard/ActivityLogComponent.vue').default);
Vue.component('api-requests-summary-component', require('./components/dashboard/ApiRequestsSummaryComponent.vue').default);
Vue.component('credits-utilization-component', require('./components/dashboard/CreditsUtilizationComponent.vue').default);
Vue.component('dashboard-component', require('./components/dashboard/DashboardComponent.vue').default);
Vue.component('metrics-component', require('./components/dashboard/MetricsComponent.vue').default);
Vue.component('payments-distribution-component', require('./components/dashboard/PaymentsDistributionComponent.vue').default);
Vue.component('token-types-distribution-component', require('./components/dashboard/TokenTypesDistributionComponent.vue').default);

Vue.component('utilities-component', require('./components/utilities/UtilitiesComponent.vue').default);
Vue.component('utility-component', require('./components/utilities/UtilityComponent.vue').default);
Vue.component('upload-utility-component', require('./components/utilities/UploadUtilityComponent.vue').default);
Vue.component('utilities-table-component', require('./components/utilities/UtilitiesTableComponent.vue').default);
Vue.component('edit-utility-table-component', require('./components/utilities/EditUtilityComponent.vue').default);

Vue.component('meters-component', require('./components/meters/MetersComponent.vue').default);
Vue.component('meter-component', require('./components/meters/MeterComponent.vue').default);
Vue.component('edit-meter-component', require('./components/meters/EditMeterComponent.vue').default);
Vue.component('meters-table-component', require('./components/meters/MetersTableComponent.vue').default);
Vue.component('upload-meter-component', require('./components/meters/UploadMeterComponent.vue').default);

Vue.component('credits-component', require('./components/credits/CreditsComponent.vue').default);
Vue.component('credits-details-component', require('./components/credits/CreditsDetailsComponent.vue').default);
Vue.component('credits-table-component', require('./components/credits/CreditsTableComponent.vue').default);

Vue.component('simulator-component', require('./components/simulator/SimulatorComponent.vue').default);
Vue.component('generator-component', require('./components/simulator/GeneratorComponent.vue').default);
Vue.component('meter-component', require('./components/simulator/MeterComponent.vue').default);

Vue.component('buy-credits-component', require('./components/sidebar/BuyCreditsComponent.vue').default);

new Vue({
    el: '#app',
    store,
});

new Vue({
    el: '#app-1',
    store,
});