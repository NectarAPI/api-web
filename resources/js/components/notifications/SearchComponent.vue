<template>
    <div class="col-sm-12 col-md-4">
        <form>
            <div class="input-group pr-2">
                <input @keyup="sendSearchTerm($event.target.value)" :disabled="disabled" type="text" class="form-control" placeholder="Search" />
            </div>
        </form>
    </div>
</template>
<script>
export default {
    name: 'SearchComponent',
    props: [
        'disabled'
    ],
    methods: {
        sendSearchTerm: function(val) {
            this.$emit('searchTerms', val)
        }
    }
}
</script>