<template>
<div class="panel panel-default" v-show="credentials.valid">
    <div class="panel-heading">
    	<div class="panel-split">
        	<div class="panel-component-heading">Nightly Sync Status</div>
        	<span class="label label-success" v-if="credentials.sync">Enabled</span>
        	<span class="label label-danger" v-else>Disabled</span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-split">
            <div class="btn-group">
                <button type="button" class="btn btn-default" :class="credentials.sync == true ? 'active' : ''" @click="updateSync(1)">
                    Sync Enabled
                </button>
                <button type="button" class="btn btn-default" :class="credentials.sync == false ? 'active' : ''" @click="updateSync(0)">
                    Sync Disabled
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
    	data() {
    		return {
    			credentials: {},
    			error: ''
    		}
    	},

    	mounted() {
    		this.getCredentialsSync();
    	},

    	methods: {
            getCredentialsSync: function () {
                axios.get(App.url + '/credentials')
                    .then(response => {
                        this.credentials = response.data;
                    });
            },

            updateSync: function (status) {
            	axios.patch(App.url + '/credentials/sync/' + status)
            		.then(response => {
            			this.getCredentialsSync();
            		})
            		.catch(error => {
            			this.error = 'Something has gone wrong with the sync update.'
            		});
            }
    	}
    }
</script>