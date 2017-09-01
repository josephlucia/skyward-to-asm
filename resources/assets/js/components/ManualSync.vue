<template>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-bordered" style="margin-bottom: 8px;">
                    <thead>
                        <tr>
                            <th>Table</th>
                            <th>Status</th>
                            <th>Total Records</th>
                            <th width="100"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Locations</td>
                            <td>{{ locations.status }}</td>
                            <td>{{ locations.rows }}</td>
                            <td height="47">
                                <button class="btn btn-info btn-sm" @click="updateLocations" v-if="credentials === 'valid'">
                                    <i v-show="locations.loading" class="fa fa-refresh fa-icon fa-spin fa-fw"></i>
                                    <i v-show="!locations.loading" class="fa fa-refresh fa-icon"></i>
                                    Manual Sync
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Staff</td>
                            <td>{{ staff.status }}</td>
                            <td>{{ staff.rows }}</td>
                            <td height="47">
                                <button class="btn btn-info btn-sm" @click="updateStaff" v-if="locations.rows > 0">
                                    <i v-show="staff.loading" class="fa fa-refresh fa-icon fa-spin fa-fw"></i>
                                    <i v-show="!staff.loading" class="fa fa-refresh fa-icon"></i>
                                    Manual Sync
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Students</td>
                            <td>{{ students.status }}</td>
                            <td>{{ students.rows }}</td>
                            <td height="47">
                                <button class="btn btn-info btn-sm" @click="updateStudents" v-if="locations.rows > 0">
                                    <i v-show="students.loading" class="fa fa-refresh fa-icon fa-spin fa-fw"></i>
                                    <i v-show="!students.loading" class="fa fa-refresh fa-icon"></i>
                                    Manual Sync
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Courses</td>
                            <td>{{ courses.status }}</td>
                            <td>{{ courses.rows }}</td>
                            <td height="47">
                                <button class="btn btn-info btn-sm" @click="updateCourses" v-if="locations.rows > 0">
                                    <i v-show="courses.loading" class="fa fa-refresh fa-icon fa-spin fa-fw"></i>
                                    <i v-show="!courses.loading" class="fa fa-refresh fa-icon"></i>
                                    Manual Sync
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sections</td>
                            <td>{{ sections.status }}</td>
                            <td>{{ sections.rows }}</td>
                            <td height="47">
                                <button class="btn btn-info btn-sm" @click="updateSections" v-if="locations.rows > 0">
                                    <i v-show="sections.loading" class="fa fa-refresh fa-icon fa-spin fa-fw"></i>
                                    <i v-show="!sections.loading" class="fa fa-refresh fa-icon"></i>
                                    Manual Sync
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Rosters</td>
                            <td>{{ rosters.status }}</td>
                            <td>{{ rosters.rows }}</td>
                            <td height="47">
                                <button class="btn btn-info btn-sm" @click="updateRosters" v-if="locations.rows > 0">
                                    <i v-show="rosters.loading" class="fa fa-refresh fa-icon fa-spin fa-fw"></i>
                                    <i v-show="!rosters.loading" class="fa fa-refresh fa-icon"></i>
                                    Manual Sync
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['credentials'],

        /*
         * The component's data.
         */
        data() {
            return {
                locations: {
                    loading: false,
                    status: 'idle',
                    rows: 0
                },
                staff: {
                    loading: false,
                    status: 'idle',
                    rows: 0
                },
                students: {
                    loading: false,
                    status: 'idle',
                    rows: 0
                },
                courses: {
                    loading: false,
                    status: 'idle',
                    rows: 0
                },
                sections: {
                    loading: false,
                    status: 'idle',
                    rows: 0
                },
                rosters: {
                    loading: false,
                    status: 'idle',
                    rows: 0
                },
                errors: []
            };
        },

        /**
         * Mount the component.
         */
        mounted() {
            this.countLocations();
            this.countStaff();
            this.countStudents();
            this.countCourses();
            this.countSections();
            this.countRosters();
        },

        methods: {
            countLocations: function () {
                axios.get(App.url + '/locations/count')
                    .then(response => {
                        this.locations.rows = response.data;
                    });
            },

            countStaff: function () {
                axios.get(App.url + '/staff/count')
                    .then(response => {
                        this.staff.rows = response.data;
                    });
            },

            countStudents: function () {
                axios.get(App.url + '/students/count')
                    .then(response => {
                        this.students.rows = response.data;
                    });
            },

            countCourses: function () {
                axios.get(App.url + '/courses/count')
                    .then(response => {
                        this.courses.rows = response.data;
                    });
            },

            countSections: function () {
                axios.get(App.url + '/sections/count')
                    .then(response => {
                        this.sections.rows = response.data;
                    });
            },

            countRosters: function () {
                axios.get(App.url + '/rosters/count')
                    .then(response => {
                        this.rosters.rows = response.data;
                    });
            },

            updateLocations: function () {
                this.locations.loading = true;
                this.locations.status = 'syncing';
                
                axios.get(App.url + '/locations/store')
                    .then(response => {
                        this.locations.loading = false;
                        this.locations.status = 'idle';

                        this.countLocations();
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.locations.loading = false;
                            this.locations.status = 'error';
                        } else {
                            this.locations.loading = false;
                            this.locations.status = 'failed';
                        }
                    });
            },

            updateStaff: function () {
                this.staff.loading = true;
                this.staff.status = 'syncing';
                
                axios.get(App.url + '/staff/store')
                    .then(response => {
                        this.staff.loading = false;
                        this.staff.status = 'idle';

                        this.countStaff();
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.staff.loading = false;
                            this.staff.status = 'error';
                        } else {
                            this.staff.loading = false;
                            this.staff.status = 'failed';
                        }
                    });
            },

            updateStudents: function () {
                this.students.loading = true;
                this.students.status = 'syncing';
                
                axios.get(App.url + '/students/store')
                    .then(response => {
                        this.students.loading = false;
                        this.students.status = 'idle';

                        this.countStudents();
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.students.loading = false;
                            this.students.status = 'error';
                        } else {
                            this.students.loading = false;
                            this.students.status = 'failed';
                        }
                    });
            },

            updateCourses: function () {
                this.courses.loading = true;
                this.courses.status = 'syncing';
                
                axios.get(App.url + '/courses/store')
                    .then(response => {
                        this.courses.loading = false;
                        this.courses.status = 'idle';

                        this.countCourses();
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.courses.loading = false;
                            this.courses.status = 'error';
                        } else {
                            this.courses.loading = false;
                            this.courses.status = 'failed';
                        }
                    });
            },

            updateSections: function () {
                this.sections.loading = true;
                this.sections.status = 'syncing';
                
                axios.get(App.url + '/sections/store')
                    .then(response => {
                        this.sections.loading = false;
                        this.sections.status = 'idle';

                        this.countSections();
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.sections.loading = false;
                            this.sections.status = 'error';
                        } else {
                            this.sections.loading = false;
                            this.sections.status = 'failed';
                        }
                    });
            },

            updateRosters: function () {
                this.rosters.loading = true;
                this.rosters.status = 'syncing';
                
                axios.get(App.url + '/rosters/store')
                    .then(response => {
                        this.rosters.loading = false;
                        this.rosters.status = 'idle';

                        this.countRosters();
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.rosters.loading = false;
                            this.rosters.status = 'error';
                        } else {
                            this.rosters.loading = false;
                            this.rosters.status = 'failed';
                        }
                    });
            }
        }               
    }
</script>
