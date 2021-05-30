<script type="text/ecmascript-6">
import moment from "moment-timezone";

export default {
    props: ["status"],
    data() {
        return {
            jobNameSearch: '',
            createdAtFromSearch: '',
            createdAtToSearch: '',
        }
    },
    methods: {
        loadJobNames(jobName) {
            return new Promise(resolve => {
                if (jobName.length < 3) {
                    return resolve([])
                }

                let queryParams = new URLSearchParams({status: this.status, name: jobName}).toString()

                this.$http.get(Horizon.basePath + '/api/jobs/search?' + queryParams)
                    .then(response => resolve(response.data))
            })
        },

        setJobName(selectedJobName) {
            if (!selectedJobName) {
                return;
            }

            this.jobNameSearch = selectedJobName
            this.fireEventUpdated()
        },

        clear() {
            this.$refs["jobNameField"].setValue('')
            this.jobNameSearch = ''
            this.createdAtFromSearch = ''
            this.createdAtToSearch = ''

            this.fireEventUpdated()
        },

        formatDateToUtc(dateString) {
            if (!dateString) {
                return dateString
            }

            return moment(dateString).subtract(new Date().getTimezoneOffset() / 60)
        },

        fireEventUpdated() {
            this.$emit("updated", {
                job_name: this.jobNameSearch,
                created_at_from: this.formatDateToUtc(this.createdAtFromSearch),
                created_at_to: this.formatDateToUtc(this.createdAtToSearch),
            })
        }
    }
}
</script>

<template>
    <div class="card p-2 mb-2">
        <div class="row">
            <div class="col-5">
                <label>Jobs name: </label>

                <autocomplete
                    ref="jobNameField"
                    :search="loadJobNames"
                    placeholder="Search for a Job name"
                    aria-label="Search for a Job name"
                    :debounceTime="500"
                    @submit="setJobName"
                ></autocomplete>
            </div>
            <div class="col-3">
                <label>Created at from: </label>
                <input class="datetime" type="datetime-local" v-model="createdAtFromSearch" @change="fireEventUpdated">
            </div>
            <div class="col-3">
                <label>Created at to: </label>
                <input class="datetime" type="datetime-local" v-model="createdAtToSearch" @change="fireEventUpdated">
            </div>

            <div class="col-1 pt-2">
                <label></label>
                <button class="btn btn-danger mt-4" @click="clear">X</button>
            </div>
        </div>
    </div>
</template>
