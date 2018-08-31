<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Details of your payment order</div>
                    <div class="panel-body">
                        <section v-if="errored">
                            <p>Failed to retrieve data</p>
                        </section>
                        <section v-else>
                            <div v-if="loading">Loading...</div>
                            <div v-else>
                                <ul class="list-group">
                                    <li class="list-group-item">Reference: {{ info.reference }}</li>
                                    <li class="list-group-item">Amount: {{ info.amount_in_cents / 100 }}</li>
                                    <li class="list-group-item">Currency: {{ info.currency }}</li>
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                info: null,
                loading: true,
                errored: false
            }
        },
        mounted() {
            axios
                .get('/api/v1/payments/1')
                .then(response => (this.info = response.data))
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)
        }
    }
</script>
