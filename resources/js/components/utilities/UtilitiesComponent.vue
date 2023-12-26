<template>
    <div class="container">
        <div class="col-12 row text-center">
            <p v-if="errors.length">
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
                                <p class="card-title ml-n1">Utilities</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary" 
                                    data-toggle="modal"
                                    data-target="#create-utility-modal">Create</button>
                                <create-utility-component
                                    @createdUtility="createdUtility">
                                </create-utility-component>
                            </div>
                        </div>
                    </div>

                    <utilities-table-component
                        :utilities="utilities"
                        @displayUtilityDetails="displayUtilityDetails($event)">
                    </utilities-table-component>
                </div>
            </div>
            <div class="col-md-4 equel-grid">
                <utility-component
                    :utility="currUtility"></utility-component>
            </div>
        </div>
    </div>
</template>
<script>
import CreateUtilityComponent from "./CreateUtilityComponent.vue";
import UtilitiesTableComponent from "./UtilitiesTableComponent.vue";

export default {
    components: { 
        CreateUtilityComponent, 
        UtilitiesTableComponent 
    },
    name: "UtilitiesComponent",
    data() {
        return {
            errors: [],
            utilities: Array,
            currUtility: Object,
            showSpinner: false,
            editKey: ""
        };
    },
    methods: {
        createdUtility: function(utility) {
            this.utilities.push(utility);
        },
        displayUtilityDetails: function(selectedUtility) {
            let self = this;
            self.currUtility = selectedUtility;
        },
        fetchUtilities: function() {
            let self = this;

            axios
                .get("/utility")
                .then(function(response, status, request) {
                    if (response.data.status.code == 200) {
                        self.utilities = response.data.data.utilities;

                        if (self.utilities.length > 0) {
                            self.currUtility = self.utilities[0];
                        }
                    } else {
                        self.errors.push(response.data.status.message)
                    }
                    
                })
                .finally(() => {
                    self.showSpinner = false;
                });
        }
    },
    mounted: function() {
        let self = this;
        self.showSpinner = true;
        self.fetchUtilities();

    }
};
</script>