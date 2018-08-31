<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Choose your preferred payment method</div>
                    <div class="panel-body">
                        <section v-if="listingError">
                            <p>Failed to retrieve method listing</p>
                        </section>
                        <section v-else>
                            <div v-if="loadingListing">Loading...</div>
                            <div  v-else class="btn-group" role="group" aria-label="Payment method choices">
                                <button v-for="method in methodChoices" v-on:click="chooseMethod(method)" type="button"
                                        class="btn btn-primary">{{ method }}</button>
                            </div>
                        </section>
                        <section v-if="choiceError">
                            <p>Failed to select method</p>
                        </section>
                        <section v-if="fieldsRequired">

                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['paymentId'],
        data() {
            return {
                methodChoices: null,
                loadingListing: true,
                loadingChoiceResponse: false,
                listingError: false,
                choiceError: false,
                fieldsRequired: null
            }
        },
        mounted() {
            axios
                .get('/api/v1/payments/1/list-methods')
                .then(response => (this.methodChoices = response.data))
                .catch(error => {
                    console.log(error)
                    this.listingError = true
                })
                .finally(() => this.loadingListing = false)
        },
        methods: {
            chooseMethod: function (method) {
                this.loadingChoiceResponse = true;
                axios
                    .post('/api/v1/payments/' + this.paymentId + '/choose-method', {
                        method: method,
                        creditCardNumber: '4000000000000002',
                        creditCardHolder: 'Joe Flagster',
                        creditCardExpirationYear: 2033,
                        creditCardExpirationMonth: 8,
                        creditCardCvc: '123'
                    })
                    .then(response => (this.fieldsRequired = response.data))
                    .catch(error => {
                        console.log(error)
                        this.choiceError = true
                    })
                    .finally(() => this.loadingChoiceResponse = false)
            }
        }
    }
</script>
