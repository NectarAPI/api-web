<template>
    <div class="component">
        <metrics-component></metrics-component>
        <div class="row">
            <api-requests-summary-component></api-requests-summary-component>
            <token-types-distribution-component></token-types-distribution-component>
        </div>
        <div class="row">
            <payments-distribution-component></payments-distribution-component>
            <credits-utilization-component></credits-utilization-component>
        </div>
        <div class="row">
            <requests-table-component></requests-table-component>
            <activity-log-component></activity-log-component>
        </div>
    </div>
</template>
<script>
export default {
    name: 'DashboardComponent',
    data() {
        return {
           
        }
    }
}
</script>
