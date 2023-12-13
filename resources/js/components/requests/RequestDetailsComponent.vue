<template>
    <div class="grid">
        <div class="grid-body">
            <div class="split-header">
                <p class="card-title">Details</p>
            </div>

            <div class="grid">
                <div class="grid-body">
                    <small class="text-black font-weight-medium d-block pt-2">
                        Created
                    </small>
                    <p class="pb-4 small">{{ request.created_at }}</p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Ref
                    </small>
                    <p class="text-muted pb-4">
                       {{ request.ref }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Type
                    </small>
                    <p class="text-muted pb-4">
                       {{ request.token_type }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Token
                    </small>
                    <p class="text-muted pb-4">
                       {{ request.token_no }}
                    </p>

                    <small class="text-black font-weight-medium d-block pt-2">
                        Meter
                    </small>
                    <p class="text-muted pb-4">
                       {{ request.meter_no }}
                    </p>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'RequestDetailsComponent',
    props: [
        'request'
    ]
}
</script>