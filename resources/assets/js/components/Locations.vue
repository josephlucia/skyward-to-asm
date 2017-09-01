<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                loading: false,
                locations: [],
                errors: []
            };
        },

        /**
         * Mount the component.
         */
        mounted() {
            this.getLocations();
        },

        methods: {
            /**
             * Get the locations from the database.
             */
            getLocations: function () {
                axios.get(App.url + '/locations/all')
                    .then(response => {
                        this.locations = response.data;
                    });
            },

            /**
             * Update the location sync settings.
             */
            updateSync: function (location) {
                axios.put(App.url + '/locations/' + location.id, location)
                    .then(response => {
                        this.getLocations();
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            }
        }               
    }
</script>
