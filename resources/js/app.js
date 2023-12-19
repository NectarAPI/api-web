import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import LoginFormComponent from './components/auth/LoginFormComponent.vue';
import RegisterFormComponent from './components/auth/RegisterFormComponent.vue';
import ForgotPasswordFormComponent from './components/auth/ForgotPasswordFormComponent.vue'
import ResetPasswordFormComponent from './components/auth/ResetPasswordFormComponent.vue'
import UserProfileFormComponent from './components/profile/UserProfileFormComponent.vue'
import PublicKeysComponent from './components/public-keys/PublicKeysComponent.vue'
import PublicKeysTableComponent from './components/public-keys/PublicKeysTableComponent.vue'
import PublicKeyComponent from './components/public-keys/PublicKeyComponent.vue'
import EditPublicKeyComponent from './components/public-keys/EditPublicKeyComponent.vue'
import UploadPublicKeyComponent from './components/public-keys/UploadPublicKeyComponent.vue'

import BaseConfigurationsComponent from './components/configurations/BaseConfigurationsComponent.vue'
import STSConfigurationDetailsComponent from './components/configurations/STSConfigurationDetailsComponent.vue'
import STSConfigurationsTableComponent from './components/configurations/STSConfigurationsTableComponent.vue'
import UploadSTSConfigurationComponent from './components/configurations/UploadSTSConfigurationComponent.vue'
import STSConfigurationFormComponent from './components/configurations/STSConfigurationFormComponent.vue'
import EditConfigurationComponent from './components/configurations/EditConfigurationComponent.vue'

import CredentialsComponent from './components/credentials/CredentialsComponent.vue'
import CredentialsTableComponent from './components/credentials/CredentialsTableComponent.vue'
import CredentialComponent from './components/credentials/CredentialComponent.vue'
import UploadCredentialComponent from './components/credentials/UploadCredentialComponent.vue'
import EditCredentialsComponent from './components/credentials/EditCredentialsComponent.vue'
import NotificationsComponent from './components/notifications/NotificationsComponent.vue'
import NotificationComponent from './components/notifications/NotificationComponent.vue'
import NotificationsTableComponent from './components/notifications/NotificationsTableComponent.vue'
import EntriesSelectorComponent from './components/notifications/EntriesSelectorComponent.vue'
import SearchComponent from './components/notifications/SearchComponent.vue'
import ClearNotificationsComponent from './components/notifications/ClearNotificationsComponent.vue'

import RequestsComponent from './components/requests/RequestsComponent.vue'
import ApiRequestsComponent from './components/requests/ApiRequestsComponent.vue'
import SummaryComponent from './components/requests/SummaryComponent.vue'
import RequestsTableComponent from './components/requests/RequestsTableComponent.vue'
import RequestDetailsComponent from './components/requests/RequestDetailsComponent.vue'

import ActivityLogComponent from './components/dashboard/ActivityLogComponent.vue'
import ApiRequestsSummaryComponent from './components/dashboard/ApiRequestsSummaryComponent.vue'
import CreditsUtilizationComponent from './components/dashboard/CreditsUtilizationComponent.vue'
import DashboardComponent from './components/dashboard/DashboardComponent.vue'
import MetricsComponent from './components/dashboard/MetricsComponent.vue'
import PaymentsDistributionComponent from './components/dashboard/PaymentsDistributionComponent.vue'
import TokenTypesDistributionComponent from './components/dashboard/TokenTypesDistributionComponent.vue'

import UtilitiesComponent from './components/utilities/UtilitiesComponent.vue'
import UtilityComponent from './components/utilities/UtilityComponent.vue'
import UploadUtilityComponent from './components/utilities/UploadUtilityComponent.vue'
import UtilitiesTableComponent from './components/utilities/UtilitiesTableComponent.vue'
import EditUtilityComponent from './components/utilities/EditUtilityComponent.vue'

import SubscriberMetersComponent from './components/meters/SubscriberMetersComponent.vue'
import SubscriberMeterComponent from './components/meters/SubscriberMeterComponent.vue'
import EditMeterComponent from './components/meters/EditMeterComponent.vue'
import SubscriberMetersTableComponent from './components/meters/SubscriberMetersTableComponent.vue'
import UploadMeterComponent from './components/meters/UploadMeterComponent.vue'

import CreditsComponent from './components/credits/CreditsComponent.vue'
import CreditsDetailsComponent from './components/credits/CreditsDetailsComponent.vue'
import CreditsTableComponent from './components/credits/CreditsTableComponent.vue'

import SimulatorComponent from './components/simulator/SimulatorComponent.vue'
import GeneratorComponent from './components/simulator/GeneratorComponent.vue'
import MeterComponent from './components/simulator/MeterComponent.vue'

import BuyCreditsComponent from './components/sidebar/BuyCreditsComponent.vue'


app.component('login-component', LoginFormComponent);
app.component('register-component', RegisterFormComponent);
app.component('forgot-password-component', ForgotPasswordFormComponent);
app.component('reset-password-component', ResetPasswordFormComponent);
app.component('user-profile-form-component', UserProfileFormComponent);
app.component('public-keys-component', PublicKeyComponent);
app.component('public-keys-table-component', PublicKeysTableComponent);
app.component('public-key-component', PublicKeyComponent);
app.component('edit-public-key-component', EditPublicKeyComponent);
app.component('upload-public-key-component', UploadPublicKeyComponent);

app.component('base-configurations-component', BaseConfigurationsComponent);
app.component('sts-configuration-details-component', STSConfigurationDetailsComponent);
app.component('sts-configurations-table-component', STSConfigurationsTableComponent);
app.component('upload-sts-configuration-component', UploadSTSConfigurationComponent);
app.component('sts-configuration-form-component', STSConfigurationFormComponent);
app.component('edit-configuration-component', EditConfigurationComponent);


app.component('credentials-component', CredentialsComponent);
app.component('credentials-table-component', CredentialsTableComponent);
app.component('credential-component', CredentialComponent);
app.component('upload-credential-component', UploadCredentialComponent);
app.component('edit-credentials-component', EditCredentialsComponent);
app.component('notifications-component', NotificationsComponent);
app.component('notification-component',NotificationComponent);
app.component('notifications-table-component', NotificationsTableComponent);
app.component('entries-selector-component', EntriesSelectorComponent);
app.component('search-component', SearchComponent);
app.component('clear-notifications-component', ClearNotificationsComponent);

app.component('requests-component', RequestsComponent);
app.component('api-requests-component', ApiRequestsComponent);
app.component('summary-component', SummaryComponent);
app.component('requests-table-component', RequestsTableComponent);
app.component('request-details-component', RequestDetailsComponent);

app.component('activity-log-component', ActivityLogComponent);
app.component('api-requests-summary-component', ApiRequestsSummaryComponent);
app.component('credits-utilization-component', CreditsUtilizationComponent);
app.component('dashboard-component', DashboardComponent);
app.component('metrics-component', MetricsComponent);
app.component('payments-distribution-component', PaymentsDistributionComponent);
app.component('token-types-distribution-component', TokenTypesDistributionComponent);

app.component('utilities-component', UtilitiesComponent);
app.component('utility-component', UtilityComponent);
app.component('upload-utility-component', UploadUtilityComponent);
app.component('utilities-table-component', UtilitiesTableComponent);
app.component('edit-utility-table-component', EditUtilityComponent);

app.component('subscriber-meters-component', SubscriberMetersComponent);
app.component('subscriber-meter-component', SubscriberMeterComponent);
app.component('edit-meter-component', EditMeterComponent);
app.component('subscriber-meters-table-component', SubscriberMetersTableComponent);
app.component('upload-meter-component', UploadMeterComponent);

app.component('credits-component', CreditsComponent);
app.component('credits-details-component', CreditsDetailsComponent);
app.component('credits-table-component', CreditsTableComponent);

app.component('simulator-component', SimulatorComponent);
app.component('generator-component', GeneratorComponent);
app.component('meter-component', MeterComponent);

app.component('buy-credits-component', BuyCreditsComponent);

app.mount('#app');
