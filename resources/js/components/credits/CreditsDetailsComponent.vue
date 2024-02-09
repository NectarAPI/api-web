<template>
    <div class="grid">
        <div class="grid-body">
            <div class="split-header">
                <p class="card-title">Details</p>
            </div>

            <div class="grid">
                <div class="grid-body"
                        v-if="credits">

                    <small class="text-black font-weight-medium d-block pt-2"
                        >Ref</small>
                    <p class="text-muted">
                        {{ credits.ref }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2"
                        >Value</small>
                    <p
                        class="text-muted text-justify"
                        style="word-wrap: break-word;">
                        {{ credits.value }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Credits</small>
                    <p
                        class="text-muted text-justify"
                        style="word-wrap: break-word;">
                        {{ credits.units }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Created At
                    </small>
                    <p class="text-muted">
                        {{ credits.purchase_date  }}
                    </p>

                    <label class="badge badge-warning mt-4">Procured</label>
                </div>

                <div class="grid-body"
                        v-if="consumption">
                    <p class="pb-2 small">{{ consumption.consumption_date }}</p>

                    <small class="text-black font-weight-medium d-block pt-2"
                        >Ref</small>
                    <p class="text-muted">
                        {{ consumption.ref }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2"
                        >Units</small>
                    <p
                        class="text-muted text-justify"
                        style="word-wrap: break-word;">
                        {{ consumption.units }}
                    </p>


                    <label class="badge badge-danger mt-4">Consumed</label>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CreditsDetailsComponent',
    props: [
        'credits',
        'consumption'
    ],
    data() {
        return {

        }
    }
}
</script>
